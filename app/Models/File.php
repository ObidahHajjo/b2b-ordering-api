<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'path',
        'uploaded_at',
    ];

    protected $guarded = ['id'];
}
