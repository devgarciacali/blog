<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Article;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mostrar las categorias en el admin

        $categories = Category::orderBy('id', 'desc')
            ->simplePaginate(8);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // morstrar el formulario de las categorias
        // el admin es una carpeta
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Category $request)
    {

        $category = $request->all();
        //Validar si hay un archivo
        if ($request->hasFile('image')) {
            $category['image'] = $request->file('image')->store('categories');
        }

        // guardar la informacio
        Category::create($category);

        return redirect()->action([CategoryController::class, 'index'])
            ->with('success', 'Categoria creada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // si el usuario sube una nueva imagen
        if ($request->hasFile('image')) {
            // eliminar la imagen anterior
            File::delete(public_path('storage/' . $category->image));
            // guardar la nueva imagen
            $category['image'] = $request->file('image')->store('categories');
        }

        //acvtualizar la informacion
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
        ]);
        return redirect()->action([CategoryController::class, 'index'], compact('category'))
            ->with('success-update', 'Categoria actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // eliminar imagen de la categoria
        if ($category->image) {
            File::delete(public_path('storage/' . $category->image));
        }
        $category->delete();
        return redirect()->action([CategoryController::class, 'index'])
            ->with('success-delete', 'Categoria eliminada correctamente');
    }

    //Filtrar articulos por categoria
    public function detail(Category $category)
    {
        $this->authorize('published',$category);
        $articles = Article::where([
            ['category_id', $category->id],
            ['status', '1']
        ])
            ->orderBy('id', 'desc')
            ->simplePaginate(5);

        $navbar = Category::where('status', '0')
            ->paginate(3);

        return view('subscriber.categories.detail', compact('articles', 'category', 'navbar'));
    }
}
