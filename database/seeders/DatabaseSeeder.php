<?php

namespace Database\Seeders;

use App\Models\{AdminNotification, Coupon, Customer, Permission, Role, Setting, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = collect(['dashboard.view','products.manage','categories.manage','inventory.manage','orders.manage','customers.manage','promotions.manage','cms.manage','analytics.view','settings.manage','staff.manage','reports.view'])->mapWithKeys(fn ($name) => [$name => Permission::firstOrCreate(['name' => $name], ['label' => Str::headline($name)])]);

        $super = Role::firstOrCreate(['name' => 'super-admin'], ['label' => 'Super Admin']);
        $manager = Role::firstOrCreate(['name' => 'manager'], ['label' => 'Manager']);
        $staff = Role::firstOrCreate(['name' => 'staff'], ['label' => 'Staff']);
        $super->permissions()->sync($permissions->pluck('id'));
        $manager->permissions()->sync($permissions->except(['settings.manage','staff.manage'])->pluck('id'));
        $staff->permissions()->sync($permissions->only(['dashboard.view','orders.manage','customers.manage','inventory.manage'])->pluck('id'));

        $admin = User::updateOrCreate(['email' => 'admin@mail.com'], [
            'name' => 'Savile Row Admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::where('email', 'admin@savilerow.test')->delete();
        $admin->roles()->syncWithoutDetaching([$super->id]);

        foreach ([['Amelia','Hart'],['Theo','Sinclair'],['Maya','Chen'],['Noah','Brooks'],['Elena','Voss'],['Julian','Reed'],['Iris','Laurent'],['Miles','Grant']] as $index => [$first, $last]) {
            Customer::firstOrCreate(['email' => strtolower($first).'.'.strtolower($last).'@example.com'], [
                'first_name' => $first,
                'last_name' => $last,
                'phone' => '+44 20 7000 '.str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                'status' => 'active',
                'loyalty_points' => 120 * ($index + 1),
            ]);
        }

        Coupon::firstOrCreate(['code' => 'ROW10'], ['type' => 'percentage', 'value' => 10, 'is_active' => true, 'starts_at' => now(), 'ends_at' => now()->addMonth()]);
        Setting::updateOrCreate(['group' => 'store', 'key' => 'name'], ['value' => 'Savile Row']);
        AdminNotification::firstOrCreate(['title' => 'Low stock review required'], ['user_id' => $admin->id, 'type' => 'inventory', 'message' => 'Several variants are below threshold.', 'url' => '/admin/inventory']);
    }
}

