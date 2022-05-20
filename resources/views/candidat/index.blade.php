@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="text-center">
            <h6 class="display-5">Bienvenu, {{ Auth::user()->name }}</h6>
        </div>
        <div class="row g-4 justify-content-evenly m-5">
            @if (!App\Models\Dossier::where('user_id', Auth::id())->exists())
            <a class="col-xs-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 card shadow-sm rounded m-2" data-bs-toggle="modal" data-bs-target="#submitModal">
            @else
            <a href="{{ route('candidat.dossier') }}" class="col-xs-12 col-sm-6 shadow-sm col-md-5 col-lg-4 col-xl-4 card rounded text-decoration-none m-2">
            @endif
                <div class="card-body text-center">
                    <img src="{{ asset('assets/images/Personal files-bro.svg') }}" alt="folder-image">
                    <h3 class="display-6">Dossier</h3>
                </div>
            </a>
            <a href="" class="colxs-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 card shadow-sm rounded text-decoration-none m-2">
                <div class="card-body text-center">
                    <img src="{{ asset('assets/images/Email capture-amico.svg') }}" alt="email-image">
                    <h3 class="display-6">Inbox</h3>
                </div>
            </a>
        </a>



        <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="submitModalLabel">Choix de l'application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-muted mb-3">
                        vous devez spécifier l'application pour laquelle vous souhaitez postuler
                    </div>
                    <form method="POST" action="{{ route('candidat.create.dossier') }}" >
                        @csrf
                        <select class="form-select" name="besoin_id">
                            {{ $empty = 0; }}
                            @forelse (App\Models\Besoin::all() as $item)
                               <option value="{{ $item->id }}">{{ $item->sector_id }}</option>
                            @empty
                                {{ $empty = 1; }}
                                <div class="alert alert-danger my-2 mx-2">
                                    Il y'a pas de session maintenant
                                </div>
                            @endforelse
                        </select>
                </div>
                <div class="modal-footer">
                @if (!$empty)
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Continuer</button>
                @else
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Ok, j'ai compris</button>
                @endif
                </div>
            </form>
            </div>
            </div>
        </div>
    </div>
@endsection
