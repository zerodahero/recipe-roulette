<?php

namespace App\Http\Controllers;

use App\Meal;
use App\Roulette\Roulette;
use Illuminate\Http\Request;
use App\Http\Requests\RouletteStoreRequest;

class RouletteController extends Controller
{
    /**
     * Shows the form to play Roulette
     *
     * @return Response
     */
    public function index()
    {
        return response()->view('roulette.index');
    }

    /**
     * Plays recipe roulette!
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function play(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer'
        ]);

        $roulette = new Roulette;

        $recipes = $roulette->spinForSequence($request->quantity);

        return response()->view('roulette.play', compact('recipes'));
    }

    /**
     * Stores the roulette play as a meal plan
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store(RouletteStoreRequest $request)
    {
        // dd($request->meals);
        foreach ($request->meals as $meal)
        {
            Meal::firstOrCreate([
                'day' => $meal['date'],
                'recipe_id' => $meal['recipe_id']
            ]);
        }

        return redirect()->route('meals.index');
    }
}
