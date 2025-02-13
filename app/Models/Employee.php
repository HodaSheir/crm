<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $guard = 'employee';
    protected $fillable = ['name', 'email', 'password'];

    public function customers()
    {
        return $this->belongsToMany(Customer::class , 'customer_employee');
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
