<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permission = Permission::create([
            'guard_name' => 'api', 
            'name' => 'view_closed_tickets'
        ]);

        $role = Role::where('name', 'Super-Admin')->where('guard_name', 'api')->first();

        // 4. Si el rol existe, le asignamos el permiso
        if ($role) {
            $role->givePermissionTo($permission);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'view_closed_tickets')
            ->where('guard_name', 'api')
            ->delete();
    }
};
