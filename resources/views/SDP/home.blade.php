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
    }else{
        $session = NULL;
    }
@endphp

@section('content')
    <div class="container text-center my-5">
        <h1 class="display-3 fw-bold">Bienvenue</h1>
        <h4 class="text-muted py-2">
            Etape actuelle:
            <span class="@if ($session_number) @if($session->status=='off') text-danger @else text-success @endif @endif fw-bold">{{ $step }}</span>
        </h4>
         <center>
            <div class="progress" style="width: 40%">
                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">{{ $progress.'%'}}</div>
            </div>
        </center>

<div class="container my-3 mt-5">
    <div class="row gy-3 gx-3">
        {{-- besoins --}}
        @if (!$session_number || ($session && ($session->status =='off' || $session->status == 'declaring')))
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
        @if (!(App\Models\Session::where('status','off')->count() ||App\Models\Session::where('status','declaring')->count() ||App\Models\Session::where('status','deliberation')->count()))
         @if (!(App\Models\Session::where('status','interview')->count() && now()>App\Models\Commission::min('start_date') && now()<App\Models\Commission::max('end_date')))
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
        @endif


        @endif
            {{-- INBOX --}}
            @if (App\Models\Session::where('status','conformity')->count())
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <a class="text-decoration-none text-primary" href="{{ route('inbox') }}">
                        <div class="card shadow-sm" style="border-radius: 2rem">
                            <div class="card-body">
                                <img src="{{ asset('assets/images/Email capture-amico.svg') }}" alt="">
                                <div class="display-6 fw-bold">Recours</div>
                                <span class="badge bg-danger rounded-pill p-1">
                                    {{ App\Models\Message::where('sent_to',Auth::id())->where('is_replied',1)->count() }} / {{ App\Models\Message::where('sent_to',Auth::id())->count() }} messages</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

        {{-- PVs --}}
        @if (0 && $session_number && ($session->status !='off' || $session->status != 'declaring'))
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
        @if (0)
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
        @endif

    </div>
</div>





    </div>
@endsection
