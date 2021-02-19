<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class RecipesController extends Controller
{
    public function index()
    {
        return Inertia::render('Recipes/Index', [
            'filters' => Request::all('search', 'trashed'),
            'recipes' => Auth::user()->account->recipes()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Recipes/Create');
    }

    public function store()
    {
        Auth::user()->account->recipes()->create(
            Request::validate([
                'name' => ['required', 'max:100'],

            ])
        );

        return Redirect::route('recipes')->with('success', 'Recipe created.');
    }

    public function edit(Recipe $recipe)
    {
        return Inertia::render('Recipes/Edit', [
            'recipe' => [
                'id' => $recipe->id,
                'name' => $recipe->name,
                'calorii' => $recipe->calorii,
                'um' => $recipe->um,
                'cant' => $recipe->cant,
                'cant_r' => $recipe->cant_r,
                'proteine' => $recipe->proteine,
                'lipide' => $recipe->lipide,
                'glucide' => $recipe->glucide,
                'deleted_at' => $recipe->deleted_at,
                'ingredients' => $recipe->ingredients()->orderByName()->get(),
            ],
        ]);
    }

    public function update(Recipe $recipe)
    {
        $recipe->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'um' => ['nullable', 'max:5'],
                'cant' => ['nullable', 'numeric'],
                'cant_r' => ['nullable', 'numeric'],
                'proteine' => ['nullable', 'numeric'],
                'lipide' => ['nullable', 'numeric'],
                'glucide' => ['nullable', 'numeric'],
                'calorii' => ['nullable', 'numeric'],
            ])
        );

        $request = Request::all();
        $recipe->ingredients()->sync(array_values($request['ingredients']));


        return Redirect::back()->with('success', 'Recipe updated.');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return Redirect::back()->with('success', 'Recipe deleted.');
    }

    public function restore(Recipe $recipe)
    {
        $recipe->restore();

        return Redirect::back()->with('success', 'Recipe restored.');
    }
}
