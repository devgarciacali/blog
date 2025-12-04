<?php
// se deben llamar a los controladores 

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Principal
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/all', [HomeController::class, 'all'])->name('home.all');

//Administrador
Route::get('admin/', [AdminController::class, 'index'])->name('admin.index');

// Rutas del admin
Route::namespace('App\Http\Controllers')->prefix('admin')->group(function () {
        // Articulos
        Route::resource('articles', 'ArticleController')
                                ->except('show')
                                ->names('articles');

        // Categorias
       Route::resource('categories', 'CategoryController')
                                ->except('show')
                                ->names('categories');

        //Comentarios
       Route::resource('comments', 'CommentController')
                                ->only('index', 'destroy')
                                ->names('comments');
});

// Articulos
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

Route::resource('articles', ArticleController::class)
        ->except('show')
        ->names('articles');


Route::resource('categories', CategoryController::class)
        ->except('show')
        ->names('categories');

//Comentarios
Route::resource('comments', CommentController::class)
        ->only('index', 'destroy')
        ->names('comments');

// perfiles 
Route::resource('profiles', ProfileController::class)
        ->only('edit', 'update')
        ->names('profiles');


//Ver articulor
Route::get('article/{article}', [ArticleController::class, 'show'])->name('articles.show');
//ver categorias
Route::get('categorys', [CategoryController::class, 'index'])->name('categories.show');

// ver articulos por categoria
Route::get('categorys/{category}', [CategoryController::class, 'detail'])->name('categories.detail');

// guardar comentario
Route::post('comment', [CommentController::class, 'store'])->name('comments.store');


Auth::routes();