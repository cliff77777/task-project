<?php

namespace Database\Factories;

use App\Models\UserRole;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserRole>
 */
class UserRoleFactory extends Factory
{

    protected $model = UserRole::class;

    /**
     * Define the model's default state.
     *     
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'role_name' => $this->faker->word,
            'role_control' => $this->faker->sentence,
            'role_descript' =>$this->faker->sentence,
            'created_by' => $this->faker->sentence,
        ];
    }
}
