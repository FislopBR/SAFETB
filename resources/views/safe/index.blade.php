@extends('safe.layout')

@section('content')
<div class="grid gap-6 sm:grid-cols-3">
    <a href="{{ route('safe.responsavel.index') }}" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
        <div class="text-lg font-semibold text-slate-900">Responsável</div>
        <p class="mt-3 text-sm text-slate-600">Cria a pré-autorização digital do aluno.</p>
        <span class="mt-4 inline-flex items-center gap-2 text-sm text-cyan-700">Acessar painel &rarr;</span>
    </a>

    <a href="{{ route('safe.professor.index') }}" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
        <div class="text-lg font-semibold text-slate-900">Professor</div>
        <p class="mt-3 text-sm text-slate-600">Valida a liberação em sala antes da confirmação física.</p>
        <span class="mt-4 inline-flex items-center gap-2 text-sm text-emerald-700">Acessar painel &rarr;</span>
    </a>

    <a href="{{ route('safe.portaria.index') }}" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
        <div class="text-lg font-semibold text-slate-900">Portaria</div>
        <p class="mt-3 text-sm text-slate-600">Confirma a entrada/saída física e dispara notificações.</p>
        <span class="mt-4 inline-flex items-center gap-2 text-sm text-orange-700">Acessar painel &rarr;</span>
    </a>
</div>
@endsection
