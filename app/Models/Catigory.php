<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catigory extends Model
{
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'catigory_task'); //ضفنا أسم جدول كسر العلاقة لزيادة التأكيد على العلاقة متعدد لمتعدد
    }
}
