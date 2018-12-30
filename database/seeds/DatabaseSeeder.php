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
        // $this->call(UsersTableSeeder::class);
        $admin = factory(User::class)->create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('secret'),
        ]);

        $users = factory(User::class, 4)->create([
            'password' => bcrypt('secret'),
        ]);

        $users = \Illuminate\Support\Collection::make($users)->push($admin);

        foreach($users as $user)
        {
            // Each user gets between 10 and 100 customers
            $customers = factory(Customer::class, mt_rand(10, 25))->create([
                'user_id' => $user->id,
            ]);

            foreach($customers as $customer)
            {
                // Each customer gets between 2 and 150 pageviews
                factory(Pageview::class, mt_rand(2, 20))->create([
                    'customer_id' => $customer->id,
                    'user_id' => $customer->user_id,
                ]);
            }
        }

        $this->call(ArticleSeeder::class);
    }
}
