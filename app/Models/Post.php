<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'active',
        'slug'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
