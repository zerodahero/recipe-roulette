<?php

use App\Tag;
use App\User;
use App\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $tags = Tag::all();

        $faker = Faker\Factory::create();

        $users->each(function ($user) use ($tags, $faker) {
            $recipes = factory(Recipe::class, 20)->create()->each(function ($recipe) use ($tags, $faker) {
                $recipe->tags()->attach($faker->randomElements($tags->pluck('id')->toArray(), $faker->numberBetween(1, 3)));
            });
            $user->recipes()->attach($recipes);
        });
    }
}
