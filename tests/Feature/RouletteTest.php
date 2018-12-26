<?php

namespace Tests\Feature;

use App\Tag;
use App\Meal;
use App\User;
use App\Recipe;
use Tests\TestCase;
use App\Roulette\Roulette;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RouletteTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations, WithFaker;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $user = $this->user = factory(User::class)->create();
        $tags = factory(Tag::class, 20)->create();
        $recipes = factory(Recipe::class, 50)->create()->each(function ($recipe) use ($tags) {
            $recipe->tags()->attach($this->faker->randomElements($tags->pluck('id'), $this->faker->numberBetween(1,1)));
        });

        $user->recipes()->attach($recipes);

        $this->actingAs($this->user);
    }

    /** @test */
    public function it_fetches_random_recipes()
    {
        $roulette = new Roulette;

        $meals = $roulette->spin(3);

        foreach ($meals as $meal)
        {
            $this->assertInstanceOf(Recipe::class, $meal);
            $this->assertNotFalse(isset($meal->tags));
        }
    }

    /** @test */
    public function it_fetches_recipes_without_adjacent_tags()
    {
        $roulette = new Roulette;

        // NOTE: there is a possibility this may fail the assertions, but the probability is low
        // TODO: setup the data so it's not fail-able
        $meals = $roulette->spinForSequence(7);

        for ($i=0; $i<count($meals); $i++) {
            if (isset($meals[$i-1])) {
                $this->assertNoMatchingTags($meals[$i], $meals[$i-1]);
            }
            if (isset($meals[$i+1])) {
                $this->assertNoMatchingTags($meals[$i], $meals[$i+1]);
            }
        }
    }

    /** @test */
    public function it_fails_when_it_cannot_fetch_without_adjacent_tags()
    {
        $tags = Tag::all();
        $recipes = auth()->user()->recipes->each(function ($recipe) use ($tags) {
            $recipe->tags()->sync($tags->pluck('id'));
        });

        $roulette = new Roulette;

        $this->expectExceptionMessage('There are no possibilities for non-adjacent tags here!');
        $roulette->spinForSequence(7, true);
    }

    /**
     * Helper method to assert tags to not match
     *
     * @param Recipe $recipeA
     * @param Recipe $recipeB
     *
     * @return void
     */
    private function assertNoMatchingTags($recipeA, $recipeB)
    {
        // dump($recipeA->tags->pluck('id'));
        // dump($recipeB->tags->pluck('id'));
        return $this->assertEmpty($recipeA->tags->intersect($recipeB->tags), 'There are tags that match');
    }
}
