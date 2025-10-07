<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CollectionSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Últimas 10 recolecciones del usuario (recientes + futuras)
        $collections = CollectionSchedule::with(['company'])
            ->where('user_id', $user->id)
            ->orderByDesc('scheduled_for')
            ->limit(10)
            ->get();

        // Métricas
        $totalCollections = CollectionSchedule::where('user_id', $user->id)->count();
        $totalWeight = (float) CollectionSchedule::where('user_id', $user->id)
            ->sum(\DB::raw('COALESCE(actual_weight, estimated_weight)'));
        $points = (int) CollectionSchedule::where('user_id', $user->id)->sum('points_awarded');

        $monthStart = now()->startOfMonth();
        $deltaCollectionsMonth = CollectionSchedule::where('user_id', $user->id)
            ->where('scheduled_for', '>=', $monthStart)->count();
        $deltaPointsMonth = (int) CollectionSchedule::where('user_id', $user->id)
            ->where('scheduled_for', '>=', $monthStart)->sum('points_awarded');

        $completedToday = CollectionSchedule::where('user_id', $user->id)
            ->whereDate('scheduled_for', today())
            ->where('status', CollectionSchedule::STATUS_COMPLETED)
            ->count();

        // Próxima ventana (si hay un programado hoy o futuro)
        $next = CollectionSchedule::where('user_id', $user->id)
            ->where('status', CollectionSchedule::STATUS_SCHEDULED)
            ->where('scheduled_for', '>=', now())
            ->orderBy('scheduled_for')
            ->first();

        $metrics = [
            'totalCollections'      => $totalCollections,
            'totalWeight'           => round($totalWeight, 1),
            'points'                => $points,
            'deltaCollectionsMonth' => $deltaCollectionsMonth,
            'deltaPointsMonth'      => $deltaPointsMonth,
            'completedToday'        => $completedToday,
            'nextWindow'            => $next?->scheduled_for ? Carbon::parse($next->scheduled_for) : null,
            'nextWindowEnd'         => $next?->scheduled_for_end ? Carbon::parse($next->scheduled_for_end) : null,
        ];

        // Catálogo de recompensas (puedes moverlo a BD cuando quieras)
        $rewards = [
            [
                'company' => 'Amazon',
                'label' => '$200,000 Tarjeta de Regalo',
                'cost' => 400,
                'description' => 'Canjea por una tarjeta regalo digital de Amazon USA.'
            ],
            [
                'company' => 'Rappi',
                'label' => '$50.000 en RappiCréditos',
                'cost' => 250,
                'description' => 'Perfecto para domicilios sostenibles o mercados.'
            ],
            [
                'company' => 'Apple',
                'label' => '$250,000 Tarjeta de regalo Apple',
                'cost' => 600,
                'description' => 'Úsala en App Store o Apple Music.'
            ],
            [
                'company' => 'Google Store',
                'label' => '$50,000 Google Play',
                'cost' => 350,
                'description' => 'Compra apps, libros o películas.'
            ],
            [
                'company' => 'Café Juan Valdez',
                'label' => 'Bebida gratuita',
                'cost' => 150,
                'description' => 'Redime una bebida en tiendas seleccionadas.'
            ],
            [
                'company' => 'Café Juan Valdez',
                'label' => 'Kit de Café Premium',
                'cost' => 700,
                'description' => 'Incluye café en grano y taza de colección.'
            ],
        ];

        return view('user.dashboard', compact('metrics', 'collections', 'rewards'));
    }

    /**
     * Descarga CSV del historial del usuario (últimos 6 meses por defecto).
     */
    public function downloadCsv(Request $request): StreamedResponse
    {
        $user = Auth::user();

        $start = Carbon::parse($request->input('start_date', now()->subMonths(6)->toDateString()))->startOfDay();
        $end   = Carbon::parse($request->input('end_date', now()->toDateString()))->endOfDay();
        $status= $request->input('status'); // opcional

        $query = CollectionSchedule::with('company')
            ->where('user_id', $user->id)
            ->whereBetween('scheduled_for', [$start, $end]);

        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        $rows = $query->orderBy('scheduled_for')->cursor();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="recolecciones_'.$start->format('Ymd').'-'.$end->format('Ymd').'.csv"',
        ];

        return response()->stream(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Fecha','Tipo','Empresa','Peso (kg)','Estado','Puntos']);

            foreach ($rows as $r) {
                fputcsv($out, [
                    optional($r->scheduled_for)->format('Y-m-d H:i'),
                    $r->type ?? 'Mixto',
                    $r->company->name ?? 'N/D',
                    $r->actual_weight ?? $r->estimated_weight ?? '',
                    $r->status_label ?? $r->status,
                    $r->points_awarded ?? 0,
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }

    /** Catálogo de recompensas (placeholder) */
    public function catalog()
    {
        // Aquí podrías traer Reward::all() si tienes tabla de recompensas
        $rewards = [
            ['label' => 'Descuento 10%', 'cost' => 100],
            ['label' => 'Descuento 20%', 'cost' => 200],
            ['label' => 'Producto Eco',  'cost' => 500],
        ];

        return view('user.rewards.catalog', compact('rewards'));
    }

    /** Canje de puntos (placeholder) */
    public function redeem(Request $request)
    {
        $data = $request->validate([
            'reward' => ['required','string','max:255'],
            'cost'   => ['required','integer','min:0'],
        ]);

        // Aquí podrías verificar puntos reales, descontar y registrar canje.
        return back()->with('success', "Solicitud de canje enviada para {$data['reward']} ({$data['cost']} pts). Pronto nos contactaremos.");
    }
}
