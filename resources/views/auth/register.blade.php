@extends('safe.layout')

@section('content')
<div class="mx-auto max-w-xl rounded-3xl bg-white p-10 shadow-sm">
    <h1 class="text-3xl font-semibold text-slate-900">Cadastro</h1>
    <p class="mt-2 text-sm text-slate-600">Crie um novo usuário para acessar o SAFE.</p>

    @if($errors->any())
        <div class="mt-6 rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-900">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.perform') }}" method="POST" class="mt-8 space-y-6">
        @csrf

        <label class="block">
            <span class="text-sm font-medium text-slate-700">Nome</span>
            <input type="text" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none" required>
        </label>

        <label class="block">
            <span class="text-sm font-medium text-slate-700">E-mail</span>
            <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none" required>
        </label>

        <label class="block">
            <span class="text-sm font-medium text-slate-700">Senha</span>
            <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none" required>
        </label>

        <label class="block">
            <span class="text-sm font-medium text-slate-700">Confirmar senha</span>
            <input type="password" name="password_confirmation" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none" required>
        </label>

        <label class="block">
            <span class="text-sm font-medium text-slate-700">Cargo</span>
            <select name="role" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none" required>
                <option value="">Selecione um cargo...</option>
                <option value="responsavel">Responsável</option>
                <option value="professor">Professor</option>
                <option value="portaria">Portaria</option>
            </select>
        </label>

        <button type="submit" class="w-full rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold text-white hover:bg-cyan-700">Cadastrar</button>
    </form>
</div>
@endsection
