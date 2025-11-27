<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // se guarda el titulo en una variable para reutilizarlo
        $title = $this->faker->unique()->realText(55);
        // se retorna el array con los datos del articulo
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'introduction' => $this->faker->realText(55),
            'image' => $this->faker->image('public/storage/articles',640,480, null, true),

        ];
    }
}
