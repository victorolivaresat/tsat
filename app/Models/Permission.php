<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    // Relación muchos a muchos con módulos
    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class);
    }
}
