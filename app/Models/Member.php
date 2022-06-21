<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

       protected $fillable = [ 'member_id','name','gender','mobile','blood_group','address','photo','start_date','end_date','lock','card_no','created_by','status',
    ];

    public function user()
       {
           return $this->belongsTo(User::class, 'created_by')->select('id','name');
       }


}