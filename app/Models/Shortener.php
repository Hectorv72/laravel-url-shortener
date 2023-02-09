<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortener extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'shortened_url',
        'linked_url',
        'interactions'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
