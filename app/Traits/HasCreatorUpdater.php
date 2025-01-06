<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Adds created by and updated by relationship on the corresponding models.
 * Model must contain created_by & updated_by fields.
 * Also updates created_by and updated_by when creating
 * and updating event of the model is fired respectively.
 */
trait HasCreatorUpdater
{
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id')
            ->select([
                'id',
                DB::raw("CONCAT(COALESCE(user_first_name), ' ', COALESCE(user_last_name)) as user_full_name"),
                'user_first_name',
                'user_last_name'
            ]);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id')
            ->select([
                'id',
                DB::raw("CONCAT(COALESCE(user_first_name), ' ', COALESCE(user_last_name)) as user_full_name"),
                'user_first_name',
                'user_last_name'
            ]);
    }

    public static function bootHasCreatorUpdater()
    {
        static::creating(function (Model $model) {
            if (Auth::check()) {
                $model->created_by = Auth::id() ?? null;
            }
        });

        static::updating(function (Model $model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id() ?? null;
            }
        });
    }
}
