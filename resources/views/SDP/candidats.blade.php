@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h3>Liste des candidats</h3>
        @livewire('candidat')
    </div>
@endsection
