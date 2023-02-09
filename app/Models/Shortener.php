<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortener extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shortened_url',
        'linked_url',
        'interactions'
    ];
}
