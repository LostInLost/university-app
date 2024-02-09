<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory, HasUlids;


    protected $guarded = ['id'];

    public function city()
    {
        return $this->hasMany(City::class, 'admin_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'admin_id', 'id');
    }
}
