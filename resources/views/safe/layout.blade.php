<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAFE - Prototipo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-4 py-6">
        <header class="mb-8 flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('home') }}" class="text-3xl font-semibold text-slate-900 hover:text-cyan-600">SAFE</a>
                <p class="mt-2 text-sm text-slate-600">Protótipo de controle de pré-autorização, validação em sala e confirmação física.</p>
            </div>
            <nav class="flex flex-wrap items-center gap-2 text-sm">
                @guest
                    <a href="{{ route('login') }}" class="rounded-full border border-slate-300 bg-slate-100 px-4 py-2 text-slate-700 hover:bg-slate-200">Login</a>
                    <a href="{{ route('register') }}" class="rounded-full border border-cyan-300 bg-cyan-50 px-4 py-2 text-cyan-800 hover:bg-cyan-100">Cadastro</a>
                @else
                    <span class="rounded-full border border-slate-300 bg-slate-100 px-4 py-2 text-slate-700">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                    <a href="{{ route('dashboard') }}" class="rounded-full border border-slate-300 bg-slate-100 px-4 py-2 text-slate-700 hover:bg-slate-200">Painel</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="rounded-full border border-rose-300 bg-rose-50 px-4 py-2 text-rose-800 hover:bg-rose-100">Sair</button>
                    </form>
                @endguest
            </nav>
        </header>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-900">{{ session('success') }}</div>
        @endif
        @if(session('warning'))
            <div class="mb-6 rounded-2xl bg-amber-50 border border-amber-200 p-4 text-amber-900">{{ session('warning') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
