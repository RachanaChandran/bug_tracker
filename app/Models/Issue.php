<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = ['bug', 'comment', 'file', 'status','assigned_to','start_date','hours','priority'];
    // public function assignedUser(){
    //     return $this->hasOne(User::class,'id','assigned_to');
    // }
     public function assignedUser(){
        return $this->belongsTo(User::class,'assigned_to');
     }
     public function comments(){
      return $this->hasMany(Comment::class);
     }
}
