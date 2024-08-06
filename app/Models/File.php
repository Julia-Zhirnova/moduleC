<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    
    protected $table = 'files';
    
    protected $fillable = [
        'file_name',
        'file_id',
        'author_id'
    ];

    public $timestamps = false;
}
