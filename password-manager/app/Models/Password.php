<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    use HasFactory;

    protected $fillable = [
        'encrypted_password',
        'username',
        'url',
        'note',
        'category',
        'refresh_weeks',
        'iv',
    ];
}
