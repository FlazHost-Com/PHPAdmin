<?php

declare(strict_types=1);

namespace PHPAdmin\Modules\Access\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Role Eloquent model.
 *
 * Pivot tables:
 *   roles_permissions (role_id, permission_id)
 *   users_roles       (role_id, user_id)
 *
 * All belongsToMany arguments are explicit.
 */
class Role extends Model
{
    protected $table      = 'roles';
    public    $incrementing = false;
    protected $keyType    = 'string';
    public    $timestamps = true;

    /** @var list<string> */
    protected $fillable = ['id', 'name', 'status', 'desc', 'created_by', 'updated_by'];

    // ─── Relations ───────────────────────────────────────────────────────────

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions', 'role_id', 'permission_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_roles', 'role_id', 'user_id');
    }
}
