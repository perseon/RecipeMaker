<?php

namespace App\Exports;

use App\Models\Ingredient;
use Maatwebsite\Excel\Concerns\FromCollection;

class IngredientsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ingredient::all();
    }
}
