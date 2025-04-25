<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;

    // Константи для статусів та пріоритетів
    const STATUS_PENDING = 'Очікує';
    const STATUS_IN_PROGRESS = 'У процесі';
    const STATUS_COMPLETED = 'Завершено';

    const PRIORITY_LOW = 'Низький';
    const PRIORITY_MEDIUM = 'Середній';
    const PRIORITY_HIGH = 'Високий';

    protected $fillable = [
        'user_id',
        'folder_id',
        'task_name',
        'task_description',
        'status',
        'priority',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    // Зв'язок з користувачем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Зв'язок з папкою
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    // Геттер для форматованого дедлайну
    public function getFormattedDeadlineAttribute()
    {
        return $this->deadline ? Carbon::parse($this->deadline)->format('Y-m-d') : null;
    }

    // Аксесор для статусу
    public function getStatusAttribute($value)
    {
        $statuses = [
            'Очікує' => self::STATUS_PENDING,
            'У процесі' => self::STATUS_IN_PROGRESS,
            'Завершено' => self::STATUS_COMPLETED,
        ];

        return $statuses[$value] ?? $value;
    }

    // Аксесор для пріоритету
    public function getPriorityAttribute($value)
    {
        $priorities = [
            'Низький' => self::PRIORITY_LOW,
            'Середній' => self::PRIORITY_MEDIUM,
            'Високий' => self::PRIORITY_HIGH,
        ];

        return $priorities[$value] ?? $value;
    }
}
