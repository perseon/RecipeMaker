<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use SoftDeletes;

    protected $fillable = array('name','um','cant','cant_r','proteine','lipide','glucide','calorii');

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('cant');;
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
