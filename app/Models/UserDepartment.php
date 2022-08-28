<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    use HasFactory;

    protected $table = 'user_department';

    public function users()
    {
        return $this->belongsTo(User::class,);
    }

    public function departments()
    {
        return $this->belongsTo(Department::class,);
    }
}
