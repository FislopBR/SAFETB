@extends('safe.layout')

@section('content')
<div class="space-y-8">
    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <h2 class="text-2xl font-semibold text-slate-900">Painel da Portaria</h2>
        <p class="mt-2 text-sm text-slate-600">Confirme as saídas autorizadas e acompanhe o histórico de confirmações.</p>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Saídas para confirmação</h3>
            <p class="mt-2 text-sm text-slate-600">Apenas saídas autorizadas pelo professor aparecem aqui.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-4 py-4">ID</th>
                        <th class="px-4 py-4">Aluno</th>
                        <th class="px-4 py-4">Turma</th>
                        <th class="px-4 py-4">Ação</th>
                        <th class="px-4 py-4">Data</th>
                        <th class="px-4 py-4">Confirmar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($pending as $authorization)
                        <tr>
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $authorization->id }}</td>
                            <td class="px-4 py-4">{{ $authorization->student_name }}</td>
                            <td class="px-4 py-4">{{ $authorization->classroom }}</td>
                            <td class="px-4 py-4">{{ ucfirst($authorization->action) }} às {{ substr($authorization->scheduled_time, 0, 5) }}</td>
                            <td class="px-4 py-4">{{ $authorization->date->format('d/m/Y') }}</td>
                            <td class="px-4 py-4">
                                <form action="{{ route('safe.portaria.confirm', $authorization) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-full bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700">Confirmar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">Nenhuma saída aguardando confirmação.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Histórico de saídas</h3>
            <p class="mt-2 text-sm text-slate-600">Registros de saídas confirmadas pela portaria.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-4 py-4">ID</th>
                        <th class="px-4 py-4">Aluno</th>
                        <th class="px-4 py-4">Turma</th>
                        <th class="px-4 py-4">Ação</th>
                        <th class="px-4 py-4">Data</th>
                        <th class="px-4 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($history as $authorization)
                        <tr>
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $authorization->id }}</td>
                            <td class="px-4 py-4">{{ $authorization->student_name }}</td>
                            <td class="px-4 py-4">{{ $authorization->classroom }}</td>
                            <td class="px-4 py-4">{{ ucfirst($authorization->action) }} às {{ substr($authorization->scheduled_time, 0, 5) }}</td>
                            <td class="px-4 py-4">{{ $authorization->date->format('d/m/Y') }}</td>
                            <td class="px-4 py-4 text-emerald-700">Confirmado</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">Nenhum histórico de saídas encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
