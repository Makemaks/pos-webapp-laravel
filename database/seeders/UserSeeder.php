<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new User();
        $user->user_account_id = 1;
        $user->user_person_id = 1;
        $user->user_type = 0;
        $user->user_is_disabled = 0;
        $user->user_is_notifiable = 1;
        $user->email = 'giofadhil.ahmad@gmail.com';
        $user->email_verified_at = now();
        $user->password = bcrypt('test1234'); // password
        $user->remember_token = Str::random(10);
        $user->save();

        $user = new User();
        $user->user_account_id = 1;
        $user->user_person_id = 2;
        $user->user_type = 0;
        $user->user_is_disabled = 0;
        $user->user_is_notifiable = 1;
        $user->email = 'test@example.com';
        $user->email_verified_at = now();
        $user->password = bcrypt('test1234'); // password
        $user->remember_token = Str::random(10);
        $user->save();

        User::factory(10)->create();



        /*  $userList = [
            [
                'user_account_id' => 1,
                'user_person_id' => 1,
                'user_type' => 0,
                'user_is_disabled' => 0,
                'user_is_notifiable' => 1,
                'user_is_verified' => 0,
                'email' => 'superadmin@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('test1234'), // password
                'remember_token' => Str::random(10),
            ],
            [
                'user_account_id' => 1,
                'user_person_id' => 2,
                'user_type' => 3,
                'user_is_disabled' => 0,
                'user_is_notifiable' => 1,
                'user_is_verified' => 0,
                'email' => 'guest@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('test1234'), // password
                'remember_token' => Str::random(10),
            ]
        ];
        
           

            foreach ($userList as $key => $user) {
                User::insert($user);
            } */
    }
}
