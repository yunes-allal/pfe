@php
    $session = Illuminate\Support\Facades\DB::table('sessions')->where('status','!=','off')->first();
@endphp
@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="text-center">
            <h6 class="display-5">Bienvenu, {{ Auth::user()->name }}</h6>
        </div>
        <div class="row g-4 justify-content-evenly m-5">
            @if (!App\Models\Dossier::where('user_id', Auth::id())->exists())
            <a style="cursor: pointer" class="col-xs-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 card shadow-sm rounded m-2 text-decoration-none" data-bs-toggle="modal" data-bs-target="#submitModal">
            @else
            <a style="cursor: pointer" href="{{ route('candidat.dossier') }}" class="col-xs-12 col-sm-6 shadow-sm col-md-5 col-lg-4 col-xl-4 card rounded text-decoration-none m-2">
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
                <div class="modal-body p-3">
                    <div class="mb-3 lh-lg fs-5">
                        @php
                            $session_name = Carbon\Carbon::parse($session->name)->locale('fr_FR');
                        @endphp
                        voulez-vous participer à la session de
                            <span class="text-danger fw-bold">
                                {{ Str::ucfirst($session_name->monthName).'  '.$session_name->year }}
                            </span>
                        <br>
                        pour plus de details, <a href="/" class="alert-link link-info">cliquer ici</a>
                        <br>vous devez spécifier l'application pour laquelle vous souhaitez postuler
                    </div>
                </div>
                <div class="modal-footer  border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Non, merci</button>
                    <a class="text-decoration-none" href="{{ route('candidat.create.dossier') }}" >
                        <button type="submit" class="btn btn-success text-white">Oui, je veux participer</button>
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
