<x-app-layout>
    <style>
        [x-cloak] { display: none !important; }
    </style>

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
        class="min-h-screen bg-slate-100"
    >
        <div class="bg-slate-900 text-white">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="bg-emerald-500/20 text-emerald-300 rounded-full p-2">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.128 1.152.495V7.5h5.25A2.25 2.25 0 0 1 19.5 9.75v.398c0 .597.237 1.17.659 1.591l.824.824a.75.75 0 0 1 0 1.06l-.824.824a2.25 2.25 0 0 0-.659 1.591v.398a2.25 2.25 0 0 1-2.25 2.25H12.356c-.623 0-.934.712-.495 1.152L2.25 12z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-300">Inicio Administrador</p>
                        <h1 class="text-xl font-semibold">Eco Recolect</h1>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-white/10 rounded-full text-sm">Admin</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600 transition"
                        >
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-10 space-y-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-semibold text-slate-900">Panel de Administración</h2>
                    <p class="text-slate-500 mt-1">Gestiona usuarios, recolectores y programaciones</p>
                </div>
                <button
                    type="button"
                    x-on:click="showCollectionModal = true"
                    class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-emerald-600 transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                    Programar Recolección
                </button>
            </div>

            @if (session('success'))
                <div class="rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-3 text-emerald-800">
                    {{ session('success') }}
                    @if (session('new_user_email'))
                        <span class="block text-sm text-emerald-700 mt-2">
                            Usuario: {{ session('new_user_email') }}
                            @if (session('generated_password'))
                                — Contraseña generada: <strong>{{ session('generated_password') }}</strong>
                            @endif
                        </span>
                    @endif
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                <div class="rounded-3xl bg-white shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-slate-500">Total Usuarios</p>
                            <h3 class="text-3xl font-semibold text-slate-900">{{ number_format($metrics['totalUsers']) }}</h3>
                            <p class="text-xs text-slate-400 mt-2">+12% desde el mes pasado</p>
                        </div>
                        <div class="bg-slate-100 text-slate-600 p-2 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.106a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.646 0-5.18-.574-7.5-1.644Z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-slate-500">Empresas Activas</p>
                            <h3 class="text-3xl font-semibold text-slate-900">{{ number_format($metrics['activeCompanies']) }}</h3>
                            <p class="text-xs text-slate-400 mt-2">+2 nuevas esta semana</p>
                        </div>
                        <div class="bg-slate-100 text-slate-600 p-2 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5v-9.75a2.25 2.25 0 0 1 2.25-2.25H9M19.5 12v7.5M3 20.25h4.5M21 20.25h-7.5" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5h3.75a2.25 2.25 0 0 1 2.25 2.25V9M13.5 9h6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-slate-500">Recolecciones Programadas</p>
                            <h3 class="text-3xl font-semibold text-slate-900">{{ number_format($metrics['scheduledToday']) }}</h3>
                            <p class="text-xs text-slate-400 mt-2">Para hoy</p>
                        </div>
                        <div class="bg-slate-100 text-slate-600 p-2 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5h7.5M5.25 7.5h13.5M5.25 10.5h13.5M5.25 13.5h13.5M8.25 16.5h7.5" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-slate-500">Completadas Hoy</p>
                            <h3 class="text-3xl font-semibold text-slate-900">{{ number_format($metrics['completedToday']) }}</h3>
                            <p class="text-xs text-slate-400 mt-2">57% del total programado</p>
                        </div>
                        <div class="bg-slate-100 text-slate-600 p-2 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125V8.25A2.25 2.25 0 0 1 5.25 6h13.5A2.25 2.25 0 0 1 21 8.25v10.5A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75v-.375M3 13.125h18M3 13.125l2.771 2.771a2.25 2.25 0 0 0 1.591.659h9.276a2.25 2.25 0 0 0 1.591-.659L21 13.125" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-white shadow-sm">
                <div class="flex flex-wrap border-b border-slate-100 text-sm font-medium text-slate-500">
                    <button type="button" class="px-6 py-4 transition"
                        :class="activeTab === 'collections' ? 'text-emerald-600 border-b-2 border-emerald-500' : 'hover:text-slate-700'"
                        x-on:click="activeTab = 'collections'">
                        Recolecciones
                    </button>
                    <button type="button" class="px-6 py-4 transition"
                        :class="activeTab === 'companies' ? 'text-emerald-600 border-b-2 border-emerald-500' : 'hover:text-slate-700'"
                        x-on:click="activeTab = 'companies'">
                        Empresas
                    </button>
                    <button type="button" class="px-6 py-4 transition"
                        :class="activeTab === 'users' ? 'text-emerald-600 border-b-2 border-emerald-500' : 'hover:text-slate-700'"
                        x-on:click="activeTab = 'users'">
                        Usuarios
                    </button>
                    <button type="button" class="px-6 py-4 transition"
                        :class="activeTab === 'reports' ? 'text-emerald-600 border-b-2 border-emerald-500' : 'hover:text-slate-700'"
                        x-on:click="activeTab = 'reports'">
                        Reportes
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <div x-show="activeTab === 'collections'" x-cloak>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Gestionar Recolecciones</h3>
                                <p class="text-sm text-slate-500">Programa y supervisa las recolecciones diarias</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <input type="date" value="{{ now()->format('Y-m-d') }}"
                                           class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                                </div>
                                <button type="button" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 7.5 21l5.096-2.313a6.75 6.75 0 1 0-2.782-2.783Z" />
                                    </svg>
                                    Ver rutas
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100 text-sm">
                                <thead>
                                    <tr class="text-left text-slate-500">
                                        <th class="py-3 font-medium">Dirección</th>
                                        <th class="py-3 font-medium">Empresa</th>
                                        <th class="py-3 font-medium">Estado</th>
                                        <th class="py-3 font-medium">Hora</th>
                                        <th class="py-3 font-medium text-right">Peso (kg)</th>
                                        <th class="py-3 font-medium text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($schedules as $schedule)
                                        <tr class="text-slate-700">
                                            <td class="py-3">{{ $schedule->address }}</td>
                                            <td class="py-3">{{ $schedule->company?->name ?? 'N/D' }}</td>
                                            <td class="py-3">
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
                                            <td class="py-3">
                                                {{ optional($schedule->scheduled_for)->format('H:i') ?? '—' }}
                                            </td>
                                            <td class="py-3 text-right">
                                                {{ $schedule->actual_weight ?? $schedule->estimated_weight ?? '—' }}
                                            </td>
                                            <td class="py-3">
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
                                                        <button type="submit" class="p-2 rounded-full bg-slate-100 text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition">
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
                                            <td colspan="6" class="py-6 text-center text-slate-400">Aún no hay recolecciones programadas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div x-show="activeTab === 'companies'" x-cloak>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Empresas Recolectoras</h3>
                                <p class="text-sm text-slate-500">Gestiona aliados de recolección</p>
                            </div>
                            <button
                                type="button"
                                x-on:click="showCompanyModal = true"
                                class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-600 transition"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                </svg>
                                Nueva empresa
                            </button>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @forelse ($companies as $company)
                                <div class="rounded-2xl border border-slate-100 p-5 shadow-sm">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="text-base font-semibold text-slate-900">{{ $company->name }}</h4>
                                            <p class="text-xs text-slate-400 uppercase tracking-wide mt-1">{{ $company->status }}</p>
                                        </div>
                                        <form action="{{ route('admin.companies.destroy', $company) }}" method="POST" onsubmit="return confirm('¿Eliminar empresa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-rose-600 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-5.02 5.02M9 9l5.02 5.02M5.75 5.75l12.5 12.5" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <dl class="mt-4 space-y-2 text-sm text-slate-600">
                                        @if($company->address)
                                            <div><span class="font-medium">Dirección:</span> {{ $company->address }}</div>
                                        @endif
                                        @if($company->contact_name)
                                            <div><span class="font-medium">Contacto:</span> {{ $company->contact_name }}</div>
                                        @endif
                                        @if($company->contact_email)
                                            <div><span class="font-medium">Email:</span> {{ $company->contact_email }}</div>
                                        @endif
                                        @if($company->contact_phone)
                                            <div><span class="font-medium">Tel:</span> {{ $company->contact_phone }}</div>
                                        @endif
                                    </dl>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400">Aún no hay empresas registradas.</p>
                            @endforelse
                        </div>
                    </div>

                    <div x-show="activeTab === 'users'" x-cloak>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Usuarios</h3>
                                <p class="text-sm text-slate-500">Control de accesos y roles</p>
                            </div>
                            <button
                                type="button"
                                x-on:click="showUserModal = true"
                                class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-600 transition"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Nuevo usuario
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100 text-sm">
                                <thead>
                                    <tr class="text-left text-slate-500">
                                        <th class="py-3 font-medium">Nombre</th>
                                        <th class="py-3 font-medium">Correo</th>
                                        <th class="py-3 font-medium">Tipo</th>
                                        <th class="py-3 font-medium">Registrado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($recentUsers as $user)
                                        <tr class="text-slate-700">
                                            <td class="py-3">{{ $user->name }}</td>
                                            <td class="py-3">{{ $user->email }}</td>
                                            <td class="py-3">
                                                <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                    {{ ucfirst($user->user_type ?? 'cliente') }}
                                                </span>
                                            </td>
                                            <td class="py-3">{{ optional($user->created_at)->format('d/m/Y') ?? '—' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-6 text-center text-slate-400">Todavía no hay usuarios.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div x-show="activeTab === 'reports'" x-cloak>
                        <div class="max-w-xl">
                            <h3 class="text-lg font-semibold text-slate-900 mb-2">Generar reportes</h3>
                            <p class="text-sm text-slate-500 mb-6">
                                Exporta las recolecciones en formato CSV según rango de fechas y estado.
                            </p>
                            <form action="{{ route('admin.reports.collections') }}" method="POST" class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-600 mb-1">Desde</label>
                                        <input type="date" name="start_date"
                                               class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300"
                                               required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-600 mb-1">Hasta</label>
                                        <input type="date" name="end_date"
                                               class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300"
                                               required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Estado</label>
                                    <select name="status"
                                            class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                                        <option value="">Todos</option>
                                        <option value="{{ \App\Models\CollectionSchedule::STATUS_SCHEDULED }}">Programado</option>
                                        <option value="{{ \App\Models\CollectionSchedule::STATUS_IN_PROGRESS }}">En progreso</option>
                                        <option value="{{ \App\Models\CollectionSchedule::STATUS_COMPLETED }}">Completado</option>
                                        <option value="{{ \App\Models\CollectionSchedule::STATUS_CANCELLED }}">Cancelado</option>
                                    </select>
                                </div>
                                <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V12a9 9 0 0 1 18 0v4.5M7.5 19.5l4.5 4.5 4.5-4.5M12 24V12" />
                                    </svg>
                                    Descargar CSV
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Programar recolección -->
        <div
            class="fixed inset-0 z-40 flex items-center justify-center bg-slate-900/50 px-4"
            x-show="showCollectionModal"
            x-cloak
        >
            <div class="w-full max-w-2xl rounded-3xl bg-white p-6 shadow-xl relative">
                <button type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600" x-on:click="closeModals()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 18 12-12M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="text-xl font-semibold text-slate-900 mb-1">Programar nueva recolección</h3>
                <p class="text-sm text-slate-500 mb-6">Registra fecha, empresa y detalles de la ruta.</p>

                <form action="{{ route('admin.collections.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Empresa</label>
                            <select name="collector_company_id" required
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                                <option value="">Selecciona una empresa</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Dirección de recolección</label>
                            <input type="text" name="address" required
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Fecha</label>
                            <input type="date" name="scheduled_for_date" required
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Hora</label>
                            <input type="time" name="scheduled_for_time" required
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Peso estimado (kg)</label>
                            <input type="number" step="0.01" min="0" name="estimated_weight"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Notas</label>
                            <textarea name="notes" rows="3"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50" x-on:click="closeModals()">Cancelar</button>
                        <button type="submit" class="rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Programar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Crear empresa -->
        <div
            class="fixed inset-0 z-40 flex items-center justify-center bg-slate-900/50 px-4"
            x-show="showCompanyModal"
            x-cloak
        >
            <div class="w-full max-w-xl rounded-3xl bg-white p-6 shadow-xl relative">
                <button type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600" x-on:click="closeModals()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 18 12-12M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="text-xl font-semibold text-slate-900 mb-1">Registrar nueva empresa</h3>
                <p class="text-sm text-slate-500 mb-6">Agrega aliados para futuras recolecciones.</p>

                <form action="{{ route('admin.companies.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Nombre</label>
                        <input type="text" name="name" required
                            class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Contacto</label>
                            <input type="text" name="contact_name"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Teléfono</label>
                            <input type="text" name="contact_phone"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Correo</label>
                        <input type="email" name="contact_email"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Dirección</label>
                        <input type="text" name="address"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Estado</label>
                        <select name="status"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                            <option value="active">Activa</option>
                            <option value="paused">En pausa</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Notas</label>
                        <textarea name="notes" rows="3"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300"></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50" x-on:click="closeModals()">Cancelar</button>
                        <button type="submit" class="rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Crear usuario -->
        <div
            class="fixed inset-0 z-40 flex items-center justify-center bg-slate-900/50 px-4"
            x-show="showUserModal"
            x-cloak
        >
            <div class="w-full max-w-xl rounded-3xl bg-white p-6 shadow-xl relative">
                <button type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600" x-on:click="closeModals()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 18 12-12M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="text-xl font-semibold text-slate-900 mb-1">Crear nuevo usuario</h3>
                <p class="text-sm text-slate-500 mb-6">Define tipo de usuario y credenciales.</p>

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Nombre completo</label>
                        <input type="text" name="name" required
                            class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Correo</label>
                        <input type="email" name="email" required
                            class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Tipo de usuario</label>
                            <select name="user_type" required
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                                <option value="admin">Administrador</option>
                                <option value="recolector">Recolector</option>
                                <option value="cliente">Cliente</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Teléfono</label>
                            <input type="text" name="phone"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Dirección</label>
                        <input type="text" name="address"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Contraseña (opcional)</label>
                        <input type="password" name="password" placeholder="Se generará una contraseña segura si lo dejas vacío"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50" x-on:click="closeModals()">Cancelar</button>
                        <button type="submit" class="rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Crear usuario</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Actualizar estado de recolección -->
        <div
            class="fixed inset-0 z-40 flex items-center justify-center bg-slate-900/50 px-4"
            x-show="showStatusModal"
            x-cloak
        >
            <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-xl relative">
                <button type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600" x-on:click="closeModals()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 18 12-12M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="text-xl font-semibold text-slate-900 mb-1">Actualizar recolección</h3>
                <p class="text-sm text-slate-500 mb-6">Cambia estado, peso y notas del servicio.</p>

                <template x-if="selectedSchedule">
                    <form
                        :action="`{{ url('admin/collections') }}/${selectedSchedule?.id}`"
                        method="POST"
                        class="space-y-4"
                    >
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Estado</label>
                            <select name="status" x-model="statusForm.status"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                                <option value="{{ \App\Models\CollectionSchedule::STATUS_SCHEDULED }}">Programado</option>
                                <option value="{{ \App\Models\CollectionSchedule::STATUS_IN_PROGRESS }}">En progreso</option>
                                <option value="{{ \App\Models\CollectionSchedule::STATUS_COMPLETED }}">Completado</option>
                                <option value="{{ \App\Models\CollectionSchedule::STATUS_CANCELLED }}">Cancelado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Peso real (kg)</label>
                            <input type="number" step="0.01" min="0" name="actual_weight" x-model="statusForm.actual_weight"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Notas</label>
                            <textarea name="notes" rows="3" x-model="statusForm.notes"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-300"></textarea>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50" x-on:click="closeModals()">Cancelar</button>
                            <button type="submit" class="rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Actualizar</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
