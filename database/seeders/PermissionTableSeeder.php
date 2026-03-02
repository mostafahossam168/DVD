<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $models = array_keys(config()->get('permissionsname.models'));
        $maps = config()->get('permissionsname.map');
        $permissions = [];
        foreach ($models as $model) {
            foreach (config()->get('permissionsname.models.' . $model) as $map) {
                $permissions[] = $map . '_' . $model;
            }
        }

        Permission::truncate();
        Role::truncate();
        $admin_role = Role::create(['name' => 'admin']);
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
            $admin_role->givePermissionTo($permission);
        }

        // صلاحيات المدرس (بدون إدارة النظام)
        $teacher_permissions = [
            'read_statistics_home',
            'read_subjects',
            'create_lectuers', 'read_lectuers', 'update_lectuers', 'delete_lectuers',
            'create_materials', 'read_materials', 'update_materials', 'delete_materials',
            'create_quizes', 'read_quizes', 'update_quizes', 'delete_quizes',
            'create_questions', 'read_questions', 'update_questions', 'delete_questions',
            'read_quiz_results',
            'read_contacts',
            'read_subscriptions',
        ];
        $teacher_role = Role::create(['name' => 'teacher']);
        foreach ($teacher_permissions as $perm) {
            $teacher_role->givePermissionTo($perm);
        }

        $admin = User::find(1);
        if ($admin) {
            $admin->syncRoles($admin_role);
        }

        // تعيين دور teacher لجميع المستخدمين من نوع teacher الذين ليس لديهم دور admin
        $teachers = User::where('type', 'teacher')->get();
        foreach ($teachers as $t) {
            if (!$t->hasRole('admin')) {
                $t->syncRoles($teacher_role);
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
