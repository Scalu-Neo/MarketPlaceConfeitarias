<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;


class GeocodeController extends Controller
{
    public function buscarCoordenadas(Request $request){//-> Obtendo coordenadas através da API Geoapify
        $endereco = $request->query('endereco');
        $apiKey = env('GEOCODE_API_KEY');

        $resposta = Http::get("https://api.geoapify.com/v1/geocode/search", [
            'text' => $endereco,
            'apiKey' => $apiKey
        ]);

        if ($resposta->successful() && isset($resposta->json()['features'][0])) {
            $coordenadas = $resposta->json()['features'][0]['geometry']['coordinates'];

            return response()->json([
                'latitude' => $coordenadas[1],
                'longitude' => $coordenadas[0] 
            ]);
        }

        return response()->json(['error' => 'Coordenadas não encontradas'], 404);
    }
}
