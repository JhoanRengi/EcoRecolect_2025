@extends('layouts.app')
@section('title','Solicitar Recolección')

@section('content')
@php
  use App\Models\CollectionSchedule;
@endphp
<div class="dashboard-bg">
  <div class="container py-6">
    <div class="panel max-w-2xl mx-auto">
      <form action="{{ route('user.pickups.store') }}" method="POST" class="p-6 space-y-4">
        @csrf
        <h1 class="text-xl font-semibold text-ink">Programar Recolección</h1>

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-800 text-sm p-4 space-y-2">
          <p class="font-semibold">Recordatorios del servicio</p>
          @if($organicDayLabel ?? false)
            <p>• Los residuos orgánicos se recogen los <strong>{{ \Illuminate\Support\Str::lower($organicDayLabel) }}</strong> (1 vez por semana según tu localidad).</p>
          @else
            <p>• Los residuos orgánicos se recogen 1 vez por semana. Actualiza tu localidad en el perfil para ver el día asignado.</p>
          @endif
          <p>• Los residuos inorgánicos reciclables pueden solicitarse hasta {{ $limits['inorganic'] ?? 2 }} veces por semana.</p>
          <p>• Los residuos peligrosos se programan una vez al mes; asegúrate de agruparlos.</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-600 mb-1">Empresa</label>
          <select name="collector_company_id" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
            <option value="">Selecciona una empresa</option>
            @foreach($companies as $c)
              <option value="{{ $c->id }}" {{ old('collector_company_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
          </select>
          @error('collector_company_id')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-600 mb-1">Dirección</label>
          <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
          <p class="mt-1 text-xs text-muted">Usamos tu dirección registrada. Puedes ajustarla si necesitas otra ubicación.</p>
          @error('address')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Fecha</label>
            <input type="date" name="scheduled_for_date" value="{{ old('scheduled_for_date') }}" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
            @error('scheduled_for_date')
              <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Hora</label>
            <input type="time" name="scheduled_for_time" value="{{ old('scheduled_for_time') }}" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
            @error('scheduled_for_time')
              <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Tipo de residuo</label>
            @php $selectedType = old('type', CollectionSchedule::TYPE_INORGANIC); @endphp
            <select name="type" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
              <option value="{{ CollectionSchedule::TYPE_INORGANIC }}" {{ $selectedType === CollectionSchedule::TYPE_INORGANIC ? 'selected' : '' }}>Inorgánico reciclable</option>
              <option value="{{ CollectionSchedule::TYPE_HAZARDOUS }}" {{ $selectedType === CollectionSchedule::TYPE_HAZARDOUS ? 'selected' : '' }}>Residuo peligroso</option>
              <option value="{{ CollectionSchedule::TYPE_ORGANIC }}" {{ $selectedType === CollectionSchedule::TYPE_ORGANIC ? 'selected' : '' }}>Residuo orgánico</option>
            </select>
            @error('type')
              <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Peso estimado (kg)</label>
            <input type="number" step="0.01" min="0" name="estimated_weight" value="{{ old('estimated_weight') }}" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
            @error('estimated_weight')
              <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-600 mb-1">Notas</label>
          <textarea name="notes" rows="3" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">{{ old('notes') }}</textarea>
          @error('notes')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex justify-end gap-3">
          <a href="{{ route('user.dashboard') }}" class="pill hover:bg-slate-50">Cancelar</a>
          <button class="btn-primary" type="submit">Programar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
