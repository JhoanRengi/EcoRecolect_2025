<x-app-layout>
  <style>[x-cloak]{display:none!important}</style>

  <div
    x-data="{
      activeTab: 'collections',
      showCompanyModal: false,
      showCollectionModal: false,
      showUserModal: false,
      showReportModal: false,
      showStatusModal: false,
      selectedSchedule: null,
      statusForm: { status: 'scheduled', actual_weight: '', notes: '' },
      openStatusModal(schedule) {
        this.selectedSchedule = schedule;
        this.statusForm.status = schedule.status ?? 'scheduled';
        this.statusForm.actual_weight = schedule.actual_weight ?? '';
        this.statusForm.notes = schedule.notes ?? '';
        this.showStatusModal = true;
      },
      closeModals() {
        this.showCompanyModal = false;
        this.showCollectionModal = false;
        this.showUserModal = false;
        this.showReportModal = false;
        this.showStatusModal = false;
      }
    }"
    class="min-h-screen dashboard-bg"
  >
    {{-- Contenido --}}
    <div class="container py-6 space-y-6">

      {{-- Título + CTA --}}
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h2 class="text-3xl font-extrabold text-ink">Panel de Administración</h2>
          <p class="text-muted mt-1">Gestiona usuarios, recolectores y programaciones</p>
        </div>
        <button
          type="button"
          x-on:click="showCollectionModal = true"
          class="btn-primary"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
          </svg>
          Programar Recolección
        </button>
      </div>

      {{-- Alertas --}}
      @if (session('success'))
        <div class="card px-4 py-3 border-emerald-200">
          <div class="text-emerald-700">
            {{ session('success') }}
            @if (session('new_user_email'))
              <span class="block text-sm mt-2">
                Usuario: {{ session('new_user_email') }}
                @if (session('generated_password'))
                  — Contraseña generada: <strong>{{ session('generated_password') }}</strong>
                @endif
              </span>
            @endif
          </div>
        </div>
      @endif

      @if (session('error'))
        <div class="card px-4 py-3 border-rose-200">
          <div class="text-rose-700">
            {{ session('error') }}
          </div>
        </div>
      @endif

      {{-- Métricas --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="card stat">
          <div class="flex justify-between items-start mb-2">
            <span class="stat-title">Total Usuarios</span>
            <span class="rounded-full bg-slate-100 text-slate-600 px-2 py-1 text-xs">👤</span>
          </div>
          <div class="stat-value">{{ number_format($metrics['totalUsers']) }}</div>
          <div class="stat-hint">+12% desde el mes pasado</div>
        </div>

        <div class="card stat">
          <div class="flex justify-between items-start mb-2">
            <span class="stat-title">Empresas Activas</span>
            <span class="rounded-full bg-slate-100 text-slate-600 px-2 py-1 text-xs">🏢</span>
          </div>
          <div class="stat-value">{{ number_format($metrics['activeCompanies']) }}</div>
          <div class="stat-hint">+2 nuevas esta semana</div>
        </div>

        <div class="card stat">
          <div class="flex justify-between items-start mb-2">
            <span class="stat-title">Recolecciones Programadas</span>
            <span class="rounded-full bg-slate-100 text-slate-600 px-2 py-1 text-xs">⚙️</span>
          </div>
          <div class="stat-value">{{ number_format($metrics['scheduledToday']) }}</div>
          <div class="stat-hint">Para hoy</div>
        </div>

        <div class="card stat">
          <div class="flex justify-between items-start mb-2">
            <span class="stat-title">Completadas Hoy</span>
            <span class="rounded-full bg-slate-100 text-slate-600 px-2 py-1 text-xs">✅</span>
          </div>
          <div class="stat-value">{{ number_format($metrics['completedToday']) }}</div>
          <div class="stat-hint">57% del total programado</div>
        </div>
      </div>

      {{-- Panel principal --}}
      <div class="panel">
        {{-- Tabs --}}
        <div class="px-4 sm:px-6 pt-4">
          <div class="tabs mb-3">
            <button type="button" class="tab" :class="activeTab==='collections' && 'tab-active'" x-on:click="activeTab='collections'">Recolecciones</button>
            <button type="button" class="tab" :class="activeTab==='companies' && 'tab-active'" x-on:click="activeTab='companies'">Empresas</button>
            <button type="button" class="tab" :class="activeTab==='users' && 'tab-active'" x-on:click="activeTab='users'">Usuarios</button>
            <button type="button" class="tab" :class="activeTab==='reports' && 'tab-active'" x-on:click="activeTab='reports'">Reportes</button>
          </div>
        </div>

        <div class="p-4 sm:p-6 space-y-6">
          {{-- TAB: Recolecciones --}}
          <div x-show="activeTab === 'collections'" x-cloak>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-3">
              <div>
                <h3 class="font-semibold text-ink">Gestionar Recolecciones</h3>
                <p class="text-sm text-muted">Programa y supervisa las recolecciones diarias</p>
              </div>

              <div class="flex items-center gap-3">
                <label class="pill">
                  <span class="text-slate-500 text-xs">Fecha</span>
                  <input type="date"
                         value="{{ now()->format('Y-m-d') }}"
                         class="border-0 p-0 text-sm focus:ring-0 focus:outline-none"/>
                </label>
                <button type="button" class="pill hover:bg-slate-50">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 7.5 21l5.096-2.313a6.75 6.75 0 1 0-2.782-2.783Z" />
                  </svg>
                  Ver rutas
                </button>
              </div>
            </div>

            <div class="overflow-x-auto">
              <table class="min-w-full table-clean">
                <thead>
                  <tr>
                    <th>Dirección</th>
                    <th>Empresa</th>
                    <th>Estado</th>
                    <th>Hora</th>
                    <th class="text-right">Peso (kg)</th>
                    <th class="text-right">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($schedules as $schedule)
                    <tr class="text-slate-700">
                      <td class="py-3 px-4">{{ $schedule->address }}</td>
                      <td class="py-3 px-4">{{ $schedule->company?->name ?? 'N/D' }}</td>
                      <td class="py-3 px-4">
                        @php
                          $statusColors = [
                            \App\Models\CollectionSchedule::STATUS_COMPLETED => 'bg-emerald-100 text-emerald-700',
                            \App\Models\CollectionSchedule::STATUS_IN_PROGRESS => 'bg-amber-100 text-amber-700',
                            \App\Models\CollectionSchedule::STATUS_SCHEDULED => 'bg-sky-100 text-sky-700',
                            \App\Models\CollectionSchedule::STATUS_CANCELLED => 'bg-rose-100 text-rose-700',
                          ];
                        @endphp
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $statusColors[$schedule->status] ?? 'bg-slate-100 text-slate-600' }}">
                          {{ $schedule->status_label }}
                        </span>
                      </td>
                      <td class="py-3 px-4">
                        {{ optional($schedule->scheduled_for)->format('H:i') ?? '—' }}
                      </td>
                      <td class="py-3 px-4 text-right">
                        {{ $schedule->actual_weight ?? $schedule->estimated_weight ?? '—' }}
                      </td>
                      <td class="py-3 px-4">
                        <div class="flex justify-end items-center gap-2">
                          <button
                            type="button"
                            class="p-2 rounded-full bg-slate-100 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 transition"
                            x-on:click="openStatusModal({
                              id: {{ $schedule->id }},
                              status: '{{ $schedule->status }}',
                              actual_weight: {{ $schedule->actual_weight ?? 'null' }},
                              notes: @json($schedule->notes)
                            })"
                          >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                          </button>
                          <form action="{{ route('admin.collections.destroy', $schedule) }}" method="POST" onsubmit="return confirm('¿Eliminar esta recolección?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-full bg-slate-100 text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Eliminar recolección">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75v7.5m4.5-7.5v7.5M5.25 6.75H18.75M9 6.75V5.25a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5v1.5M5.25 6.75 6 19.5a1.5 1.5 0 0 0 1.497 1.35h9.006A1.5 1.5 0 0 0 18 19.5l.75-12.75" />
                              </svg>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="empty">Aún no hay recolecciones programadas.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          {{-- TAB: Empresas --}}
          <div x-show="activeTab === 'companies'" x-cloak>
            <div class="flex items-center justify-between mb-4">
              <div>
                <h3 class="font-semibold text-ink">Empresas Recolectoras</h3>
                <p class="text-sm text-muted">Gestiona aliados de recolección</p>
              </div>
              <button type="button" x-on:click="showCompanyModal = true" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                Nueva empresa
              </button>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
              @forelse ($companies as $company)
                <div class="card p-5">
                  <div class="flex items-start justify-between">
                    <div>
                      <h4 class="font-semibold text-ink">{{ $company->name }}</h4>
                      <p class="text-xs text-slate-400 uppercase tracking-wide mt-1">{{ $company->status }}</p>
                    </div>
                    <form action="{{ route('admin.companies.destroy', $company) }}" method="POST" onsubmit="return confirm('¿Eliminar empresa?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="text-slate-400 hover:text-rose-600 transition" title="Eliminar empresa">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-5.02 5.02M9 9l5.02 5.02M5.75 5.75l12.5 12.5"/></svg>
                      </button>
                    </form>
                  </div>
                  <dl class="mt-4 space-y-2 text-sm text-slate-600">
                    @if($company->address) <div><span class="font-medium">Dirección:</span> {{ $company->address }}</div> @endif
                    @if($company->contact_name) <div><span class="font-medium">Contacto:</span> {{ $company->contact_name }}</div> @endif
                    @if($company->contact_email) <div><span class="font-medium">Email:</span> {{ $company->contact_email }}</div> @endif
                    @if($company->contact_phone) <div><span class="font-medium">Tel:</span> {{ $company->contact_phone }}</div> @endif
                  </dl>
                </div>
              @empty
                <p class="text-sm text-slate-400">Aún no hay empresas registradas.</p>
              @endforelse
            </div>
          </div>

          {{-- TAB: Usuarios --}}
          <div x-show="activeTab === 'users'" x-cloak>
            <div class="flex items-center justify-between mb-4">
              <div>
                <h3 class="font-semibold text-ink">Usuarios</h3>
                <p class="text-sm text-muted">Control de accesos y roles</p>
              </div>
              <button type="button" x-on:click="showUserModal = true" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Nuevo usuario
              </button>
            </div>

            <div class="overflow-x-auto">
              <table class="min-w-full table-clean">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Registrado</th>
                    <th class="text-right">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($recentUsers as $user)
                    <tr class="text-slate-700">
                      <td class="py-3 px-4">{{ $user->name }}</td>
                      <td class="py-3 px-4">{{ $user->email }}</td>
                      <td class="py-3 px-4">
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                          {{ ucfirst($user->user_type ?? 'cliente') }}
                        </span>
                      </td>
                      <td class="py-3 px-4">{{ optional($user->created_at)->format('d/m/Y') ?? '—' }}</td>
                      <td class="py-3 px-4">
                        @if($user->id !== auth()->id())
                          <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex justify-end" onsubmit="return confirm('¿Eliminar al usuario {{ $user->name }}? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-full bg-slate-100 text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition" title="Eliminar usuario">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-5.02 5.02M9 9l5.02 5.02M5.75 5.75l12.5 12.5" />
                              </svg>
                            </button>
                          </form>
                        @else
                          <span class="text-xs text-muted italic flex justify-end">Tu cuenta</span>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="5" class="empty">Todavía no hay usuarios.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          {{-- TAB: Reportes --}}
          <div x-show="activeTab === 'reports'" x-cloak
               x-data="{ reportTab: 'collections' }">
            <div class="max-w-2xl space-y-5">
              <div>
                <h3 class="font-semibold text-ink mb-2">Generar reportes</h3>
                <p class="text-sm text-muted mb-4">Selecciona el tipo de reporte y completa los filtros necesarios.</p>
                <div class="flex flex-wrap gap-2">
                  <button type="button" class="pill hover:bg-slate-100"
                          :class="reportTab==='collections' && 'bg-brand text-white border-brand'"
                          x-on:click="reportTab='collections'">
                    Recolecciones
                  </button>
                  <button type="button" class="pill hover:bg-slate-100"
                          :class="reportTab==='user' && 'bg-brand text-white border-brand'"
                          x-on:click="reportTab='user'">
                    Por usuario
                  </button>
                  <button type="button" class="pill hover:bg-slate-100"
                          :class="reportTab==='locality' && 'bg-brand text-white border-brand'"
                          x-on:click="reportTab='locality'">
                    Por localidad
                  </button>
                  <button type="button" class="pill hover:bg-slate-100"
                          :class="reportTab==='company' && 'bg-brand text-white border-brand'"
                          x-on:click="reportTab='company'">
                    Por empresa
                  </button>
                </div>
              </div>

              {{-- Reporte general de recolecciones --}}
              <template x-if="reportTab==='collections'">
                <form x-cloak
                      action="{{ route('admin.reports.collections') }}"
                      method="POST" class="space-y-4 card border-line p-4">
                @csrf
                <h4 class="font-semibold text-ink text-sm uppercase tracking-wide">Recolecciones generales</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Desde</label>
                    <input type="date" name="start_date" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Hasta</label>
                    <input type="date" name="end_date" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-slate-600 mb-1">Estado</label>
                  <select name="status" class="w-full rounded-xl border border-line px-3 py-2 text-sm focus:border-brand focus:ring-1 focus:ring-brand/40">
                    <option value="">Todos</option>
                    <option value="{{ \App\Models\CollectionSchedule::STATUS_SCHEDULED }}">Programado</option>
                    <option value="{{ \App\Models\CollectionSchedule::STATUS_IN_PROGRESS }}">En progreso</option>
                    <option value="{{ \App\Models\CollectionSchedule::STATUS_COMPLETED }}">Completado</option>
                    <option value="{{ \App\Models\CollectionSchedule::STATUS_CANCELLED }}">Cancelado</option>
                  </select>
                </div>
                <button type="submit" class="btn-primary">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V12a9 9 0 0 1 18 0v4.5M7.5 19.5l4.5 4.5 4.5-4.5M12 24V12" />
                  </svg>
                  Descargar CSV
                </button>
                </form>
              </template>

              {{-- Reporte por usuario --}}
              <template x-if="reportTab==='user'">
                <form x-cloak
                      action="{{ route('admin.reports.by-user') }}" method="POST"
                      class="space-y-4 card border-line p-4">
                @csrf
                <h4 class="font-semibold text-ink text-sm uppercase tracking-wide">Reporte por usuario</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-600 mb-1">Usuario</label>
                    <select name="user_id" class="w-full rounded-xl border border-line px-3 py-2 text-sm focus:border-brand focus:ring-1 focus:ring-brand/40" required>
                      <option value="">Selecciona un usuario</option>
                      @foreach($recentUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                      @endforeach
                    </select>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Desde</label>
                    <input type="date" name="start_date" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Hasta</label>
                    <input type="date" name="end_date" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
                  </div>
                </div>
                <button type="submit" class="btn-primary">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V12a9 9 0 0 1 18 0v4.5M7.5 19.5l4.5 4.5 4.5-4.5M12 24V12"/></svg>
                  Descargar CSV
                </button>
                </form>
              </template>

              {{-- Reporte por localidad --}}
              <template x-if="reportTab==='locality'">
                <form action="{{ route('admin.reports.by-locality') }}" method="POST" class="space-y-4 card border-line p-4" x-cloak>
                  @csrf
                  <h4 class="font-semibold text-ink text-sm uppercase tracking-wide">Resumen por localidad</h4>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                      <label class="block text-sm font-medium text-slate-600 mb-1">Localidad (opcional)</label>
                      <input type="text" name="locality" list="localities" placeholder="Filtrar por localidad" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
                      <datalist id="localities">
                        @foreach(config('localities.bogota') as $loc)
                          <option value="{{ $loc }}"></option>
                        @endforeach
                      </datalist>
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-slate-600 mb-1">Desde</label>
                      <input type="date" name="start_date" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-slate-600 mb-1">Hasta</label>
                      <input type="date" name="end_date" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
                    </div>
                  </div>
                  <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V12a9 9 0 0 1 18 0v4.5M7.5 19.5l4.5 4.5 4.5-4.5M12 24V12"/></svg>
                    Descargar CSV
                  </button>
                </form>
              </template>

              {{-- Reporte por empresa --}}
              <template x-if="reportTab==='company'">
                <form action="{{ route('admin.reports.by-company') }}" method="POST" class="space-y-4 card border-line p-4" x-cloak>
                  @csrf
                  <h4 class="font-semibold text-ink text-sm uppercase tracking-wide">Reporte por empresa</h4>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                      <label class="block text-sm font-medium text-slate-600 mb-1">Empresa</label>
                      <select name="company_id" class="w-full rounded-xl border border-line px-3 py-2 text-sm focus:border-brand focus:ring-1 focus:ring-brand/40">
                        <option value="">Todas</option>
                        @foreach($companies as $company)
                          <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-slate-600 mb-1">Tipo de residuo</label>
                      <select name="type" class="w-full rounded-xl border border-line px-3 py-2 text-sm focus:border-brand focus:ring-1 focus:ring-brand/40">
                        <option value="">Todos</option>
                        <option value="{{ \App\Models\CollectionSchedule::TYPE_INORGANIC }}">Inorgánico reciclable</option>
                        <option value="{{ \App\Models\CollectionSchedule::TYPE_HAZARDOUS }}">Residuo peligroso</option>
                        <option value="{{ \App\Models\CollectionSchedule::TYPE_ORGANIC }}">Residuo orgánico</option>
                      </select>
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-slate-600 mb-1">Desde</label>
                      <input type="date" name="start_date" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-slate-600 mb-1">Hasta</label>
                      <input type="date" name="end_date" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40" required>
                    </div>
                  </div>
                  <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V12a9 9 0 0 1 18 0v4.5M7.5 19.5l4.5 4.5 4.5-4.5M12 24V12"/></svg>
                    Descargar CSV
                  </button>
                </form>
              </template>
            </div>
          </div>

        </div>
      </div>
    </div>

    {{-- MODALES --}}
    <!-- Programar recolección -->
    <div class="fixed inset-0 z-40 flex items-center justify-center bg-slate-900/50 px-4" x-show="showCollectionModal" x-cloak>
      <div class="w-full max-w-2xl card p-6 relative">
        <button type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600" x-on:click="closeModals()">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m6 18 12-12M6 6l12 12"/></svg>
        </button>
        <h3 class="text-xl font-semibold text-ink mb-1">Programar nueva recolección</h3>
        <p class="text-sm text-muted mb-6">Registra fecha, empresa y detalles de la ruta.</p>

        <form action="{{ route('admin.collections.store') }}" method="POST" class="space-y-5">
          @csrf
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-sm font-medium text-slate-600 mb-1">Empresa</label>
              <select name="collector_company_id" required class="w-full rounded-xl border border-line px-3 py-2 text-sm focus:border-brand focus:ring-1 focus:ring-brand/40">
                <option value="">Selecciona una empresa</option>
                @foreach ($companies as $company)
                  <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="sm:col-span-2">
              <label class="block text-sm font-medium text-slate-600 mb-1">Dirección de recolección</label>
              <input type="text" name="address" required class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Fecha</label>
              <input type="date" name="scheduled_for_date" required class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Hora</label>
              <input type="time" name="scheduled_for_time" required class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Peso estimado (kg)</label>
              <input type="number" step="0.01" min="0" name="estimated_weight" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
            </div>
            <div class="sm:col-span-2">
              <label class="block text-sm font-medium text-slate-600 mb-1">Notas</label>
              <textarea name="notes" rows="3" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40"></textarea>
            </div>
          </div>

          <div class="flex justify-end gap-3">
            <button type="button" class="pill hover:bg-slate-50" x-on:click="closeModals()">Cancelar</button>
            <button type="submit" class="btn-primary">Programar</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Crear empresa -->
    <div class="fixed inset-0 z-40 flex items-center justify-center bg-slate-900/50 px-4" x-show="showCompanyModal" x-cloak>
      <div class="w-full max-w-xl card p-6 relative">
        <button type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600" x-on:click="closeModals()">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m6 18 12-12M6 6l12 12"/></svg>
        </button>
        <h3 class="text-xl font-semibold text-ink mb-1">Registrar nueva empresa</h3>
        <p class="text-sm text-muted mb-6">Agrega aliados para futuras recolecciones.</p>

        <form action="{{ route('admin.companies.store') }}" method="POST" class="space-y-4">
          @csrf
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Nombre</label>
            <input type="text" name="name" required class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Contacto</label>
              <input type="text" name="contact_name" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Teléfono</label>
              <input type="text" name="contact_phone" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Correo</label>
            <input type="email" name="contact_email" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Dirección</label>
            <input type="text" name="address" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Estado</label>
            <select name="status" class="w-full rounded-xl border border-line px-3 py-2 text-sm focus:border-brand focus:ring-1 focus:ring-brand/40">
              <option value="active">Activa</option>
              <option value="paused">En pausa</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Notas</label>
            <textarea name="notes" rows="3" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40"></textarea>
          </div>

          <div class="flex justify-end gap-3">
            <button type="button" class="pill hover:bg-slate-50" x-on:click="closeModals()">Cancelar</button>
            <button type="submit" class="btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Crear usuario -->
    <div class="fixed inset-0 z-40 flex items-center justify-center bg-slate-900/50 px-4" x-show="showUserModal" x-cloak>
      <div class="w-full max-w-xl card p-6 relative">
        <button type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600" x-on:click="closeModals()">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m6 18 12-12M6 6l12 12"/></svg>
        </button>
        <h3 class="text-xl font-semibold text-ink mb-1">Crear nuevo usuario</h3>
        <p class="text-sm text-muted mb-6">Define tipo de usuario y credenciales.</p>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
          @csrf
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Nombre completo</label>
            <input type="text" name="name" required class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Correo</label>
            <input type="email" name="email" required class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Tipo de usuario</label>
              <select name="user_type" required class="w-full rounded-xl border border-line px-3 py-2 text-sm focus:border-brand focus:ring-1 focus:ring-brand/40">
                <option value="admin">Administrador</option>
                <option value="recolector">Recolector</option>
                <option value="cliente">Cliente</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Teléfono</label>
              <input type="text" name="phone" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Dirección</label>
            <input type="text" name="address" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">Contraseña (opcional)</label>
            <input type="password" name="password" placeholder="Se generará una contraseña segura si lo dejas vacío" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
          </div>

          <div class="flex justify-end gap-3">
            <button type="button" class="pill hover:bg-slate-50" x-on:click="closeModals()">Cancelar</button>
            <button type="submit" class="btn-primary">Crear usuario</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Actualizar estado -->
    <div class="fixed inset-0 z-40 flex items-center justify-center bg-slate-900/50 px-4" x-show="showStatusModal" x-cloak>
      <div class="w-full max-w-lg card p-6 relative">
        <button type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600" x-on:click="closeModals()">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m6 18 12-12M6 6l12 12"/></svg>
        </button>
        <h3 class="text-xl font-semibold text-ink mb-1">Actualizar recolección</h3>
        <p class="text-sm text-muted mb-6">Cambia estado, peso y notas del servicio.</p>

        <template x-if="selectedSchedule">
          <form :action="`{{ url('admin/collections') }}/${selectedSchedule?.id}`" method="POST" class="space-y-4">
            @csrf @method('PATCH')
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Estado</label>
              <select name="status" x-model="statusForm.status" class="w-full rounded-xl border border-line px-3 py-2 text-sm focus:border-brand focus:ring-1 focus:ring-brand/40">
                <option value="{{ \App\Models\CollectionSchedule::STATUS_SCHEDULED }}">Programado</option>
                <option value="{{ \App\Models\CollectionSchedule::STATUS_IN_PROGRESS }}">En progreso</option>
                <option value="{{ \App\Models\CollectionSchedule::STATUS_COMPLETED }}">Completado</option>
                <option value="{{ \App\Models\CollectionSchedule::STATUS_CANCELLED }}">Cancelado</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Peso real (kg)</label>
              <input type="number" step="0.01" min="0" name="actual_weight" x-model="statusForm.actual_weight" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-600 mb-1">Notas</label>
              <textarea name="notes" rows="3" x-model="statusForm.notes" class="w-full rounded-xl border border-line px-3 py-2 focus:border-brand focus:ring-1 focus:ring-brand/40"></textarea>
            </div>

            <div class="flex justify-end gap-3">
              <button type="button" class="pill hover:bg-slate-50" x-on:click="closeModals()">Cancelar</button>
              <button type="submit" class="btn-primary">Actualizar</button>
            </div>
          </form>
        </template>
      </div>
    </div>
  </div>
</x-app-layout>
