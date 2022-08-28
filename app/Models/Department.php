<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = ['name','number_of_member','description'];
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class,'user_department');
    }

    public function departmentUsers()
    {
        return $this->belongsToMany(User::class,'user_department', "department_id", "id");
    }

    public function userDepartments()
    {
        return $this->hasMany(UserDepartment::class);
    }

}
