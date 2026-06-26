<?php

declare(strict_types=1);

namespace PHPAdmin\Modules\Access\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * User Eloquent model.
 *
 * Pivot tables: users_roles (user_id, role_id).
 * All belongsToMany arguments are explicit to avoid magic resolution.
 */
class User extends Model
{
    protected $table      = 'users';
    public    $incrementing = false;
    protected $keyType    = 'string';
    public    $timestamps = true;

    /** @var list<string> */
    protected $fillable = [
        'id', 'code', 'name', 'phone', 'email',
        'email_verified_at', 'password', 'password_otp',
        'password_otp_expires', 'status', 'picture',
        'blocked', 'blocked_reason', 'timezone',
        'created_by', 'updated_by',
    ];

    /** @var list<string> */
    protected $hidden = ['password', 'password_otp'];

    // ─── Relations ───────────────────────────────────────────────────────────

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
    }

    // ─── Business logic ──────────────────────────────────────────────────────

    /**
     * Check if this user has access to a named route + HTTP method.
     * Administrator role bypasses all checks.
     */
    public function hasAccess(string $routeName, string $method): bool
    {
        $this->loadMissing('roles.permissions');

        foreach ($this->roles as $role) {
            // Administrator bypasses everything
            if (strtolower((string)$role->name) === 'administrator') {
                return true;
            }
            foreach ($role->permissions as $permission) {
                if (
                    $permission->name === $routeName
                    && strtoupper((string)$permission->method) === strtoupper($method)
                    && strtolower((string)$permission->status) === 'active'
                ) {
                    return true;
                }
            }
        }

        return false;
    }
}
