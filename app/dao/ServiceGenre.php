<?php

namespace App\dao;

use App\Models\Genre;
use Illuminate\Database\QueryException;
use App\Exceptions\MonException;
use Illuminate\Support\Facades\DB;

class ServiceGenre
{
    public function getGenres()
    {
        try {
            return Genre::all();
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function getGenre($id)
    {
        try {
            $genre = DB::table('genre')
                ->select('lib_genre')
                ->where('id_genre', '=', $id)
                ->get()
                ->first();
            return $genre;
        } catch (QueryException $e) {
            $erreur = $e->getMessage();
            throw new MonException($erreur, 5);
        }
    }
}
