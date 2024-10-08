@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="blanc">
            <h1>Liste des mangas</h1>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Titre</th>
                <th>Prix</th>
                <th>Couverture</th>
                <th>Libelé</th>
                <th>Nom du dessinateur</th>
                <th>Nom du scénariste</th>
            </tr>
            </thead>
            @foreach($mangas as $manga)
                <tr>
                    <td> {{ $manga->id_manga }}</td>
                    <td> {{ $manga->titre }}</td>
                    <td> {{ $manga->prix }}</td>
                    <td> {{ $manga->couverture }}</td>
                    <td> {{ $manga->lib_genre }}</td>
                    <td> {{ $manga->nom_dessinateur }}</td>
                    <td> {{ $manga->nom_scenariste }}</td>
                    <td style="text-align: center">
                        <a href="{{ url('/')}}">
                            <span class="glyphicon glyphicon-pencil"
                                  data-toggle="tooltip" data-placement="top" title="Modifier">

                            </span>
                        </a>
                    </td>
                </tr>
            @endforeach
            <BR> <BR>
        </table>
    </div>
