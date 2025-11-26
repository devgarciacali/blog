<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    //Relacion de uno a muchos comentarios-user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Relacion de uno a muchos comentarios-articulos
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}