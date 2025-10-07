<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use App\Models\User;

class CollectionSchedule extends Model
{
    use HasFactory;

    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';
    public const TYPE_INORGANIC = 'Inorgánico reciclable';
    public const TYPE_HAZARDOUS = 'Residuo peligroso';
    public const TYPE_ORGANIC = 'Residuo orgánico';

    protected $fillable = [
        'user_id',
        'collector_company_id',
        'address',
        'type',
        'scheduled_for',
        'status',
        'estimated_weight',
        'actual_weight',
        'notes',
        'points_awarded',
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
        'estimated_weight' => 'decimal:2',
        'actual_weight' => 'decimal:2',
        'points_awarded' => 'integer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(CollectorCompany::class, 'collector_company_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_COMPLETED => 'Completado',
            self::STATUS_IN_PROGRESS => 'En progreso',
            self::STATUS_CANCELLED => 'Cancelado',
            default => 'Programado',
        };
    }

    public function scopeForDate($query, Carbon|string $date)
    {
        $date = $date instanceof Carbon ? $date : Carbon::parse($date);

        return $query->whereBetween('scheduled_for', [
            $date->copy()->startOfDay(),
            $date->copy()->endOfDay(),
        ]);
    }

    public static function calculatePoints(string $type, ?float $weight): int
    {
        $rules = config('collection_rules.points');
        $perKg = $rules['per_kg'][$type] ?? ($rules['default_per_kg'] ?? 1);
        $base = round(max(0, $weight ?? 0) * $perKg);

        $bonus = 0;
        if (($weight ?? 0) > 0) {
            $bonus = $rules['separation_bonus'][$type] ?? ($rules['default_bonus'] ?? 0);
        }

        $min = $rules['min_award'] ?? 0;

        return (int) max($min, $base + $bonus);
    }
}
