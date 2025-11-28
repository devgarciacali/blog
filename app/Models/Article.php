<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
   use HasFactory;
   protected $guarded = [
      'id',
      'created_at',
      'update_at',
   ];
   //Relacion de uno a muchos articulos-user
   public function user()
   {
      return $this->belongsTo(User::class);
   }

   // de uno a muchos articulos-comentarios
   public function comments()
   {
      return $this->hasMany(Comment::class);
   }


   // relacion uno a muchos articulos-categorias
   public function category()
   {
      return $this->belongsTo(Category::class);
   }

   // utilizar slug en lugar de id
   public function getRouteKeyName()
   {
      return 'slug';
   }
}
 