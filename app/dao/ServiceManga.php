<?php

namespace App\dao;

use App\Models\Manga;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Exceptions\MonException;
use function Laravel\Prompts\select;

class ServiceManga
{
    public function getMangasAvecNoms()
    {
        try {
            $mangas=DB::table('manga')
                ->select('id_manga', 'titre', 'prix', 'couverture',
                    'genre.lib_genre', 'dessinateur.nom_dessinateur', 'scenariste.nom_scenariste')
                ->join('genre', 'genre.id_genre', '=', 'manga.id_genre')
                ->join('dessinateur', 'dessinateur.id_dessinateur', '=', 'manga.id_dessinateur')
                ->join('scenariste', 'scenariste.id_scenariste', '=', 'manga.id_scenariste')
                ->get();
            return $mangas;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function saveManga(Manga $manga)
    {
        try {
            $manga->save();
        } catch (QueryException $e) {
            $erreur = $e->getMessage();
            if ($manga->id_genre==0){
                $erreur="Vous devez sélectionner un genre";
            } else if ($manga->id_dessinateur==0) {
                $erreur="Vous devez sélectionner un dessinateur";
            } else if ($manga->id_scenariste==0) {
                $erreur="Vous devez sélectionner un scénariste";
            } else if (!isset($manga->couverture)) {
                $erreur="Vous devez choisir une image de couverture";
            }
            throw new MonException($erreur, 5);
        }
    }

    public function getManga($id)
    {
        try {
            return Manga::query()
                ->findOrFail($id);
        } catch(QueryException $e){
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function delManga($id)
    {
        try {
            return Manga::destroy($id);
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function getMangaByGenre($id)
    {
        try {
            $mangas=DB::table('manga')
                ->select('id_manga', 'titre', 'prix', 'couverture',
                    'genre.lib_genre', 'dessinateur.nom_dessinateur', 'scenariste.nom_scenariste')
                ->join('genre', 'genre.id_genre', '=', 'manga.id_genre')
                ->join('dessinateur', 'dessinateur.id_dessinateur', '=', 'manga.id_dessinateur')
                ->join('scenariste', 'scenariste.id_scenariste', '=', 'manga.id_scenariste')
                ->where('manga.id_genre', '=', $id)
                ->get();
            return $mangas;
        } catch (QueryException $e) {
            $erreur=$e->getMessage();
            throw new MonException($erreur, 5);
        }
    }
}
