@extends('safe.layout')

@section('content')
<div class="rounded-3xl bg-white p-8 shadow-sm">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-slate-900">Nova Pré-autorização</h2>
        <p class="mt-2 text-sm text-slate-600">Preencha os dados do formulário digital e envie para validação.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-900">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('safe.responsavel.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid gap-6 sm:grid-cols-2">
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Professor</span>
                <input type="text" name="professor_name" value="{{ old('professor_name') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none" placeholder="Nome do professor">
            </label>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Aluno</span>
                <input type="text" name="student_name" value="{{ old('student_name') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none" placeholder="Nome do aluno">
            </label>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Turma</span>
                <input type="text" name="classroom" value="{{ old('classroom') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none" placeholder="Ex: 2º Ano B">
            </label>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Aula</span>
                <select name="lesson" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none">
                    <option value="">Selecione</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('lesson') == $i ? 'selected' : '' }}>{{ $i }}º</option>
                    @endfor
                </select>
            </label>
        </div>

        <div class="grid gap-6 sm:grid-cols-3">
            <div class="space-y-2 rounded-3xl border border-slate-200 bg-slate-50 p-4">
                <span class="text-sm font-medium text-slate-700">Ação</span>
                <label class="flex items-center gap-3">
                    <input type="radio" name="action" value="entrar" {{ old('action', 'entrar') === 'entrar' ? 'checked' : '' }} class="h-4 w-4 text-cyan-600">
                    <span>Entrar</span>
                </label>
                <label class="flex items-center gap-3">
                    <input type="radio" name="action" value="sair" {{ old('action') === 'sair' ? 'checked' : '' }} class="h-4 w-4 text-cyan-600">
                    <span>Sair</span>
                </label>
            </div>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Sair / Hora</span>
                <input type="time" name="scheduled_time" value="{{ old('scheduled_time', now()->format('H:i')) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none">
            </label>

            <label class="flex items-center gap-3 rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3">
                <input type="checkbox" name="absence" value="1" {{ old('absence') ? 'checked' : '' }} class="h-4 w-4 text-rose-600">
                <span class="text-sm text-slate-700">Com falta</span>
            </label>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Autorizado por</span>
                <input type="text" name="authorized_by" value="{{ old('authorized_by') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none" placeholder="Nome do responsável">
            </label>

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Data</span>
                <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none">
            </label>
        </div>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('safe.responsavel.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Voltar</a>
            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-cyan-700">Enviar pré-autorização</button>
        </div>
    </form>
</div>
@endsection
