<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectionSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CollectionScheduleController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'collector_company_id' => ['required', 'exists:collector_companies,id'],
            'address' => ['required', 'string', 'max:255'],
            'scheduled_for_date' => ['required', 'date'],
            'scheduled_for_time' => ['required', 'date_format:H:i'],
            'estimated_weight' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $scheduledFor = Carbon::parse(
            "{$data['scheduled_for_date']} {$data['scheduled_for_time']}"
        );

        CollectionSchedule::create([
            'collector_company_id' => $data['collector_company_id'],
            'address' => $data['address'],
            'scheduled_for' => $scheduledFor,
            'estimated_weight' => $data['estimated_weight'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        return back()->with('success', 'Recolección programada correctamente.');
    }

    public function update(Request $request, CollectionSchedule $schedule): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:scheduled,in_progress,completed,cancelled'],
            'actual_weight' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $payload = $data;

        $weightForPoints = $payload['actual_weight'] ?? $schedule->actual_weight ?? $schedule->estimated_weight;

        if ($schedule->type && $weightForPoints !== null) {
            $payload['points_awarded'] = CollectionSchedule::calculatePoints(
                $schedule->type,
                (float) $weightForPoints
            );
        }

        $schedule->update($payload);

        return back()->with('success', 'Recolección actualizada correctamente.');
    }

    public function destroy(CollectionSchedule $schedule): RedirectResponse
    {
        $schedule->delete();

        return back()->with('success', 'Recolección eliminada correctamente.');
    }
}
