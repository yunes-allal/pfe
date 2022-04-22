@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <h1 class="display-3">Bienvenu</h1>
        <h4 class="text-muted py-2">les progrès actuels: </h4>
        <center>
            <div class="progress" style="width: 40%">
            <div class="progress-bar bg-success" role="progressbar" style="width: 25%;"
                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </center>

        <div class="container my-3 mt-5">
            <div class="row gy-3 gx-3">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <a class="text-decoration-none text-primary" href="{{ route('session.index') }}">
                        <div class="card shadow-sm" style="border-radius: 2rem">
                            <div class="card-body">
                                <ion-icon style="font-size:8rem" name="create-outline"></ion-icon>
                                <div class="display-6 fw-bold">Besoin</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <a class="text-decoration-none text-primary" href="{{ route('candidats') }}">
                        <div class="card shadow-sm" style="border-radius: 2rem">
                            <div class="card-body">
                                <ion-icon style="font-size:8rem" name="people-outline"></ion-icon>
                                <div class="display-6 fw-bold">Candidats</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                    <a class="text-decoration-none text-primary" href="{{ route('session.index') }}">
                        <div class="card shadow-sm" style="border-radius: 2rem">
                            <div class="card-body">
                                <ion-icon style="font-size:8rem" name="create-outline"></ion-icon>
                                <div class="display-6 fw-bold">Commissions</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
