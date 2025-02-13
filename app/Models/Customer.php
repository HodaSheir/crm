<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'employee_id'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'customer_employee');
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
