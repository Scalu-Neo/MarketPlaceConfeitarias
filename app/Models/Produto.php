<?php

namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Support\Str;
    use App\Models\Confeitaria;
    use App\Models\ImagemProduto;

    class Produto extends Model
    {
        use HasFactory;

        protected $keyType = 'string';
        public $incrementing = false;

        protected $fillable = [
            'nome',
            'valor',
            'descricao',
            'confeitaria_id'
        ];

        protected static function boot(){
        parent::boot(); 

        static::creating(function ($model) {
            $model->id = (string) Str::uuid(); 
        });
        }

        public function confeitaria(){
            return $this->belongsTo(Confeitaria::class);
        }

        public function imagem(){
            return $this->hasMany(ImagemProduto::class);
        }
    }
