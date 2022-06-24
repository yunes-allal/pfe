@php
    $dossiers = App\Models\Dossier::where('is_validated',1)->where('is_conformed', NULL)->get();
@endphp
@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <h3>Les PVs</h3>
        <div class="alert alert-secondary">
            <strong>
                Total des dossiers non révisée:
            </strong>
            <span class="fw-bold text-danger"> {{ $dossiers->count() }}</span>
        </div>
        @if ($dossiers->count())
            <h5 class="fw-bold mt-5">liste des départements qui 'a pas terminer le processus</h5>
            <ul>
            @foreach ($dossiers as $item)
                @php
                    $department = DB::select('SELECT departments.name From departments, besoins WHERE besoins.department_id = departments.id AND besoins.id='.$item->besoin_id);
                @endphp
                <li>Départment de {{ $department[0]->name }}</li>
            @endforeach
            </ul>
        @else
        <h4 class="fw-bold">PVs de confrmite</h4>
        <div class="container">
            <a target="_blank" href="{{ route('pvs.confomite') }}" class="m-3 btn fw-bold btn-success text-white">Les Pvs des dossiers conformes</a>
            <a href="" class="m-3 btn fw-bold btn-danger">Les Pvs des dossiers non-conformes</a><br>
        </div>

        @endif

    </div>
@endsection
