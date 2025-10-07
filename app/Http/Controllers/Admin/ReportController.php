<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectionSchedule;
use App\Models\CollectorCompany;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function collections(Request $request): StreamedResponse
    {
        $data = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'in:scheduled,in_progress,completed,cancelled'],
        ]);

        $start = Carbon::parse($data['start_date'])->startOfDay();
        $end = Carbon::parse($data['end_date'])->endOfDay();

        $query = CollectionSchedule::with('company')
            ->whereBetween('scheduled_for', [$start, $end])
            ->orderBy('scheduled_for');

        if (!empty($data['status'])) {
            $query->where('status', $data['status']);
        }

        $filename = 'recolecciones_'.now()->format('Ymd_His').'.csv';

        $callback = static function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Fecha',
                'Hora',
                'Empresa',
                'Dirección',
                'Estado',
                'Peso estimado (kg)',
                'Peso real (kg)',
            ]);

            $query->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->scheduled_for?->format('Y-m-d'),
                        $row->scheduled_for?->format('H:i'),
                        $row->company?->name,
                        $row->address,
                        $row->status_label,
                        $row->estimated_weight,
                        $row->actual_weight,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function byUser(Request $request): StreamedResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $user = User::findOrFail($data['user_id']);
        $start = Carbon::parse($data['start_date'])->startOfDay();
        $end = Carbon::parse($data['end_date'])->endOfDay();

        $query = CollectionSchedule::with('company')
            ->where('user_id', $user->id)
            ->whereBetween('scheduled_for', [$start, $end])
            ->orderBy('scheduled_for');

        $filename = 'reporte_usuario_'.$user->id.'_'.now()->format('Ymd_His').'.csv';

        $callback = static function () use ($query, $user) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Usuario',
                'Fecha',
                'Hora',
                'Empresa',
                'Dirección',
                'Tipo residuo',
                'Peso estimado (kg)',
                'Peso real (kg)',
                'Estado',
                'Puntos ganados',
            ]);

            $query->chunk(200, function ($rows) use ($handle, $user) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $user->name,
                        $row->scheduled_for?->format('Y-m-d'),
                        $row->scheduled_for?->format('H:i'),
                        $row->company?->name,
                        $row->address,
                        $row->type,
                        $row->estimated_weight,
                        $row->actual_weight,
                        $row->status_label,
                        $row->points_awarded,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function byLocality(Request $request): StreamedResponse
    {
        $data = $request->validate([
            'locality' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $start = Carbon::parse($data['start_date'])->startOfDay();
        $end = Carbon::parse($data['end_date'])->endOfDay();

        $query = CollectionSchedule::query()
            ->selectRaw('users.locality, collection_schedules.type, COUNT(*) as total_recolecciones, SUM(points_awarded) as total_puntos, SUM(COALESCE(actual_weight, estimated_weight)) as total_peso')
            ->join('users', 'collection_schedules.user_id', '=', 'users.id')
            ->whereBetween('collection_schedules.scheduled_for', [$start, $end])
            ->groupBy('users.locality', 'collection_schedules.type')
            ->orderBy('users.locality')
            ->orderBy('collection_schedules.type');

        if (!empty($data['locality'])) {
            $query->where('users.locality', $data['locality']);
        }

        $filename = 'reporte_localidades_'.now()->format('Ymd_His').'.csv';

        $callback = static function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Localidad',
                'Tipo residuo',
                'Total recolecciones',
                'Total peso (kg)',
                'Total puntos',
            ]);

            $query->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->locality ?? 'Sin localidad',
                        $row->type ?? 'No especificado',
                        $row->total_recolecciones,
                        number_format($row->total_peso, 2),
                        $row->total_puntos ?? 0,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function byCompany(Request $request): StreamedResponse
    {
        $data = $request->validate([
            'company_id' => ['nullable', 'exists:collector_companies,id'],
            'type' => ['nullable', 'in:Inorgánico reciclable,Residuo peligroso,Residuo orgánico'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $start = Carbon::parse($data['start_date'])->startOfDay();
        $end = Carbon::parse($data['end_date'])->endOfDay();

        $query = CollectionSchedule::with(['company', 'user'])
            ->whereBetween('scheduled_for', [$start, $end])
            ->orderBy('scheduled_for');

        if (!empty($data['company_id'])) {
            $query->where('collector_company_id', $data['company_id']);
        }

        if (!empty($data['type'])) {
            $query->where('type', $data['type']);
        }

        $companyName = 'todas';
        if (!empty($data['company_id'])) {
            $companyName = CollectorCompany::find($data['company_id'])->name ?? 'empresa';
        }

        $filename = 'reporte_empresa_'.$companyName.'_'.now()->format('Ymd_His').'.csv';

        $callback = static function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Empresa',
                'Fecha',
                'Hora',
                'Usuario',
                'Localidad',
                'Tipo residuo',
                'Dirección',
                'Estado',
                'Peso estimado (kg)',
                'Peso real (kg)',
                'Puntos otorgados',
            ]);

            $query->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->company?->name ?? 'N/D',
                        $row->scheduled_for?->format('Y-m-d'),
                        $row->scheduled_for?->format('H:i'),
                        $row->user?->name ?? 'Usuario externo',
                        $row->user?->locality ?? 'Sin localidad',
                        $row->type ?? 'No especificado',
                        $row->address,
                        $row->status_label,
                        $row->estimated_weight,
                        $row->actual_weight,
                        $row->points_awarded ?? 0,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
