@php
    $progress = 0;
    $step = 'OFF';
@endphp
@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <h1 class="display-3">Bienvenu</h1>
        <h4 class="text-muted py-2">

            @if (App\Models\Session::count())
                @php
                $session = Illuminate\Support\Facades\DB::table('sessions')->select('status')->latest()->first();
                @endphp
                Etape actuelle:
                @if ($session->status == 'off')
                    <span class="text-danger fw-bold">{{ $step }}</span>
                @else
                    @php
                        if($session->status == 'declaring'){
                            $progress = 3;

                            $step = 'Declaration du session';
                        }else if($session->status == 'inscription'){
                            $progress = 20;
                            $step = 'Inscription des candidats';
                        }else if($session->status == 'commission1'){
                            $progress = 40;
                            $step = 'Verification des dossiers';
                        }else if($session->status == 'commission2'){
                            $progress = 60;
                            $step = 'Entretien';
                        }else if($session->status == 'commission3'){
                            $progress = 80;
                            $step = 'Verification des traveaux scientifiques';
                        }else if($session->status == 'deliberation'){
                            $progress = 100;
                            $step = 'Délibération finale';
                        }
                    @endphp
                @endif
                <span class="text-success fw-bold">{{ $step }}</span>
        </h4>
         <center>
            <div class="progress" style="width: 40%">
                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">{{ $progress.'%'}}</div>
            </div>
        </center>
        @endif


        <div class="container my-3 mt-5">
            <div class="row gy-3 gx-3">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <a class="text-decoration-none text-primary" href="{{ route('session.index') }}">
                        <div class="card shadow-sm" style="border-radius: 2rem">
                            <div class="card-body">
                                <img src="{{ asset('assets/images/Folder-bro.svg') }}" alt="">
                                <div class="display-6 fw-bold">Besoin</div>
                            </div>
                        </div>
                    </a>
                </div>
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
            </div>
        </div>
    </div>
@endsection
