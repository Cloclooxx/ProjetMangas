<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\dao\ServiceManga;

class MangaController extends Controller
{
    public function listerMangas()
    {
        try {
            $serviceManga = new ServiceManga();
            $mangas = $serviceManga->getMangasAvecNoms();
            foreach ($mangas as $manga) {
                if (!file_exists('assets\\images\\'.$manga->couverture)) {
                    $manga->couverture = 'erreur.png';
                }
            }
            return view('vues/pageMangas', compact('mangas'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }
}
