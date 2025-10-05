<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); //في حال اليوزر انحذف بتنحذف كل التاسكات الخاصة فيه
            $table->string('title');
            $table->string('descryption')->nullable();
            $table->enum('Priority', ['high', 'medium', 'low']); //العمود يأخذ أحد هذه القيم
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
