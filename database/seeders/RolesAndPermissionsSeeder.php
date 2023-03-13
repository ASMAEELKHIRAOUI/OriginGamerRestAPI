<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $editOwnProfile = 'edit own profile';
        $editAllProfiles = 'edit all profiles';
        $deleteOwnProfile = 'delete own profile';
        $deleteAllProfiles = 'delete all profiles';
        $viewOwnProfile = 'view own profile';
        $viewAllprofiles = 'view all profiles';

        $addProduct = 'add product';
        $editAllProducts = 'edit All products';
        $editOwnProduct = 'edit own product';
        $deleteAllProducts = 'delete All products';
        $deleteOwnProduct = 'delete own product';

        $addCategory = 'add category';
        $editCategory = 'edit category';
        $deleteCategory = 'delete category';
        $viewCategory = 'view category';

        Permission::create(['name' => $editOwnProfile]);
        Permission::create(['name' => $editAllProfiles]);
        Permission::create(['name' => $deleteOwnProfile]);
        Permission::create(['name' => $deleteAllProfiles]);
        Permission::create(['name' => $viewOwnProfile]);
        Permission::create(['name' => $viewAllprofiles]);

        Permission::create(['name' => $addProduct]);
        Permission::create(['name' => $editAllProducts]);
        Permission::create(['name' => $editOwnProduct]);
        Permission::create(['name' => $deleteAllProducts]);
        Permission::create(['name' => $deleteOwnProduct]);

        Permission::create(['name' => $addCategory]);
        Permission::create(['name' => $editCategory]);
        Permission::create(['name' => $deleteCategory]);
        Permission::create(['name' => $viewCategory]);

        // Define roles available
        $admin = 'admin';
        $seller = 'seller';
        $user = 'user';

        Role::create(['name' => $admin])->givePermissionTo(Permission::all());

        Role::create(['name' => $seller])->givePermissionTo([
            $addProduct,
            $editOwnProduct,
            $deleteOwnProduct,
            $editOwnProfile,
            $deleteOwnProfile,
            $viewOwnProfile,
        ]);

        Role::create(['name' => $user])->givePermissionTo([
            $editOwnProfile,
            $deleteOwnProfile,
            $viewOwnProfile,
        ]);
    }
}
