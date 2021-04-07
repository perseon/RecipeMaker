<?php

namespace App\Imports;

use App\Models\Ingredient;
use Maatwebsite\Excel\Concerns\ToModel;

class IngredientsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //dd($row);
        return new Ingredient([
            'id'        => $row[0],
            'account_id'=> $row[1],
            'name'      => $row[2],
            'um'        => $row[3],
            'cant'      => $row[4],
            'cant_r'    => $row[5]??0,
            'proteine'  => $row[6]?$row[6]:0,
            'lipide'    => $row[7]?$row[7]:0,
            'glucide'   => $row[8]?$row[8]:0,
            'calorii'   => $row[9]?round($row[6]*4.1+$row[7]*9.1+$row[8]*4.1,2):0,
            'created_at'=> $row[10],
            'updated_at'=> $row[11],
        ]);
    }
}
