<?php

use App\User;
use App\Customer;
use App\Pageview;

use Faker\Generator;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {        
        $users = factory(User::class, 4)->create([
            'password' => bcrypt('secret'),
        ]);

        foreach($users as $user)
        {
            $customers = factory(Customer::class, mt_rand(100, 200))->create([
                'user_id' => $user->id,
            ]);

            foreach($customers as $customer)
            {
                factory(Pageview::class, mt_rand(100, 200))->create([
                    'customer_id' => $customer->id,
                    'user_id' => $customer->user_id,
                ]);
            }
        }
    }
}
