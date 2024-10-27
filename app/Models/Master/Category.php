<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ["name","code"];
    public function drugs(){
        return $this->hasMany(Drug::class)->get();
    }
}