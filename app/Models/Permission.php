<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Permission extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'group'];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($permission) {
            $permission->slug = Str::slug($permission->name);
        });
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
} 