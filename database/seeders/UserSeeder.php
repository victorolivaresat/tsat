<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'PREVENCIÓN',
            'last_name' => 'ONLINE',
            'email' => 'prevencion@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'VICTOR',
            'last_name' => 'OLIVARES',
            'email' => 'victor.olivares@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'JUAN CARLOS',
            'last_name' => 'LÓPEZ NECIOSUP',
            'email' => 'juancarlos.lopez@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'ANDRÉS',
            'last_name' => 'ARISMENDIS GUERREROS',
            'email' => 'luis.arismendis@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'JENSON',
            'last_name' => 'PAICO VEGA',
            'email' => 'jenson.paico@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'KARLA',
            'last_name' => 'PANEZ VEGA',
            'email' => 'karla.panez@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'LUIS',
            'last_name' => 'VARGAS MADGE',
            'email' => 'luis.vargas@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'JUAN CARLOS',
            'last_name' => 'GUEVARA CARRASCO',
            'email' => 'juancarlos.guevara@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'JEAN PIERRE',
            'last_name' => 'SALAS ROJAS',
            'email' => 'jean.salas@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'MARCELO',
            'last_name' => 'CHÁVEZ GUEVARA',
            'email' => 'marcelo.chavez@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('users')->insert([
            'first_name' => 'EDWARD',
            'last_name' => 'ALCARRAZ CÓRDOVA',
            'email' => 'edward.alcarraz@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'HERNAN',
            'last_name' => 'LAZO MONTOYA',
            'email' => 'hernan.lazo@apuestatotal.com',
            'password' => Hash::make('42790373'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'CRIS JUSETH',
            'last_name' => 'QUISPE JUNCO',
            'email' => 'cris.quispe@apuestatotal.net',
            'password' => Hash::make('71073894'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('users')->insert([
            'first_name' => 'PABLO JHUNIOR',
            'last_name' => 'MELGAR ALVARADO',
            'email' => 'pablo.melgar@apuestatotal.net',
            'password' => Hash::make('76429256'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'JARICK OSCAR',
            'last_name' => 'CALLIRGOS ANGELES',
            'email' => 'jarick.callirgos@apuestatotal.net',
            'password' => Hash::make('70930681'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'EFFIO CORTEZ',
            'last_name' => 'VERENICE YOHANA',
            'email' => 'verenice.effio@apuestatotal.net',
            'password' => Hash::make('75476427'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('users')->insert([
            'first_name' => 'RICARDO RIVERT',
            'last_name' => 'TAFUR REAP',
            'email' => 'ricardo.tafur@apuestatotal.net',
            'password' => Hash::make('41354125'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'KEVIN',
            'last_name' => 'TAFUR VICTORIO',
            'email' => 'kevin.tafur@apuestatotal.net',
            'password' => Hash::make('48368165'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'TAHIRY SHASURY',
            'last_name' => 'REYES REYES',
            'email' => 'tv.reyes@apuestatotal.net',
            'password' => Hash::make('77804185'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'CLAUDIO VICTOR',
            'last_name' => 'RODRIGUEZ ZAPATA',
            'email' => 'tv.rodriguez@apuestatotal.net',
            'password' => Hash::make('72739432'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'FRANK SAUL',
            'last_name' => 'PACHECO GRANADOS',
            'email' => 'tv.pacheco@apuestatotal.net',
            'password' => Hash::make('71119175'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'JOISSI GABRIEL',
            'last_name' => 'VÁSQUEZ DA COSTA',
            'email' => 'tv.vasquez@apuestatotal.net',
            'password' => Hash::make('78888525'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'PATRICK JAVIER',
            'last_name' => 'ORTEGA KARLOS',
            'email' => 'tv.ortega@apuestatotal.net',
            'password' => Hash::make('70800537'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'KAHEL ALEXANDER',
            'last_name' => 'BOCANEGRA CAMPOS',
            'email' => 'tv.bocanegra@apuestatotal.net',
            'password' => Hash::make('76216010'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'JORDAN RODOLFO',
            'last_name' => 'FRANCISCO DOROTEO',
            'email' => 'tv.francisco@apuestatotal.net',
            'password' => Hash::make('75246621'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'MELANIE ROSE',
            'last_name' => 'DEL AGUILA MORALES',
            'email' => 'tv.delaguila@apuestatotal.net',
            'password' => Hash::make('77520597'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'MANUEL PEDRO',
            'last_name' => 'MATIENZO VEGA',
            'email' => 'tv.matienzo@apuestatotal.net',
            'password' => Hash::make('75128897'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'KRISTELL ALEXANDRA',
            'last_name' => 'MEDINA MORE',
            'email' => 'tv.medina@apuestatotal.net',
            'password' => Hash::make('75357941'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'TATIANA',
            'last_name' => 'LAO MOZOMBITE',
            'email' => 'tv.lao@apuestatotal.net',
            'password' => Hash::make('47297814'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'MARLON BRUCE',
            'last_name' => 'BAEZ CASTELLANO',
            'email' => 'tv.bruce@apuestatotal.net',
            'password' => Hash::make('73666305'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'JULIO CESAR',
            'last_name' => 'MARICAHUA IHUARAQUI',
            'email' => 'tv.maricahua@apuestatotal.net',
            'password' => Hash::make('70161587'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'WENDY GIOVANA',
            'last_name' => 'SILVA CENTENO',
            'email' => 'tv.silva@apuestatotal.net',
            'password' => Hash::make('45783589'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'MICHEL JONATHAN',
            'last_name' => 'RAMIREZ SALAZAR',
            'email' => 'tv.ramirez@apuestatotal.net',
            'password' => Hash::make('46482291'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'MARIA DE LOS ANGELES',
            'last_name' => 'MOLINA MACHICA',
            'email' => 'tv.molina@apuestatotal.net',
            'password' => Hash::make('71299026'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'ALEJANDRA',
            'last_name' => 'MAYTA MINAYA',
            'email' => 'tv.mayta@apuestatotal.net',
            'password' => Hash::make('47174252'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
