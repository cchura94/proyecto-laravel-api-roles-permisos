<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permiso;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $p0 = new Permiso();
        $p0->nombre = "manage_all";
        $p0->action = "manage";
        $p0->subject = "all";
        $p0->save();

        $p1 = new Permiso();
        $p1->nombre = "index_user";
        $p1->action = "index";
        $p1->subject = "user";
        $p1->save();

        $p2 = new Permiso();
        $p2->nombre = "store_user";
        $p2->action = "store";
        $p2->subject = "user";
        $p2->save();

        $p3 = new Permiso();
        $p3->nombre = "update_user";
        $p3->action = "update";
        $p3->subject = "user";
        $p3->save();

        $r1 = new Role();
        $r1->nombre = "super-admin";
        $r1->save();

        $r2 = new Role();
        $r2->nombre = "cajero";
        $r2->save();

        $r3 = new Role();
        $r3->nombre = "gerente";
        $r3->save();

        // asignamos permisos a los roles
        $r1->permisos()->attach([$p0->id]); // admin
        $r2->permisos()->attach([$p1->id]); // cajero
        $r3->permisos()->attach([$p1->id, $p2->id, $p3->id]); // gerente

        $u1 = new User();
        $u1->name = "admin";
        $u1->email = "admin@mail.com";
        $u1->password = bcrypt("admin54321");
        $u1->save();

        $u2 = new User();
        $u2->name = "cristian";
        $u2->email = "cristian@mail.com";
        $u2->password = bcrypt("cristian54321");
        $u2->save();

        $u1->assignRole($r1);

        $u2->assignRole($r2);
        $u2->assignRole($r3);
        
    }
}
