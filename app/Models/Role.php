<?php

namespace App\Models;

use App\Traits\HasCreatorUpdater;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory, HasCreatorUpdater;
    protected $table = 'roles';
    protected $fillable = ['name', 'guard_name', 'role_weight', 'is_active', 'created_by', 'updated_by'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
