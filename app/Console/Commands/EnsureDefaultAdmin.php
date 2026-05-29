<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EnsureDefaultAdmin extends Command
{
    protected $signature = 'app:ensure-default-admin';

    protected $description = 'Create or update the default super admin account for hosted demo environments.';

    public function handle(): int
    {
        $email = env('ADMIN_EMAIL', 'admin@mail.com');
        $password = env('ADMIN_PASSWORD', 'password');

        $permissions = collect([
            'dashboard.view',
            'products.manage',
            'categories.manage',
            'inventory.manage',
            'orders.manage',
            'customers.manage',
            'promotions.manage',
            'cms.manage',
            'analytics.view',
            'settings.manage',
            'staff.manage',
            'reports.view',
        ])->map(fn ($name) => Permission::firstOrCreate([
            'name' => $name,
        ], [
            'label' => Str::headline($name),
        ]));

        $role = Role::firstOrCreate(['name' => 'super-admin'], ['label' => 'Super Admin']);
        $role->permissions()->sync($permissions->pluck('id'));

        $user = User::updateOrCreate([
            'email' => $email,
        ], [
            'name' => env('ADMIN_NAME', 'Savile Row Admin'),
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $user->roles()->syncWithoutDetaching([$role->id]);

        User::where('email', 'admin@savilerow.test')->delete();

        $this->info("Default admin ensured: {$email}");

        return self::SUCCESS;
    }
}
