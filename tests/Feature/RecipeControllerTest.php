<?php

namespace Tests\Feature;

use App\Tag;
use App\User;
use App\Recipe;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->actingAs($this->user);
    }

    /** @test */
    public function it_fetches_the_users_recipes()
    {
        $recipes = factory(Recipe::class, 15)->create();
        $this->user->recipes()->attach($recipes);

        $response = $this->get('/recipes');

        $response->assertStatus(200);

        $response->assertViewIs('recipes.index');

        $response->assertViewHas('recipes', $this->user->recipes()->paginate(config('recipes.per_page')));
    }

    /** @test */
    public function it_fetches_a_single_recipe()
    {
        $recipe = factory(Recipe::class)->create();
        $this->user->recipes()->attach($recipe);
        $tags = factory(Tag::class, 3)->create();
        $recipe->tags()->attach($tags);

        $recipe->load('tags');

        $response = $this->get('/recipes/'.$recipe->id);

        $response->assertStatus(200);

        $response->assertViewIs('recipes.show');

        $response->assertViewHas('recipe', $recipe);
    }

    /** @test */
    public function it_shows_the_add_recipe_form()
    {
        $response = $this->get('/recipes/create');

        $response->assertStatus(200);

        $response->assertViewIs('recipes.create');

        $response->assertViewHas('tags');
    }

    /** @test */
    public function it_shows_the_edit_recipe_form()
    {
        $recipe = factory(Recipe::class)->create();

        $response = $this->get("/recipes/".$recipe->id."/edit");

        $response->assertStatus(200);

        $response->assertViewIs('recipes.edit');

        $response->assertViewHas('tags');
    }

    /** @test */
    public function it_creates_a_new_recipe()
    {
        $recipe = factory(Recipe::class)->make();
        $tags = factory(Tag::class, 3)->create();

        $data = array_merge($recipe->only(['name','recipe']), ['tags'=>$tags->pluck('id')->toArray()]);

        $response = $this->post('/recipes', $data);

        $recipeCheck = Recipe::where('name',$recipe->name)->where('recipe',$recipe->recipe)->firstOrFail();

        $response->assertRedirect('/recipes/'.$recipeCheck->id);

        $this->assertDatabaseHas('recipes', $recipe->only(['name','recipe']));

        foreach ($tags as $tag) {
            $this->assertDatabaseHas('recipes_tags', [
                'recipe_id' => $recipeCheck->id,
                'tag_id' => $tag->id
            ]);
        }
    }

    /** @test */
    public function it_updates_an_existing_recipe()
    {
        $recipe = factory(Recipe::class)->create();

        $response = $this->put('/recipes/'.$recipe->id, [
            'name' => 'updated name',
            'recipe' => json_encode('updated recipe'),
        ]);

        $response->assertRedirect('/recipes/'.$recipe->id);

        $this->assertDatabaseHas('recipes', [
            'name' => 'updated name',
            'recipe' => json_encode('updated recipe'),
            'id' => $recipe->id,
        ]);
    }

    /** @test */
    public function it_deletes_a_recipe()
    {
        $recipe = factory(Recipe::class)->create();

        $response = $this->delete('/recipes/'.$recipe->id);

        $response->assertRedirect('/recipes');

        $this->assertSoftDeleted('recipes', $recipe->toArray());
    }
}
