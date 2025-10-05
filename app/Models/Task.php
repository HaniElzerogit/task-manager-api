<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'descryption', 'Priority']; //ماهي الأعمدة التي تريد للمستخدم إدخال قيمها
    protected $table = 'tasks'; //تحديد الجدول المراد ربطه بالمودل هذا
    //protected $primaryKey = 'id'; تحديد البرايمري كي للجدول
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function catigories()
    {
        return $this->belongsToMany(Catigory::class, 'catigory_task'); //ضفنا أسم جدول كسر العلاقة لزيادة التأكيد على العلاقة متعدد لمتعدد

    }
    public function favoritesByUser()
    {
        return $this->belongsToMany(User::class, 'favorites'); //ضفنا أسم جدول كسر العلاقة لزيادة التأكيد على العلاقة متعدد لمتعدد

    }
}
