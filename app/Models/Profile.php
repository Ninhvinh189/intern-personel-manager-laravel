<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = ['phone','address','date_of_birth','avatar','description'];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
