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
])]
class Authorization extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pendente';
    public const STATUS_AUTHORIZED = 'autorizado';
    public const STATUS_CONFIRMED = 'confirmado';

    protected $casts = [
        'date' => 'date',
        'scheduled_time' => 'string',
        'absence' => 'boolean',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_AUTHORIZED => 'Autorizado pelo professor',
            self::STATUS_CONFIRMED => 'Confirmado pela portaria',
            default => 'Pendente de validação',
        };
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
