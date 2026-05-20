<?php

namespace App\Http\Controllers;

use App\Mail\PortariaNotification;
use App\Models\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthorizationController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        return match ($user->role) {
            'responsavel' => redirect()->route('safe.responsavel.index'),
            'professor' => redirect()->route('safe.professor.index'),
            'portaria' => redirect()->route('safe.portaria.index'),
            default => redirect()->route('home')->with('warning', 'Perfil inválido.'),
        };
    }

    public function responsavelDashboard()
    {
        if ($redirect = $this->authorizeRole('responsavel')) {
            return $redirect;
        }

        $authorizations = Authorization::latest()->get();
        $entradas = $authorizations->where('action', 'entrar')->count();
        $saidas = $authorizations->where('action', 'sair')->count();

        return view('safe.responsavel.index', compact('authorizations', 'entradas', 'saidas'));
    }

    public function create()
    {
        if ($redirect = $this->authorizeRole('responsavel')) {
            return $redirect;
        }

        return view('safe.responsavel.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->authorizeRole('responsavel')) {
            return $redirect;
        }

        $data = $request->validate([
            'professor_name' => 'required|string|max:255',
            'student_name' => 'required|string|max:255',
            'classroom' => 'required|string|max:255',
            'action' => 'required|in:entrar,sair',
            'scheduled_time' => 'required|date_format:H:i',
            'absence' => 'nullable|boolean',
            'lesson' => 'required|integer|min:1|max:5',
            'authorized_by' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Authorization::create([
            'professor_name' => $data['professor_name'],
            'student_name' => $data['student_name'],
            'classroom' => $data['classroom'],
            'action' => $data['action'],
            'scheduled_time' => $data['scheduled_time'],
            'absence' => $request->has('absence'),
            'lesson' => $data['lesson'],
            'authorized_by' => $data['authorized_by'],
            'date' => $data['date'],
            'status' => Authorization::STATUS_AGUARDO,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('safe.responsavel.index')->with('success', 'Pré-autorização criada com sucesso.');
    }

    public function professorDashboard()
    {
        if ($redirect = $this->authorizeRole('professor')) {
            return $redirect;
        }

        $pending = Authorization::where('status', Authorization::STATUS_AGUARDO)->latest()->get();
        $history = Authorization::where('status', Authorization::STATUS_CONFIRMED)->latest()->get();

        return view('safe.professor.index', compact('pending', 'history'));
    }

    public function approve(Authorization $authorization)
    {
        if ($redirect = $this->authorizeRole('professor')) {
            return $redirect;
        }

        if ($authorization->status !== Authorization::STATUS_AGUARDO) {
            return redirect()->route('safe.professor.index')->with('warning', 'A autorização já foi processada.');
        }

        // Marca validação do professor
        $authorization->update([
            'professor_validated_at' => now(),
        ]);

        // Regras de aprovação:
        // - Se for "entrar": professor valida e sistema confirma automaticamente (não precisa passar pela portaria)
        // - Se for "sair": fica como autorizado e aguarda confirmação da portaria
        if ($authorization->action === 'entrar') {
            $authorization->update([
                'status' => Authorization::STATUS_CONFIRMED,
            ]);

            Mail::to('mailpit@localhost')->send(new PortariaNotification($authorization));
            Log::info("WhatsApp simulado: aluno {$authorization->student_name} recebeu confirmação automática de entrada às {$authorization->scheduled_time}.");

            return redirect()->route('safe.professor.index')->with('success', 'Entrada validada pelo professor e confirmada automaticamente. Notificações disparadas.');
        }

        // Para saídas: professor valida, mantém em 'aguardo' até a portaria confirmar
        $authorization->update([
            'status' => Authorization::STATUS_AGUARDO,
        ]);

        return redirect()->route('safe.professor.index')->with('success', 'Liberação validada em sala pelo professor. Aguardando confirmação da portaria.');
    }

    public function portariaDashboard()
    {
        if ($redirect = $this->authorizeRole('portaria')) {
            return $redirect;
        }

        $pending = Authorization::where('action', 'sair')
            ->where('status', Authorization::STATUS_AGUARDO)
            ->whereNotNull('professor_validated_at')
            ->latest()
            ->get();

        $history = Authorization::where('action', 'sair')
            ->where('status', Authorization::STATUS_CONFIRMED)
            ->latest()
            ->get();

        return view('safe.portaria.index', compact('pending', 'history'));
    }

    public function confirm(Authorization $authorization)
    {
        if ($redirect = $this->authorizeRole('portaria')) {
            return $redirect;
        }

        if ($authorization->action !== 'sair' || $authorization->status !== Authorization::STATUS_AGUARDO || ! $authorization->professor_validated_at) {
            return redirect()->route('safe.portaria.index')->with('warning', 'Somente saídas autorizadas pelo professor podem ser confirmadas pela portaria.');
        }

        $authorization->update([
            'status' => Authorization::STATUS_CONFIRMED,
            'portaria_confirmed_at' => now(),
        ]);

        Mail::to('mailpit@localhost')->send(new PortariaNotification($authorization));

        Log::info("WhatsApp simulado: aluno {$authorization->student_name} recebeu confirmação de saída às {$authorization->scheduled_time}.");

        return redirect()->route('safe.portaria.index')->with('success', 'Saída confirmada e notificações disparadas.');
    }

    public function deny(Authorization $authorization)
    {
        // Apenas professor ou portaria podem negar solicitações
        if (!in_array(Auth::user()->role, ['professor', 'portaria'])) {
            return redirect()->route('dashboard')->with('warning', 'Acesso não autorizado para esta ação.');
        }

        // Não negar quando já confirmado
        if ($authorization->status === Authorization::STATUS_CONFIRMED) {
            return back()->with('warning', 'Não é possível negar uma autorização já confirmada.');
        }

        $authorization->update([
            'status' => Authorization::STATUS_NEGADO,
        ]);

        return back()->with('success', 'Pré-autorização negada.');
    }

    protected function authorizeRole(string $role)
    {
        if (Auth::user()->role !== $role) {
            return redirect()->route('dashboard')->with('warning', 'Acesso não autorizado para este perfil.');
        }

        return null;
    }
}
