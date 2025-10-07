<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CollectionSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PickupController extends Controller
{
    public function create()
    {
        // Si necesitas empresas para un select:
        $companies = \App\Models\CollectorCompany::query()
            ->orderBy('name')->get(['id','name']);

        $user = Auth::user();
        $rules = config('collection_rules');
        $organicDayNumber = $user->locality
            ? ($rules['organic_days'][$user->locality] ?? null)
            : null;
        $organicDayLabel = $organicDayNumber
            ? ($rules['day_labels'][$organicDayNumber] ?? null)
            : null;

        return view('user.pickups.create', [
            'companies' => $companies,
            'organicDayLabel' => $organicDayLabel,
            'limits' => [
                'organic' => $rules['limits']['organic_per_week'] ?? 1,
                'inorganic' => $rules['limits']['inorganic_per_week'] ?? 2,
                'hazardous' => $rules['limits']['hazardous_per_month'] ?? 1,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->merge([
            'address' => $request->input('address') ?: $user->address,
        ]);

        $data = $request->validate([
            'collector_company_id' => ['required','exists:collector_companies,id'],
            'address'              => ['required','string','max:255'],
            'scheduled_for_date'   => ['required','date'],
            'scheduled_for_time'   => ['required'],
            'estimated_weight'     => ['nullable','numeric','min:0'],
            'notes'                => ['nullable','string','max:1000'],
            'type'                 => ['required','string','max:50','in:'.implode(',', [
                CollectionSchedule::TYPE_INORGANIC,
                CollectionSchedule::TYPE_HAZARDOUS,
                CollectionSchedule::TYPE_ORGANIC,
            ])],
        ]);

        $scheduledFor = "{$data['scheduled_for_date']} {$data['scheduled_for_time']}";
        $rules = config('collection_rules');
        $scheduledAt = Carbon::parse($scheduledFor);
        $weekStart = $scheduledAt->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $scheduledAt->copy()->endOfWeek(Carbon::SUNDAY);

        if ($data['type'] === CollectionSchedule::TYPE_ORGANIC) {
            $assignedDay = $user->locality
                ? ($rules['organic_days'][$user->locality] ?? null)
                : null;

            if (! $assignedDay) {
                return back()
                    ->withErrors([
                        'type' => 'Actualiza tu localidad en el perfil para programar la recolección de residuos orgánicos.',
                    ])
                    ->withInput();
            }

            if ($assignedDay && $scheduledAt->isoWeekday() !== $assignedDay) {
                $dayLabel = $rules['day_labels'][$assignedDay] ?? 'el día asignado';
                return back()
                    ->withErrors([
                        'scheduled_for_date' => "Los residuos orgánicos de tu localidad se recogen los {$dayLabel}.",
                    ])
                    ->withInput();
            }

            $organicLimit = $rules['limits']['organic_per_week'] ?? 1;
            $existingOrganic = CollectionSchedule::where('user_id', $user->id)
                ->where('type', CollectionSchedule::TYPE_ORGANIC)
                ->whereBetween('scheduled_for', [$weekStart, $weekEnd])
                ->count();

            if ($existingOrganic >= $organicLimit) {
                return back()
                    ->withErrors([
                        'type' => "Ya tienes programada la recolección orgánica de esta semana.",
                    ])
                    ->withInput();
            }
        }

        if ($data['type'] === CollectionSchedule::TYPE_INORGANIC) {
            $inorganicLimit = $rules['limits']['inorganic_per_week'] ?? 2;
            $existingInorganic = CollectionSchedule::where('user_id', $user->id)
                ->where('type', CollectionSchedule::TYPE_INORGANIC)
                ->whereBetween('scheduled_for', [$weekStart, $weekEnd])
                ->count();

            if ($existingInorganic >= $inorganicLimit) {
                return back()
                    ->withErrors([
                        'type' => "Solo puedes programar {$inorganicLimit} recolecciones de residuos inorgánicos reciclables por semana.",
                    ])
                    ->withInput();
            }
        }

        if ($data['type'] === CollectionSchedule::TYPE_HAZARDOUS) {
            $hazardousLimit = $rules['limits']['hazardous_per_month'] ?? 1;
            $monthStart = $scheduledAt->copy()->startOfMonth();
            $monthEnd = $scheduledAt->copy()->endOfMonth();

            $existingHazardous = CollectionSchedule::where('user_id', $user->id)
                ->where('type', CollectionSchedule::TYPE_HAZARDOUS)
                ->whereBetween('scheduled_for', [$monthStart, $monthEnd])
                ->count();

            if ($existingHazardous >= $hazardousLimit) {
                return back()
                    ->withErrors([
                        'type' => "Solo puedes programar una recolección de residuos peligrosos por mes.",
                    ])
                    ->withInput();
            }
        }

        $estimatedWeight = isset($data['estimated_weight'])
            ? (float) $data['estimated_weight']
            : null;
        $points = CollectionSchedule::calculatePoints($data['type'], $estimatedWeight);

        CollectionSchedule::create([
            'user_id'             => $user->id,
            'collector_company_id'=> $data['collector_company_id'],
            'address'             => $data['address'],
            'type'                => $data['type'],
            'scheduled_for'       => $scheduledFor,
            'estimated_weight'    => $estimatedWeight,
            'notes'               => $data['notes'] ?? null,
            'status'              => CollectionSchedule::STATUS_SCHEDULED,
            'points_awarded'      => $points,
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Recolección programada correctamente.');
    }
}
