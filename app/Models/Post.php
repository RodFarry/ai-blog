<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'excerpt', 'content', 'image', 'category', 'tags'];

    public function getTagsAttribute($value) {
        $tags = json_decode($value, true);

        if (is_array($tags) && isset($tags['tags'])) {
            return $tags['tags'];
        }

        return is_array($tags) ? $tags : [];
    }
}
