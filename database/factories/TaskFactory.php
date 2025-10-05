<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id, //ترتيب جدول اليوزر بكشل عشوائي و أخذ قيمة المعرف من أول سطر
            'title' => fake()->sentence(),
            'descryption' => fake()->paragraph(),
            'Priority' => fake()->randomElement(['high', 'medium', 'low']),
        ];
    }
}
