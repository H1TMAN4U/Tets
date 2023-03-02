<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    use HasFactory;
    protected $fillable = ['id','name'];

    public function setCategoryAttribute($value)
    {
        $this->attributes['name'] = json_encode($value);
    }

    public function getCategoryAttribute($value)
    {
        return $this->attributes['name'] = json_decode($value);
    }
}
