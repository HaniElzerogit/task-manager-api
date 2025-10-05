<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = ['id'];  //ما هي الأعمدة التي لا تريد للمستخدم أن يدخل قيمها

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
