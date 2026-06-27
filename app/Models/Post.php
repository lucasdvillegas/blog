<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @use HasFactory<\Database\Factories\PostFactory>
 */
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
