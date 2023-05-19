<?php

namespace App\Models;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description',
    ];
    // protected $with = [
    //     'expenses',
    // ];
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
