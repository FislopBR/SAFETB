@extends('safe.layout')

@section('content')
<div class="mx-auto max-w-xl rounded-3xl bg-white p-10 shadow-sm">
    <h1 class="text-3xl font-semibold text-slate-900">Login</h1>
    <p class="mt-2 text-sm text-slate-600">Acesse sua conta SAFE para visualizar o painel apropriado.</p>

    @if($errors->any())
        <div class="mt-6 rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-900">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login.perform') }}" method="POST" class="mt-8 space-y-6">
        @csrf
        <label class="block">
            <span class="text-sm font-medium text-slate-700">E-mail</span>
            <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none" required>
        </label>

        <label class="block">
            <span class="text-sm font-medium text-slate-700">Senha</span>
            <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-cyan-500 focus:outline-none" required>
        </label>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
                Lembrar de mim
            </label>
            <a href="{{ route('register') }}" class="text-sm font-semibold text-cyan-600 hover:text-cyan-800">Criar conta</a>
        </div>

        <button type="submit" class="w-full rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold text-white hover:bg-cyan-700">Entrar</button>
    </form>
</div>
@endsection
