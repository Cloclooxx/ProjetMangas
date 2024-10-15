<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;
use Exception;
use App\dao\ServiceManga;
use App\dao\ServiceGenre;
use App\dao\ServiceDessinateur;
use App\dao\ServiceScenariste;

class MangaController extends Controller
{
    public function listerMangas()
    {
        $erreur = "";
        try {
            $serviceManga = new ServiceManga();
            $mangas = $serviceManga->getMangasAvecNoms();
            foreach ($mangas as $manga) {
                if (!file_exists('assets\\images\\'.$manga->couverture)) {
                    $manga->couverture = 'erreur.png';
                }
            }
            return view('vues/pageMangas', compact('mangas', 'erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }

    public function ajouterManga()
    {
        $erreur = "";
        try {
            $serviceGenre = new ServiceGenre();
            $genres = $serviceGenre->getGenres();
            $serviceDessinateur = new ServiceDessinateur();
            $dessinateurs = $serviceDessinateur->getDessinateurs();
            $serviceScenariste = new ServiceScenariste();
            $scenaristes = $serviceScenariste->getScenaristes();
            return view('vues/formManga', compact('genres', 'dessinateurs', 'scenaristes', 'erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }

    public function validerManga(Request $request)
    {
        try {
            $serviceManga = new ServiceManga();
            $manga = new Manga();
            $manga->titre = $request->input('txt_titre');
            $manga->id_genre = $request->input('sel_genre');
            $manga->id_dessinateur = $request->input('sel_dessinateur');
            $manga->id_scenariste = $request->input('sel_scenariste');
            $manga->prix = $request->input('num_prix');
            $couv = $request->file('file_couv');
            if (isset($couv)) {
                $manga->couverture = $couv->getClientOriginalName();
                $couv->move(public_path().'/assets/images/', $manga->couverture);
            }
            $serviceManga->saveManga($manga);
            return redirect('listerMangas');
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }
}
