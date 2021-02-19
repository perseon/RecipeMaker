<?php

namespace App\Models;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
