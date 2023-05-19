<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'amount',
        'description',
        'date',
    ];
    protected $with = [
        'category',
    ];
    public function user(){
        return $this->belongsTo(User::class)->select('name', 'id');
    }
    public function category(){
        return $this->belongsTo(Category::class)->select('name', 'id');;
    }
}
