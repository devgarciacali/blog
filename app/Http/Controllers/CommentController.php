<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = DB::table('comments')
            ->join('articles', 'comments.article_id', '=', 'articles.id')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->select(
                'comments.value',
                'comments.description',
                'articles.title',
                'users.full_name'
            )
            ->where('articles.id', '=', Auth::user()->id)
            ->orderBy('articles.id', 'desc')
            ->get();
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        // si en el articulo ya existe un comentario de este usuario
        $result = Comment::where('user_id', Auth::user()->id)
            //se trae el id del artivculo
            ->where('article_id', $request->article_id)
            ->exists();
        // Consulta pra obtner el slug y estado del articulo comentado
        $artcle = Article::select('status', 'slug')->find($request->article_id);

        // si no existe y si el etsado del articulo es publico, comentar.
        if (!$result and $artcle->status == 1) {
            Comment::create([
                'value' => $request->value,
                'description' => $request->description,
                'user' => Auth::user()->id,
                'article_id' => $request->article_id,
            ]);
            return redirect()->action([ArticleController::class, 'show'], ['article' => $artcle->slug]);
        } else {
            // si ya existe o el articulo no esta publico, redirigir con mensaje de error
            return redirect()->action([ArticleController::class, 'show'], ['article' => $artcle->slug])
                ->with('sucess-error', 'Ya has comentado este articulo o el articulo no esta publico');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->action([CommentController::class, 'index'], compact('comment'))
            ->with('success-delete', 'Comentario eliminado correctamente');
    }
}
