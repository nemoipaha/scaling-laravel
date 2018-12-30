<?php

use App\Article;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $users = User::query()->take(3)->get();

        Article::create([
            'body' => $faker->text,
            'title' => $faker->sentence,
            'author_id' => $users->get(0)->id
        ]);

        Article::create([
            'body' => $faker->text,
            'title' => $faker->sentence,
            'author_id' => $users->get(1)->id
        ]);

        Article::create([
            'body' => $faker->text,
            'title' => $faker->sentence,
            'author_id' => $users->get(2)->id
        ]);
    }
}
