<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamp = false;
    protected $fillable =
    [
    'id',
    'name'
    ];
    // public function recipe()
    // {
    //     return $this->belongsTo(Recipe::class);
    // }
}
