@extends('safe.layout')

@section('content')
<div class="space-y-8">
    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <h2 class="text-2xl font-semibold text-slate-900">Painel do Professor</h2>
        <p class="mt-2 text-sm text-slate-600">Aprovação de entradas e saídas em sala, com histórico de confirmações.</p>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Aprovações pendentes</h3>
            <p class="mt-2 text-sm text-slate-600">Confirme entrada ou saída para liberar o fluxo.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-4 py-4">ID</th>
                        <th class="px-4 py-4">Aluno</th>
                        <th class="px-4 py-4">Ação</th>
                        <th class="px-4 py-4">Aula</th>
                        <th class="px-4 py-4">Data</th>
                        <th class="px-4 py-4">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($pending as $authorization)
                        <tr>
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $authorization->id }}</td>
                            <td class="px-4 py-4">{{ $authorization->student_name }}</td>
                            <td class="px-4 py-4">{{ ucfirst($authorization->action) }} às {{ substr($authorization->scheduled_time, 0, 5) }}</td>
                            <td class="px-4 py-4">{{ $authorization->lesson }}ª</td>
                            <td class="px-4 py-4">{{ $authorization->date->format('d/m/Y') }}</td>
                            <td class="px-4 py-4">
                                <form action="{{ route('safe.professor.approve', $authorization) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Aprovar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">Nenhuma solicitação pendente.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Histórico</h3>
            <p class="mt-2 text-sm text-slate-600">Registros de autorizações já confirmadas.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-4 py-4">ID</th>
                        <th class="px-4 py-4">Aluno</th>
                        <th class="px-4 py-4">Ação</th>
                        <th class="px-4 py-4">Turma</th>
                        <th class="px-4 py-4">Data</th>
                        <th class="px-4 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($history as $authorization)
                        <tr>
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $authorization->id }}</td>
                            <td class="px-4 py-4">{{ $authorization->student_name }}</td>
                            <td class="px-4 py-4">{{ ucfirst($authorization->action) }} às {{ substr($authorization->scheduled_time, 0, 5) }}</td>
                            <td class="px-4 py-4">{{ $authorization->classroom }}</td>
                            <td class="px-4 py-4">{{ $authorization->date->format('d/m/Y') }}</td>
                            <td class="px-4 py-4 text-emerald-700">Confirmado</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">Nenhum histórico disponível.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
