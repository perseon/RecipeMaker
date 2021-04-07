<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use App\Imports\IngredientsImport;
use App\Exports\IngredientsExport;
use Maatwebsite\Excel\Facades\Excel;

class IngredientsController extends Controller
{
    public function index()
    {
        return Inertia::render('Ingredients/Index', [
            'filters' => Request::all('search', 'trashed'),
            'ingredients' => Auth::user()->account->ingredients()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Ingredients/Create');
    }

    public function store()
    {
        Auth::user()->account->ingredients()->create(
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

        return Redirect::route('ingredients')->with('success', 'Ingredient created.');
    }

    public function edit(Ingredient $ingredient)
    {
        return Inertia::render('Ingredients/Edit', [
            'ingredient' => [
                'id' => $ingredient->id,
                'name' => $ingredient->name,
                'um' => $ingredient->um,
                'cant' => $ingredient->cant,
                'cant_r' => $ingredient->cant_r,
                'proteine' => $ingredient->proteine,
                'lipide' => $ingredient->lipide,
                'glucide' => $ingredient->glucide,
                'deleted_at' => $ingredient->deleted_at,
            ],
        ]);
    }

    public function update(Ingredient $ingredient)
    {
        $ingredient->update(
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

        return Redirect::back()->with('success', 'Ingredient updated.');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return Redirect::back()->with('success', 'Ingredient deleted.');
    }

    public function restore(Ingredient $ingredient)
    {
        $ingredient->restore();

        return Redirect::back()->with('success', 'Ingredient restored.');
    }

    public function export()
    {
        return Excel::download(new IngredientsExport(), 'ingrediente.xlsx');
    }

    public function import()
    {

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('ingredients')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Excel::import(new IngredientsImport(),request()->file('file'));

        return Redirect::route('ingredients')->with('success', 'Import realizat.');

    }
}
