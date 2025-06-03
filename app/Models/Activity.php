<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'details',
        'status',
        'model_type',
        'model_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo('model');
    }

    // Helper methods pour créer des activités
    public static function log($userId, $action, $details, $status = 'success', $subject = null)
    {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'details' => $details,
            'status' => $status,
            'model_type' => $subject ? get_class($subject) : null,
            'model_id' => $subject ? $subject->id : null,
        ]);
    }
}