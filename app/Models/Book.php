<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\User;
use App\Models\Category;

class Book extends Model
{
    use softDeletes;
    use HasFactory;

    protected $fillable = [
    	'date',
        'cost',
        'category_id',
        'content',
        'user_id'
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

}
