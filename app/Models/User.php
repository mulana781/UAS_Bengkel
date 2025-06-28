<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Check user roles
    public function isAdmin()
    {
        return $this->role && $this->role->name === Role::ADMIN;
    }

    public function isManager()
    {
        return $this->role && $this->role->name === Role::MANAGER;
    }

    public function isStaff()
    {
        return $this->role && $this->role->name === Role::STAFF;
    }

    public function isCustomer()
    {
        return $this->role && $this->role->name === Role::CUSTOMER;
    }

    // Check if user has any of the given roles
    public function hasRole($roles)
    {
        if (is_array($roles)) {
            return in_array($this->role->name, $roles);
        }
        return $this->role->name === $roles;
    }

    // Check if user has permission (admin can do everything)
    public function hasPermission($permission)
    {
        if ($this->isAdmin()) {
            return true;
        }

        // Add more permission logic here based on roles
        switch ($permission) {
            case 'manage_users':
                return $this->isManager();
            case 'manage_services':
                return $this->isManager() || $this->isStaff();
            case 'view_reports':
                return $this->isManager() || $this->isStaff();
            case 'manage_customers':
                return $this->isManager() || $this->isStaff();
            default:
                return false;
        }
    }
}
