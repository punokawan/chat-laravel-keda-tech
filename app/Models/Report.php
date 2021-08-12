<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_id', 'message', 'read_at'
    ];
    protected $casts = [
        'read_at' => 'datetime',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
    public function userFrom()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
}
