<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    use HasFactory;

    const CLASS_A = 'Class A';
    const CLASS_B = 'Class B';
    const CLASS_C = 'Class C';


    /**
     * Get the comments for the blog post.
     */
    public function classDays(): HasMany
    {
        return $this->hasMany(ClassDay::class, 'class_id');
    }

}
