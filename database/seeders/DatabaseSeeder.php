<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        //llamar al sedeer
        $this->call(UserSeeder::class);
        //factory de categorias
        Category::factory(8)->create();
        //factory de articulos
        Article::factory(20)->create();
        //factory de comentarios
        Comment::factory(20)->create();
    }
}
