<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class,'user_department');
    }
}
