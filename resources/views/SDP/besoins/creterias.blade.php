@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-end"><a class="btn btn-primary" href="{{ route('criteres.create') }}">Terminer</a></div>
        <h3>Definition des criteres globales</h3>
        <p class="fs-5 text-muted mb-5">Toutes les criteres énoncées ci-dessous appartiennent au session de:
            <small class="fw-bold text-success">
                @php
                    $session = Illuminate\Support\Facades\DB::table('sessions')->select('name','global_number')
                                    ->where('on_going','=','true')
                                    ->get();
                    $session_name = Carbon\Carbon::parse($session[0]->name)->locale('fr_FR');
                    print(Str::ucfirst($session_name->monthName).'  '.$session_name->year);
                @endphp
            </small>
        </p>
        <form action="" method="post">
                @csrf
            <table class="table table-borderless">
                <thead>
                    <th>Nom de critere</th>
                    <th>pts</th>
                </thead>
                <tbody>
                    @forelse ($default_criterias as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>
                                <input type="number" class="form-control" min="0.5" step="0.5" value="{{ $item->pts }}">
                            </td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </form>
    </div>
@endsection
