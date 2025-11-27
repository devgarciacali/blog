<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\UserSeeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        //eliminar carpeta articles
        Storage::deleteDirectory('articles');
        Storage::deleteDirectory('categories');
        //crear carpeta articles
        Storage::makeDirectory('articles');
        Storage::makeDirectory('categories');
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
