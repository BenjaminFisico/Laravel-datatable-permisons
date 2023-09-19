<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createBaseRoles();
        $this->createBaseUsers();
        User::factory(5)->create();
    }

    private function createBaseRoles(){
        $adminRole = Role::create(['name' => 'admin']);
        $clientRole = Role::create(['name' => 'client']);
        $sellerRole = Role::create(['name' => 'seller']);
        $roleRole = Role::create(['name' => 'role']);

        $permissions = [
            'create',
            'read',
            'update',
            'delete'
        ];

        foreach(Role::all() as $rol){
            foreach($permissions as $permission){
                if($rol->name == 'admin'){ $rol->name = 'user'; }
                Permission::create(['name' => "{$rol->name} $permission"]);
            }
        }
    
        $adminRole->syncPermissions(Permission::all());
        $clientRole->syncPermissions(Permission::where('name', 'like', "%client%")->get());
        $sellerRole->syncPermissions(Permission::where('name', 'like', "%seller%")->get());      
        $roleRole->syncPermissions(Permission::where('name', 'like', "%role%")->get());
    }

    private function createBaseUsers(){
        $adminUser = User::factory()->create([
            'name' => 'Benjamin Fisico',
            'email' => 'benjaminfisico@gmail.com',
        ]);
        $adminUser->assignRole('admin');

        $clientUser = User::factory()->create([
            'name' => 'cliente',
            'email' => 'cliente@gmail.com',
        ]);
        $clientUser->assignRole('client');
        
        $sellerUser = User::factory()->create([
            'name' => 'vendedor',
            'email' => 'vendedor@gmail.com',
        ]);
        $sellerUser->assignRole('seller');
    }
}
