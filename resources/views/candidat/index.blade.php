@php
    $session = Illuminate\Support\Facades\DB::table('sessions')->where('status','!=','off')->first();
@endphp
@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="text-center">
            <h6 class="display-5 fw-bold">Bienvenue, {{ Auth::user()->name }}</h6>
        </div>
        <div class="row g-4 justify-content-evenly m-5">
            @if (!App\Models\Dossier::where('user_id', Auth::id())->exists())
                @if (App\Models\Session::where('status','inscription')->count())
                <a  style="border-radius: 2rem" style="cursor: pointer" class="col-xs-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 card shadow-sm m-2 text-decoration-none" data-bs-toggle="modal" data-bs-target="#submitModal">
                @else
                <a href="{{ route('home') }}" class="col-xs-12 col-sm-6 shadow-sm col-md-5 col-lg-4 col-xl-4 card text-decoration-none m-2">
                @endif
            @else
            <a style="cursor: pointer;border-radius: 2rem" href="{{ route('candidat.dossier') }}" class="col-xs-12 col-sm-6 shadow-sm col-md-5 col-lg-4 col-xl-4 card text-decoration-none m-2">
            @endif
                <div class="card-body text-center">
                    <img src="{{ asset('assets/images/Personal files-bro.svg') }}" alt="folder-image">
                    <h3 class="display-6 fw-bold">Dossier</h3>
                </div>
            </a>
            <a  style="border-radius: 2rem" href="{{ route('inbox') }}" class="col-xs-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 card shadow-sm text-decoration-none m-2">
                <div class="card-body text-center">
                    <img src="{{ asset('assets/images/Email capture-amico.svg') }}" alt="email-image">
                    <h3 class="display-6 fw-bold">Inbox</h3>
                        <span class="badge bg-danger rounded-pill p-1">{{ App\Models\Message::where('sent_to',Auth::id())->count() }} messages</span>
                </div>
            </a>
        </a>



        <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                @if (App\Models\Session::where('status','!=','off')->count())
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
                                        </div>
                    </div>
                @endif

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
