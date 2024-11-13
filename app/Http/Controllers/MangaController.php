<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Exception;
use App\dao\ServiceManga;
use App\dao\ServiceGenre;
use App\dao\ServiceDessinateur;
use App\dao\ServiceScenariste;
use Illuminate\Support\Facades\Session;

class MangaController extends Controller
{
    public function listerMangas()
    {
        $erreur = "";
        try {
            $title = "Liste des mangas";
            $serviceManga = new ServiceManga();
            $mangas = $serviceManga->getMangasAvecNoms();
            foreach ($mangas as $manga) {
                if (!file_exists('assets/images/'.$manga->couverture)) {
                    $manga->couverture = 'erreur.png';
                }
            }
            return view('vues/pageMangas', compact('mangas','title', 'erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }

    public function ajouterManga()
    {
        $erreur = "";
        try {
            $manga = new Manga();
            $manga->id_manga = 0;
            $title = "Ajouter un manga";
            $serviceGenre = new ServiceGenre();
            $genres = $serviceGenre->getGenres();
            $serviceDessinateur = new ServiceDessinateur();
            $dessinateurs = $serviceDessinateur->getDessinateurs();
            $serviceScenariste = new ServiceScenariste();
            $scenaristes = $serviceScenariste->getScenaristes();
            return view('vues/formManga', compact('title','manga','genres', 'dessinateurs', 'scenaristes', 'erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }

    public function validerManga(Request $request)
    {
        try {
            $serviceManga = new ServiceManga();
            $id_manga = $request->input('hid_id');
            if ($id_manga == 0) {
                $manga = new Manga();
            } else {
                $manga = $serviceManga->getManga($id_manga);
            }
            $manga->titre = $request->input('txt_titre');
            $manga->id_genre = $request->input('sel_genre');
            $manga->id_dessinateur = $request->input('sel_dessinateur');
            $manga->id_scenariste = $request->input('sel_scenariste');
            $manga->prix = $request->input('num_prix');
            $couv = $request->file('fil_couv');
            if (isset($couv)) {
                $manga->couverture = $couv->getClientOriginalName();
                $couv->move(public_path().'/assets/images/', $manga->couverture);
            }
            $serviceManga->saveManga($manga);
            return redirect('/listerMangas');
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }

    public function modifierManga($id)
    {
        try {
            $title = "Modifier un manga";
            $serviceManga = new ServiceManga();
            $serviceGenre = new ServiceGenre();
            $serviceDessinateur = new ServiceDessinateur();
            $serviceScenariste = new ServiceScenariste();
            $manga = $serviceManga->getManga($id);
            $genres = $serviceGenre->getGenres();
            $dessinateurs = $serviceDessinateur->getDessinateurs();
            $scenaristes = $serviceScenariste->getScenaristes();
            return view('vues/formManga', compact('title', 'manga', 'genres', 'dessinateurs', 'scenaristes'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }

    public function supprimerManga($id)
    {
        try {
            $sesrviceManga = new ServiceManga();
            $sesrviceManga->delManga($id);
            return redirect(route('mangas'));
        } catch (QueryException $e) {
            $erreur = $e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }

    public function mangaParGenre()
    {
        try {
            $erreur = Session::get('erreur');
            Session::forget('erreur');
            $serviceGenre = new ServiceGenre();
            $genres = $serviceGenre->getGenres();
            return view('vues/formMangaParGenre', compact('genres', 'erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }

    public function validerGenre(Request $request)
    {
        try {
            $id = $request->input('sel_genre');
            if ($id==0) {
                Session::put('erreur',"Vous devez choisir un genre");
                return redirect(route('selGenre'));
            }
            $serviceGenre = new ServiceGenre();
            $genre = $serviceGenre->getGenre($id);
            $title = "Liste des mangas par genre";
            $serviceManga = new ServiceManga();
            $mangas = $serviceManga->getMangaByGenre($id);

            return view('vues/pageMangas', compact('mangas', 'title', 'genre'));
        } catch (Exception $e) {
            $erreur=$e->getMessage();
            return view('vues/pageErreur', compact('erreur'));
        }
    }
}
