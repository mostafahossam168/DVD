<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $models = array_keys(config()->get('permissionsname.models'));
        $permissions = [];
        foreach ($models as $model) {
            foreach (config()->get('permissionsname.models.' . $model) as $map) {
                $permissions[] = $map . '_' . $model;
            }
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole->syncPermissions(Permission::all());

        $teacherPermissions = [
            'read_statistics_home',
            'read_subjects',
            'create_lectuers', 'read_lectuers', 'update_lectuers', 'delete_lectuers',
            'create_materials', 'read_materials', 'update_materials', 'delete_materials',
            'create_assessments', 'read_assessments', 'update_assessments', 'delete_assessments',
            'create_question_bank', 'read_question_bank', 'update_question_bank', 'delete_question_bank',
            'read_assessment_results',
            'read_contacts',
            'read_subscriptions',
        ];
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $teacherRole->syncPermissions($teacherPermissions);

        $admin = User::where('email', 'admin@admin.com')->first();
        if ($admin) {
            $admin->syncRoles([$adminRole]);
        }

        User::where('type', 'teacher')
            ->whereDoesntHave('roles', fn ($query) => $query->where('name', 'admin'))
            ->each(fn (User $teacher) => $teacher->syncRoles([$teacherRole]));

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
