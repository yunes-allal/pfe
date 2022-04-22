@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <h1 class="display-3">Bienvenu</h1>
        <h4 class="text-muted py-2">les progrès actuels: </h4>
        <div class="progress" style="width: 40%">
            <div class="progress-bar bg-success" role="progressbar" style="width: 25%;"
                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="container my-3 mt-5">
            <div class="row gy-3 gx-3">
                <div class="col-4">
                    <a class="text-decoration-none" href="{{ route('session.index') }}">
                        <div class="card rounded-pill">
                            <div class="card-body">
                                <i data-feather="edit"></i>
                                <div class="display-6">Besoin</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-4">
                    <div class="card rounded-pill">
                        <div class="card-body">
                            Besoins
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card rounded-pill">
                        <div class="card-body">
                            Besoins
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
