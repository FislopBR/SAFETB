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
                <div id="share-graph" class="relative h-56 w-56 rounded-full bg-slate-100" data-share="{{ $share }}">
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
                        <tr class="history-row cursor-pointer hover:bg-slate-50" data-id="{{ $authorization->id }}" data-student="{{ $authorization->student_name }}" data-action="{{ $authorization->action }}" data-time="{{ substr($authorization->scheduled_time, 0, 5) }}" data-classroom="{{ $authorization->classroom }}" data-lesson="{{ $authorization->lesson }}" data-date="{{ $authorization->date->format('d/m/Y') }}" data-status="{{ $authorization->status_label }}" data-authorized-by="{{ $authorization->authorized_by ?: '—' }}" data-absence="{{ $authorization->absence ? 'true' : 'false' }}">
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $authorization->id }}</td>
                            <td class="px-4 py-4">{{ $authorization->student_name }}</td>
                            <td class="px-4 py-4">{{ ucfirst($authorization->action) }} às {{ substr($authorization->scheduled_time, 0, 5) }}</td>
                            <td class="px-4 py-4">{{ $authorization->classroom }}</td>
                            <td class="px-4 py-4">
                                @if($authorization->status === \App\Models\Authorization::STATUS_NEGADO)
                                    <span class="text-rose-700">{{ $authorization->status_label }}</span>
                                @elseif($authorization->status === \App\Models\Authorization::STATUS_CONFIRMED)
                                    <span class="text-emerald-700">{{ $authorization->status_label }}</span>
                                @else
                                    <span class="text-slate-700">{{ $authorization->status_label }}</span>
                                @endif
                            </td>
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

<div id="authorization-modal" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/50 p-4">
    <div class="w-full max-w-3xl overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <h3 class="text-xl font-semibold text-slate-900">Pré-autorização</h3>
                <p class="text-sm text-slate-500">Detalhes completos da solicitação.</p>
            </div>
            <button id="modal-close" class="rounded-full bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Fechar</button>
        </div>
        <div class="space-y-6 px-6 py-6 text-slate-700">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm uppercase text-slate-500">Aluno</p>
                    <p id="modal-student" class="mt-2 text-lg font-semibold text-slate-900"></p>
                </div>
                <div>
                    <p class="text-sm uppercase text-slate-500">Turma</p>
                    <p id="modal-classroom" class="mt-2 text-lg font-semibold text-slate-900"></p>
                </div>
                <div>
                    <p class="text-sm uppercase text-slate-500">Aula</p>
                    <p id="modal-lesson" class="mt-2 text-lg font-semibold text-slate-900"></p>
                </div>
                <div>
                    <p class="text-sm uppercase text-slate-500">Data / Hora</p>
                    <p id="modal-date" class="mt-2 text-lg font-semibold text-slate-900"></p>
                </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm uppercase text-slate-500">Entrada</p>
                    <p id="modal-entry" class="mt-2 text-sm font-semibold text-slate-900"></p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm uppercase text-slate-500">Saída</p>
                    <p id="modal-exit" class="mt-2 text-sm font-semibold text-slate-900"></p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm uppercase text-slate-500">Falta</p>
                    <p id="modal-absence" class="mt-2 text-sm font-semibold text-slate-900"></p>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm uppercase text-slate-500">Autorizado por</p>
                    <p id="modal-authorized-by" class="mt-2 text-base text-slate-900"></p>
                </div>
                <div>
                    <p class="text-sm uppercase text-slate-500">Código de Série</p>
                    <p id="modal-code" class="mt-2 text-base text-slate-900"></p>
                </div>
            </div>
            <div>
                <p class="text-sm uppercase text-slate-500">Status</p>
                <p id="modal-status" class="mt-2 text-base font-semibold text-emerald-700"></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('authorization-modal');
        const closeButton = document.getElementById('modal-close');
        const rows = document.querySelectorAll('.history-row');

        const fields = {
            student: document.getElementById('modal-student'),
            classroom: document.getElementById('modal-classroom'),
            lesson: document.getElementById('modal-lesson'),
            date: document.getElementById('modal-date'),
            entry: document.getElementById('modal-entry'),
            exit: document.getElementById('modal-exit'),
            absence: document.getElementById('modal-absence'),
            authorizedBy: document.getElementById('modal-authorized-by'),
            code: document.getElementById('modal-code'),
            status: document.getElementById('modal-status'),
        };

        const openModal = function (data) {
            fields.student.textContent = data.student;
            fields.classroom.textContent = data.classroom || '—';
            fields.lesson.textContent = data.lesson ? data.lesson + 'ª' : '—';
            fields.date.textContent = data.date + ' • ' + data.time;
            fields.entry.textContent = data.action === 'entrada' ? '✔ Entrada' : '✗ Entrada';
            fields.exit.textContent = data.action === 'saida' ? '✔ Saída' : '✗ Saída';
            fields.absence.textContent = data.absence === 'true' ? 'Com falta' : 'Sem falta';
            fields.authorizedBy.textContent = data.authorizedBy || '—';
            fields.code.textContent = data.id;
            fields.status.textContent = data.status;
            modal.classList.remove('hidden');
        };

        rows.forEach(function (row) {
            row.addEventListener('click', function () {
                openModal(row.dataset);
            });
        });

        closeButton.addEventListener('click', function () {
            modal.classList.add('hidden');
        });

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });

        // Aplicar o gráfico de rosca com base no data-share
        const shareEl = document.getElementById('share-graph');
        if (shareEl) {
            const shareValue = Number(shareEl.dataset.share || 0);
            shareEl.style.background = `conic-gradient(#22c55e 0 ${shareValue}%, #fb923c ${shareValue}% 100%)`;
        }
    });
</script>
@endsection