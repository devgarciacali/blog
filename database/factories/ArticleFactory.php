<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
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
        $title = $this->faker->unique()->realText(maxNbChars: 55);
        // se retorna el array con los datos del articulo
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'introduction' => $this->faker->realText(55),
            'image' => 'articles'.$this->faker->image('public/storage/articles',640,480, null, false),
            'body' => $this->faker->text(2000),
            'status' => $this->faker->boolean(),
            'user_id' => User::all()->random()->id,
            'category_id' => Category::all()->random()->id,
        ];
    }
}
