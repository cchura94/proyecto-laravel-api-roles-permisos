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

        $p = new Permiso();
        $p->nombre = "index_perfil";
        $p->action = "index";
        $p->subject = "perfil";
        $p->save();

        // permisos user index_user, store_user, show_user, update_user, delete_user

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

        $p2 = new Permiso();
        $p2->nombre = "show_user";
        $p2->action = "show";
        $p2->subject = "user";
        $p2->save();

        $p3 = new Permiso();
        $p3->nombre = "update_user";
        $p3->action = "update";
        $p3->subject = "user";
        $p3->save();

        $p3 = new Permiso();
        $p3->nombre = "delete_user";
        $p3->action = "delete";
        $p3->subject = "user";
        $p3->save();

        // permisos Role

        $p4 = new Permiso();
        $p4->nombre = "index_role";
        $p4->action = "index";
        $p4->subject = "role";
        $p4->save();

        $p4 = new Permiso();
        $p4->nombre = "store_role";
        $p4->action = "store";
        $p4->subject = "role";
        $p4->save();

        $p4 = new Permiso();
        $p4->nombre = "show_role";
        $p4->action = "show";
        $p4->subject = "role";
        $p4->save();

        $p4 = new Permiso();
        $p4->nombre = "update_role";
        $p4->action = "update";
        $p4->subject = "role";
        $p4->save();

        $p4 = new Permiso();
        $p4->nombre = "delete_role";
        $p4->action = "delete";
        $p4->subject = "role";
        $p4->save();

        // permiso

        $p4 = new Permiso();
        $p4->nombre = "index_permiso";
        $p4->action = "index";
        $p4->subject = "permiso";
        $p4->save();

        $p4 = new Permiso();
        $p4->nombre = "store_permiso";
        $p4->action = "store";
        $p4->subject = "permiso";
        $p4->save();

        $p4 = new Permiso();
        $p4->nombre = "show_permiso";
        $p4->action = "show";
        $p4->subject = "permiso";
        $p4->save();

        $p4 = new Permiso();
        $p4->nombre = "update_permiso";
        $p4->action = "update";
        $p4->subject = "permiso";
        $p4->save();

        $p4 = new Permiso();
        $p4->nombre = "delete_permiso";
        $p4->action = "delete";
        $p4->subject = "permiso";
        $p4->save();

        // ROLES

        $r1 = new Role();
        $r1->nombre = "super-admin";
        $r1->save();

        $r2 = new Role();
        $r2->nombre = "anonimo";
        $r2->save();
/*
        $r2 = new Role();
        $r2->nombre = "cajero";
        $r2->save();

        $r3 = new Role();
        $r3->nombre = "gerente";
        $r3->save();

        $r4 = new Role();
        $r4->nombre = "ventas";
        $r4->save();
*/

        // asignamos permisos a los roles
        $r1->permisos()->attach([$p0->id]); // admin
        $r2->permisos()->attach([$p->id]);
        // $r2->permisos()->attach([$p->id, $p1->id]); // cajero
        // $r3->permisos()->attach([$p->id, $p1->id, $p2->id, $p3->id, $p4->id]); // gerente
        // $r4->permisos()->attach([$p->id]);


        $u1 = new User();
        $u1->name = "admin";
        $u1->email = "admin@mail.com";
        $u1->password = bcrypt("admin54321");
        $u1->save();

       /*
        $u2 = new User();
        $u2->name = "cristian";
        $u2->email = "cristian@mail.com";
        $u2->password = bcrypt("cristian54321");
        $u2->save();

        $u3 = new User();
        $u3->name = "maria";
        $u3->email = "maria@mail.com";
        $u3->password = bcrypt("maria54321");
        $u3->save();
        */

        $u1->assignRole($r1);

       //  $u2->assignRole($r2);
       //  $u2->assignRole($r3);

       //  $u3->assignRole($r4);
        
    }
}
