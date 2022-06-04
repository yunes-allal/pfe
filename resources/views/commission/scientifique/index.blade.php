@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center">
        <h6 class="display-5">Bienvenu, la commission d'es traveaux scientifiques</h6>
    </div>
    <div class="row g-4 justify-content-evenly m-5">
        <a style="cursor: pointer;" href="{{ route('liste.des.candidats') }}" class="col-xs-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 card shadow-sm rounded text-decoration-none m-2">
            <div class="card-body text-center">
                <img src="{{ asset('assets/images/Completed-bro.svg') }}" alt="List">
                <h3 class="display-6">Les candidats</h3>
            </div>
        </a>
        <a style="cursor: pointer;"  href="" class="colxs-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 card shadow-sm rounded text-decoration-none m-2">
            <div class="card-body text-center">
                <img src="{{ asset('assets/images/Documents-amico.svg') }}" alt="PV">
                <h3 class="display-6">PV</h3>
            </div>
        </a>
    </a>
</div>
@endsection
