<?php

namespace App\Roulette;

use App\Recipe;
use Carbon\Carbon;
use Faker\Factory as Faker;

class Roulette
{
    /**
     * Used for ease of randomness
     *
     * @see Faker\Factory
     */
    protected $faker;

    /**
     * Recipes from which to spin
     *
     * @var Collection
     */
    protected $recipes;

    public function __construct($recipes = null)
    {
        $this->faker = Faker::create();
        $this->recipes = $recipes ?? auth()->user()->recipes->load('tags');
    }

    /**
     * Gets $quantity of randomly selected recipes
     *
     * @param Date $startDate
     * @param int $quantity
     *
     * @return Collection
     */
    public function spin($quantity = 7)
    {
        return $this->faker->randomElements($this->recipes, $quantity);
    }

    /**
     * Gets $quantity of randomly selected recipes with no adjacent tags
     *
     * @param int $quantity
     *
     * @return Collection
     */
    public function spinForSequence($quantity = 7, $dieOnError = false)
    {
        $recipes = $this->spin($quantity);

        for ($i = 0; $i < count($recipes); $i++) {
            $adjacentTags = [];
            if (isset($recipes[$i-1]) && $this->hasTagsInCommon($recipes[$i], $recipes[$i-1])) {
                $adjacentTags = array_merge($adjacentTags, $recipes[$i-1]->tags->pluck('id')->toArray());
            }
            if (isset($recipes[$i+1]) && $this->hasTagsInCommon($recipes[$i], $recipes[$i+1])) {
                $adjacentTags = array_merge($adjacentTags, $recipes[$i+1]->tags->pluck('id')->toArray());
            }

            if (empty($adjacentTags)) {
                continue;
            }

            $newRecipes = Recipe::whereHas('tags', function ($query) use ($adjacentTags) {
                $query->whereNotIn('tags.id',$adjacentTags);
            })->get();

            if ($newRecipes) {
                $recipes[$i] = $this->faker->randomElement($newRecipes);
            }

            if ($dieOnError) {
                throw new \Exception("There are no possibilities for non-adjacent tags here!");
            }
        }

        return $recipes;
    }

    /**
     * Determines if the two given recipes have any tags in common
     *
     * @param Recipe $recipeA
     * @param Recipe $recipeB
     *
     * @return bool
     */
    private function hasTagsInCommon($recipeA, $recipeB)
    {
        return $recipeA->tags->intersect($recipeB->tags)->isNotEmpty();
    }
}
