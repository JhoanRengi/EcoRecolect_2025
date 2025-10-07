@extends('layouts.app')
@section('title','Mi Panel')

@section('content')
<div class="dashboard-bg">
  <div class="container py-6 space-y-6">
    @php
      use Illuminate\Support\Str;
    @endphp

    {{-- Encabezado + CTA alineado a la derecha, como en el mock --}}
    <div class="flex items-start justify-between">
      <div>
        <h1 class="text-xl sm:text-2xl font-extrabold text-ink">Mi Panel de Usuario</h1>
        <p class="text-xs sm:text-sm text-muted">Gestiona tus recolecciones y consulta tu actividad</p>
      </div>
      <a href="{{ route('user.pickups.create') }}" class="btn-primary">
        <span class="-mt-0.5">+</span> Solicitar Recolección
      </a>
    </div>

    {{-- 4 métricas superiores (estilo compacto, como la maqueta) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
      {{-- Total Recolecciones --}}
      <div class="card p-4 sm:p-5">
        <div class="flex justify-between items-start">
          <div class="space-y-1">
            <p class="text-[13px] text-slate-500">Total Recolecciones</p>
            <p class="text-2xl font-extrabold text-ink">{{ number_format($metrics['totalCollections']) }}</p>
            <p class="text-[11px] text-muted">+{{ $metrics['deltaCollectionsMonth'] }} este mes</p>
          </div>
          <span class="rounded-full bg-slate-100 text-slate-500 h-8 w-8 inline-flex items-center justify-center">🗂️</span>
        </div>
      </div>

      {{-- Peso total --}}
      <div class="card p-4 sm:p-5">
        <div class="flex justify-between items-start">
          <div class="space-y-1">
            <p class="text-[13px] text-slate-500">Peso Total</p>
            <p class="text-2xl font-extrabold text-ink">{{ number_format($metrics['totalWeight']) }} kg</p>
            <p class="text-[11px] text-muted">Residuos procesados</p>
          </div>
          <span class="rounded-full bg-slate-100 text-slate-500 h-8 w-8 inline-flex items-center justify-center">⚖️</span>
        </div>
      </div>

      {{-- Puntos --}}
      <div class="card p-4 sm:p-5">
        <div class="flex justify-between items-start">
          <div class="space-y-1">
            <p class="text-[13px] text-slate-500">Puntos Acumulados</p>
            <p class="text-2xl font-extrabold text-ink">{{ number_format($metrics['points']) }}</p>
            <p class="text-[11px] text-muted">+{{ $metrics['deltaPointsMonth'] }} este mes</p>
          </div>
          <span class="rounded-full bg-slate-100 text-slate-500 h-8 w-8 inline-flex items-center justify-center">🏅</span>
        </div>
      </div>

      {{-- Completadas hoy / próxima ventana --}}
      <div class="card p-4 sm:p-5">
        <div class="flex justify-between items-start">
          <div class="space-y-1">
            <p class="text-[13px] text-slate-500">Completadas Hoy</p>
            <p class="text-2xl font-extrabold text-ink">{{ number_format($metrics['completedToday']) }}</p>
            @if($metrics['nextWindow'])
              <p class="text-[11px] text-muted">
                {{ $metrics['nextWindow']->isoFormat('MMM D') }} ·
                {{ $metrics['nextWindow']->format('H:i') }}–{{ $metrics['nextWindowEnd']->format('H:i') }}
              </p>
            @else
              <p class="text-[11px] text-muted">—</p>
            @endif
          </div>
          <span class="rounded-full bg-slate-100 text-slate-500 h-8 w-8 inline-flex items-center justify-center">✅</span>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      {{-- Historial de recolecciones (tabla compacta + botón descargar a la derecha) --}}
      <div class="panel">
        <div class="px-4 sm:px-6 pt-4 flex items-center justify-between gap-3">
          <div>
            <h3 class="text-[15px] font-semibold text-ink">Historial de Recolecciones</h3>
            <p class="text-[12px] text-muted -mt-0.5">Tus recolecciones recientes y programadas</p>
          </div>

          <form method="POST" action="{{ route('user.reports.download') }}">
            @csrf
            {{-- Si quieres filtros, añade inputs hidden start_date/end_date/status aquí --}}
            <button type="submit" class="pill hover:bg-slate-50">
              <span class="text-xs">⬇︎</span> Descargar Reporte
            </button>
          </form>
        </div>

        <div class="overflow-x-auto mt-3">
          <table class="min-w-full table-clean text-[13px]">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Empresa</th>
                <th>Peso</th>
                <th>Estado</th>
                <th class="text-right">Puntos</th>
              </tr>
            </thead>
            <tbody>
            @php
              $statusColors = [
                'completed'   => 'bg-emerald-100 text-emerald-700',
                'in_progress' => 'bg-amber-100 text-amber-700',
                'scheduled'   => 'bg-sky-100 text-sky-700',
                'cancelled'   => 'bg-rose-100 text-rose-700',
              ];
            @endphp

            @forelse($collections as $c)
              <tr class="text-slate-700">
                <td class="py-3 px-4">
                  <div class="flex items-center gap-2">
                    <span class="text-slate-400">●</span>
                    {{ optional($c->scheduled_for)->format('Y-m-d') ?? '—' }}
                  </div>
                </td>
                <td class="py-3 px-4">{{ $c->type ?? '—' }}</td>
                <td class="py-3 px-4">{{ $c->company?->name ?? 'N/D' }}</td>
                <td class="py-3 px-4">
                  {{ $c->actual_weight ?? $c->estimated_weight ?? '—' }}
                  @if($c->actual_weight || $c->estimated_weight) kg @endif
                </td>
                <td class="py-3 px-4">
                  <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold {{ $statusColors[$c->status] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ $c->status_label }}
                  </span>
                </td>
                <td class="py-3 px-4 text-right">{{ $c->points_awarded ?? '-' }}</td>
              </tr>
            @empty
              <tr><td colspan="6" class="empty">Aún no tienes recolecciones registradas.</td></tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- Sistema de Puntos / Canje --}}
      <div class="panel">
        <div class="p-4 sm:p-6 space-y-6">
          <div class="flex items-start justify-between">
            <div>
              <h3 class="text-[15px] font-semibold text-ink">Catálogo de Recompensas</h3>
              <p class="text-[12px] text-muted -mt-0.5">Selecciona un beneficio según tus puntos disponibles</p>
            </div>
          </div>

          <div class="bg-slate-50 border border-line rounded-2xl px-4 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <p class="text-sm font-semibold text-ink">Tu saldo actual</p>
              <p class="text-3xl font-extrabold text-brand">{{ number_format($metrics['points']) }} pts</p>
            </div>
            <div class="flex gap-3 flex-wrap">
              <a href="{{ route('user.rewards.catalog') }}" class="pill hover:bg-slate-100">
                📚 Ver detalles de todas las recompensas
              </a>
              <a href="{{ route('user.rewards.redeem') }}" class="btn-primary">
                Canjear puntos
              </a>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse($rewards as $reward)
              <div class="rounded-2xl border border-line p-4 shadow-soft bg-white flex flex-col h-full">
                <div class="flex items-center gap-3">
                  <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center text-sm font-semibold text-ink">
                    {{ Str::substr($reward['company'], 0, 2) }}
                  </div>
                  <div>
                    <p class="text-xs uppercase tracking-wide text-muted">{{ $reward['company'] }}</p>
                    <h4 class="text-base font-semibold text-ink">{{ $reward['label'] }}</h4>
                  </div>
                </div>
                <p class="text-sm text-muted mt-3 flex-1">{{ $reward['description'] }}</p>
                <div class="mt-4 flex items-center justify-between">
                  <span class="text-sm font-semibold text-brand">{{ $reward['cost'] }} pts</span>
                  <form method="POST" action="{{ route('user.rewards.redeem') }}">
                    @csrf
                    <input type="hidden" name="reward" value="{{ $reward['label'] }}">
                    <input type="hidden" name="cost" value="{{ $reward['cost'] }}">
                    <button
                      class="pill hover:bg-slate-100 text-xs"
                      @if($metrics['points'] < $reward['cost']) disabled @endif
                    >
                      {{ $metrics['points'] >= $reward['cost'] ? 'Seleccionar' : 'Insuficientes' }}
                    </button>
                  </form>
                </div>
              </div>
            @empty
              <p class="text-sm text-muted col-span-full">Aún no hay recompensas disponibles.</p>
            @endforelse
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
