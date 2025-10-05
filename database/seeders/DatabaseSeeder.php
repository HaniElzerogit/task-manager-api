<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    //إذا كان لدينا أكثر من سيدر يمكننا استدعائهم جميعا هنا و من ثم عمل سيد لهم جميعا مرة واحدة بدل من عمل سيد لكل سيدر على حدى
    public function run(): void
    {
        $this->call([
            CatigorySeeder::class,
            UserSeeder::class,
            TaskSeeder::class
        ]); //لإضافة سيدر اخر نضع , ثم أسم السيدر الثاني
    }
}
