<?php

use Illuminate\Database\Seeder;

class UserTableSeeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jose Alas',
            'email' => 'zerodrieswolf@gmail.com',
            'password' => bcrypt('12345678'),
            'id_tipo_usuario' => 3,
        ]);
    }
}
