<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'professor_name',
    'student_name',
    'classroom',
    'action',
    'scheduled_time',
    'absence',
    'lesson',
    'authorized_by',
    'date',
    'created_by',
    'status',
    'professor_validated_at',
    'portaria_confirmed_at',
])]
class Authorization extends Model
{
    use HasFactory;

    public const STATUS_AGUARDO = 'aguardo';
    public const STATUS_CONFIRMED = 'confirmado';
    public const STATUS_NEGADO = 'negado';

    protected $casts = [
        'date' => 'date',
        'scheduled_time' => 'string',
        'absence' => 'boolean',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_AGUARDO, 'pendente' => $this->action === 'sair'
                ? ($this->professor_validated_at ? 'Aguardando confirmação da portaria' : 'Aguardando validação do professor')
                : 'Aguardando validação do professor',
            self::STATUS_CONFIRMED => $this->action === 'sair'
                ? 'Confirmado por: Professor + Portaria'
                : 'Confirmado por: Professor',
            self::STATUS_NEGADO => 'Negado',
            default => 'Desconhecido',
        };
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
