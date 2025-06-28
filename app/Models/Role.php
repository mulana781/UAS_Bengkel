<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Role constants
    const ADMIN = 'admin';
    const MANAGER = 'manager';
    const STAFF = 'staff';
    const CUSTOMER = 'customer';

    // Check if user has specific role
    public function isAdmin()
    {
        return $this->name === self::ADMIN;
    }

    public function isManager()
    {
        return $this->name === self::MANAGER;
    }

    public function isStaff()
    {
        return $this->name === self::STAFF;
    }

    public function isCustomer()
    {
        return $this->name === self::CUSTOMER;
    }
}
