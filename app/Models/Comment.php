<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['issue_id','user_id','comment','image'];
    public function issue(){
        return $this->belongsTo(Issue::class,'issue_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
