@extends('safe.layout')

@section('content')
<div class="space-y-8">
    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900">Painel do Responsável</h2>
                <p class="mt-2 text-sm text-slate-600">Visualize o resumo de entradas e saídas e crie novas pré-autorização.</p>
            </div>
            <a href="{{ route('safe.responsavel.create') }}" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-cyan-700">Nova Pré-autorização</a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[360px_1fr]">
        @php
            $share = $entradas + $saidas > 0 ? round($entradas / ($entradas + $saidas) * 100, 0) : 0;
            $conicBackground = "background: conic-gradient(#22c55e 0 {$share}%, #fb923c {$share}% 100%)";
        @endphp
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900">Resumo de solicitações</h3>
            <div class="mt-6 flex flex-col items-center gap-4">
                @php echo '<div class="relative h-56 w-56 rounded-full bg-slate-100" style="'.$conicBackground.'">'; @endphp
                    <div class="absolute inset-12 rounded-full bg-white"></div>
                </div>
                <div class="w-full space-y-3">
                    <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <span class="text-sm text-slate-600">Entradas</span>
                        <strong class="text-slate-900">{{ $entradas }}</strong>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <span class="text-sm text-slate-600">Saídas</span>
                        <strong class="text-slate-900">{{ $saidas }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="p-6 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Pré-autorização</h3>
                <p class="mt-2 text-sm text-slate-600">Tabela de solicitações criadas.</p>
            </div>
            <table class="w-full border-collapse text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-4 py-4">ID</th>
                        <th class="px-4 py-4">Aluno</th>
                        <th class="px-4 py-4">Ação</th>
                        <th class="px-4 py-4">Turma</th>
                        <th class="px-4 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($authorizations as $authorization)
                        <tr>
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $authorization->id }}</td>
                            <td class="px-4 py-4">{{ $authorization->student_name }}</td>
                            <td class="px-4 py-4">{{ ucfirst($authorization->action) }} às {{ substr($authorization->scheduled_time, 0, 5) }}</td>
                            <td class="px-4 py-4">{{ $authorization->classroom }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $authorization->status_label }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">Nenhuma pré-autorização criada ainda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection