<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insertOrIgnore([
              'id'       => 1,
              'name'     => 'admin',
              'email'    => 'admin@test.com',
              'password' => bcrypt('admin')
          ]);
      $user = User::findOrFail(1);
      echo $user->createToken('admin',['transactions:add'])->plainTextToken;

    }
}
