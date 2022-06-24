@extends('layouts.app')

@php
    $progress = 0;
    $step = 'OFF';
    if($session_number = App\Models\Session::count()){
        $session = Illuminate\Support\Facades\DB::table('sessions')->select('status','end_date')->latest()->first();
        if($session->status == 'declaring'){
            $progress = 3;
            $step = 'Declaration du session';
        }else{
            if($session->status == 'inscription'){
                $progress = 20;
                $step = 'Inscription des candidats';
            }else{
               if($session->status == 'conformity'){
                            $progress = 40;
                            $step = 'Verification des dossiers';
                }else{
                    if($session->status == 'interview'){
                                $progress = 60;
                                $step = 'Entretien';
                    }else{
                        if($session->status == 'sc_works_validation'){
                                    $progress = 80;
                                    $step = 'Verification des traveaux scientifiques';
                        }else{
                            if($session->status == 'deliberation'){
                                        $progress = 99;
                                        $step = 'Délibération finale';
                                    }
                        }
                    }
                }
            }
        }
    }
@endphp

@section('content')
    <div class="container text-center my-5">
        <h1 class="display-3">Bienvenu</h1>
        <h4 class="text-muted py-2">
            Etape actuelle:
            <span class="@if ($session && $session->status == 'off') text-danger @else text-success @endif fw-bold">{{ $step }}</span>
        </h4>
         <center>
            <div class="progress" style="width: 40%">
                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">{{ $progress.'%'}}</div>
            </div>
        </center>

        @if ($session && $session->status=='inscription' && $stay = Carbon\Carbon::parse($session->end_date)->diffInDays(now())<3)
            <div class="alert alert-info fs-5 p-4 mt-3 alert-dismissible fade show" role="alert">
                <strong>
                    <div class="fs-4">restez <span class="text-danger">{{ $stay }}</span> jours pour la fin de l'inscription</div>
                    <br> Vous devez envoyer les comptes du commission aux chefs des départements,
                </strong><br>
                <a href="{{ route('commission.index') }}" class="alert-link">Cliquez ici</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @else
            @if ($session && $session->status=='conformity' && App\Models\Dossier::where('is_validated',1)->where('is_conformed', NULL)->count() == 0)
                <div class="alert alert-info fs-5 p-4 mt-3 alert-dismissible fade show" role="alert">
                    <strong>
                        <div class="fs-4">Vous pouvez commencer l'étape de l'entretien</div>
                    </strong><br>
                    <a href="{{ route('commission.update.state') }}" class="alert-link">Cliquez ici</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @else
            @if ($session && $session->status=='interview' && now() >= App\Models\Commission::max('start_date') && App\Models\Note::where('entretien_1', NULL)->count() == 0)
                <div class="alert alert-info fs-5 p-4 mt-3 alert-dismissible fade show" role="alert">
                    <strong>
                        <div class="fs-4">Vous pouvez commencer l'étape de validation des traveaux scientifiques</div>
                    </strong><br>
                    <a href="{{ route('commission.update.state') }}" class="alert-link">Cliquez ici</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @endif
        @endif

        <div class="container my-3 mt-5">
            <div class="row gy-3 gx-3">
                {{-- besoins --}}
                @if ($session_number && ($session->status =='off' || $session->status == 'declaring'))
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <a class="text-decoration-none text-primary" href="{{ route('session.index') }}">
                            <div class="card shadow-sm" style="border-radius: 2rem;">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/Folder-bro.svg') }}" alt="">
                                    <div class="display-6 fw-bold">Besoins</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                {{-- liste des candidats --}}
                @if ($session_number && ($session->status !='off' || $session->status != 'declaring'))
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <a class="text-decoration-none text-primary" href="{{ route('candidats') }}">
                            <div class="card shadow-sm" style="border-radius: 2rem">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/Completed-bro.svg') }}" alt="">
                                    <div class="display-6 fw-bold">Candidats</div>
                                </div>
                            </div>
                        </a>
                    </div>

                {{-- commissions --}}
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <a class="text-decoration-none text-primary" href="{{ route('commission.index') }}">
                            <div class="card shadow-sm" style="border-radius: 2rem">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/Resume folder-pana.svg') }}" alt="">
                                    <div class="display-6 fw-bold">Commissions</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                    {{-- INBOX --}}
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <a class="text-decoration-none text-primary" href="{{ route('inbox') }}">
                        <div class="card shadow-sm" style="border-radius: 2rem">
                            <div class="card-body">
                                <img src="{{ asset('assets/images/Email capture-amico.svg') }}" alt="">
                                <div class="display-6 fw-bold">Inbox</div>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- PVs --}}
                @if ($session_number && ($session->status !='off' || $session->status != 'declaring'))
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <a class="text-decoration-none text-primary" href="{{ route('pvs') }}">
                            <div class="card shadow-sm" style="border-radius: 2rem">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/Duplicate-bro.svg') }}" alt="">
                                    <div class="display-6 fw-bold">PVs</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                {{-- Deliberation --}}
                @if ($session_number && $session->status == 'deliberation')
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <a class="text-decoration-none text-primary" href="{{ route('deliberation.finale') }}">
                            <div class="card shadow-sm" style="border-radius: 2rem">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/Notes-bro.svg') }}" alt="">
                                    <div class="display-6 fw-bold">Délibération</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                {{-- Historique --}}
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <a class="text-decoration-none text-primary" href="{{ route('home') }}">
                        <div class="card shadow-sm" style="border-radius: 2rem">
                            <div class="card-body">
                                <img src="{{ asset('assets/images/Work time-pana.svg') }}" alt="">
                                <div class="display-6 fw-bold">Historique</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
