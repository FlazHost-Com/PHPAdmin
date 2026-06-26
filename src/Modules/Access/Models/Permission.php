<?php

declare(strict_types=1);

namespace PHPAdmin\Modules\Access\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Permission Eloquent model.
 *
 * Pivot table: roles_permissions (permission_id, role_id).
 * All belongsToMany arguments are explicit.
 */
class Permission extends Model
{
    protected $table      = 'permissions';
    public    $incrementing = false;
    protected $keyType    = 'string';
    public    $timestamps = true;

    /** @var list<string> */
    protected $fillable = [
        'id', 'name', 'guard_name', 'method',
        'status', 'desc', 'created_by', 'updated_by',
    ];

    // ─── Relations ───────────────────────────────────────────────────────────

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_permissions', 'permission_id', 'role_id');
    }
}
