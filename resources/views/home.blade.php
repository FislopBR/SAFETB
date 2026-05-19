@extends('safe.layout')

@section('content')
<div class="grid gap-12 lg:grid-cols-[1.2fr_0.8fr]">
    <div class="rounded-3xl bg-white p-10 shadow-sm">
        <div class="mb-8 max-w-2xl">
            <h1 class="text-4xl font-semibold text-slate-900">SAFE - Sistema de Autorização Escolar</h1>
            <p class="mt-4 text-lg leading-8 text-slate-600">Um protótipo para pré-autorização de alunos, validação em sala e confirmação física pela portaria.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <h2 class="text-xl font-semibold text-slate-900">Controle de fluxo</h2>
                <p class="mt-3 text-sm text-slate-600">Gerencie entradas e saídas com etapas claras de aprovação.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <h2 class="text-xl font-semibold text-slate-900">Notificações</h2>
                <p class="mt-3 text-sm text-slate-600">E-mail simulado pelo Mailpit e WhatsApp registrado via log do sistema.</p>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-white shadow-sm hover:bg-cyan-700">Login</a>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-slate-900 hover:bg-slate-100">Cadastro</a>
        </div>
    </div>

    <div class="rounded-3xl bg-slate-900 p-10 text-white shadow-sm">
        <h2 class="text-2xl font-semibold">Visão geral do SAFE</h2>
        <p class="mt-4 text-slate-300">O SAFE simula um fluxo de autorização com três perfis distintos:</p>
        <ul class="mt-6 space-y-3 text-sm text-slate-300">
            <li>• Responsável: cria pré-autorização e acompanha solicitações.</li>
            <li>• Professor: valida liberações de entrada e saída em sala.</li>
            <li>• Portaria: confirma fisicamente as saídas autorizadas.</li>
        </ul>
    </div>
</div>
@endsection
