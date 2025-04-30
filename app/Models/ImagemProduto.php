<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\Produto;

class ImagemProduto extends Model
{
   use HasFactory;

   protected $keyType = 'string';
   public $incrementing = false;

   protected $fillable = [
    'produto_id',
    'url_imagem',
   ];

   protected static function boot(){
      parent::boot(); 

      static::creating(function ($model) {
          $model->id = (string) Str::uuid(); 
      });
   }

   public function produto(){
    return $this->belongsTo(Produto::class);
   }
}
