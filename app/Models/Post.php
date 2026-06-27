<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TFactory of \Database\Factories\PostFactory
 * @use HasFactory<TFactory>
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