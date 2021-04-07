<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class MenusController extends Controller
{
    public function index()
    {
        return Inertia::render('Menus/Index', [
            'filters' => Request::all('search', 'trashed'),
            'menus' => Auth::user()->account->menus()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Menus/Create');
    }

    public function store()
    {
        Auth::user()->account->menus()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'um' => ['nullable', 'max:5'],
                'cant' => ['nullable', 'numeric'],
                'cant_r' => ['nullable', 'numeric'],
                'proteine' => ['nullable', 'numeric'],
                'lipide' => ['nullable', 'numeric'],
                'glucide' => ['nullable', 'numeric'],

            ])
        );

        return Redirect::route('menus')->with('success', 'Menu created.');
    }

    public function edit(Menu $menu)
    {
        $recipes = [];

        foreach ($menu->recipes as $recipe) {

            $recipe->orig = $recipe->cant;

            $recipe->cant = $recipe->pivot->cant;

            $recipes[] = $recipe;
        }

        return Inertia::render('Menus/Edit', [
            'menu' => [
                'id' => $menu->id,
                'name' => $menu->name,
                'calorii' => $menu->calorii,
                'um' => $menu->um,
                'cant' => $menu->cant,
                'cant_r' => $menu->cant_r,
                'proteine' => $menu->proteine,
                'lipide' => $menu->lipide,
                'glucide' => $menu->glucide,
                'deleted_at' => $menu->deleted_at,
                'recipes' => $recipes
            ],
        ]);
    }

    public function update(Menu $menu)
    {
        $menu->update(
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

        $recipes = array_values($request['recipes']);

        $recipes_array = [];

        foreach ($recipes as $recipe){

            $recipes_array[$recipe[0]] = ['cant' => $recipe[1]];
        }

        //$recipe->ingredients()->sync(array_values($request['ingredients']));
        $menu->recipes()->sync($recipes_array);

        return Redirect::back()->with('success', 'Menu updated.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return Redirect::back()->with('success', 'Menu deleted.');
    }

    public function restore(Menu $menu)
    {
        $menu->restore();

        return Redirect::back()->with('success', 'Menu restored.');
    }
}
