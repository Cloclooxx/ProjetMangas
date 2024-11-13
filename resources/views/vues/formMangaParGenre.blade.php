@extends('layouts.master')
@section('content')
    <div>
        <div class="container">
            <div class="blanc">
                <h1>Liste des mangas par genre</h1>
            </div>
            {!! Form::open(['route' => 'postGenre']) !!}
            <div class="col-md-9 well well-sm">
            <div class="form-group">
                <label class="col-md-3 control-label">Genre :</label>
                    <div class="col-md-6">
                        <select class="form-control" name="sel_genre">
                            <option value="0" disabled selected="selected">Sélectionner un genre</option>
                            @foreach($genres as $unG)
                                <option value="{{$unG->id_genre}}">{{$unG->lib_genre}}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
                <br><br>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="submit" class="btn btn-default btn-primary"><span
                            class="glyphicon glyphicon-ok"></span> Valider
                        </button>
                        &nbsp;
                        <button type="button" class="btn btn-default btn-primary"
                            onclick="{ window.location = '{{ route('accueil') }}';}">
                            <span class="glyphicon glyphicon-remove"></span>Annuler
                        </button>
                    </div>
                </div>
            </div>
            </div>
        @if(isset($erreur))
            <div class="alert-danger" role="alert">
                <p><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                 {{$erreur}}</p>
            </div>
        @endif
        </div>
    </div>
@endsection
