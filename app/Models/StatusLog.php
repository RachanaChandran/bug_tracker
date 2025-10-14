<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    protected $fillable = ['issue_id','user_id','old_status','new_status','assigned_to'];
    public function issue(){
        return $this->hasOne(Issue::class,'id','issue_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function assignedTo(){
        return $this->belongsTo(User::class,'assigned_to');
    }
}
