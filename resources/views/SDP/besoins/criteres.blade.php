@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="text-end d-none d-md-block">
            <a href="{{ route('index') }}" class="btn btn-primary">Terminer</a>
        </div>
        <h3>Definition des criteres</h3>
        <h6 class="text-muted mb-4">Si il y a pas des changements dans les criteres, cliquer sur <kbd class="bg-primary fw-bold p-1">Terminer</kbd></h6>
        <h4 class="text-center mt-5 pt-5 display-6">Les criteres d'entretien</h4>
        <div class="table-responsive-md">
        <table class="table border p-4">
            <tbody>
                @foreach ($criteres as $item)
                    @if ($item->type == 'entretien')
                    <form method="POST" action="{{ route('criteres.update', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <tr>
                            <th width="50%">{{ $item->name }}</th>
                            <td width="40%"><input name="pts" class="form-control" type="number" step="0.25" min="0.5" value="{{ $item->pts }}"></td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-outline-warning">modifier</button>
                            </td>
                        </tr>
                    </form>
                    @endif
                @endforeach
            </tbody>
        </table>
        </div>
        <h4 class="text-center mt-5 pt-5 display-6">Les criteres des traveaux scientifique</h4>
        <div class="table-responsive-md">
        <table class="table border p-4">
            <tbody>
                @foreach ($criteres as $item)
                    @if ($item->type == 'traveaux_scientifique')
                    <form method="POST" action="{{ route('criteres.update', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <tr>
                            <th width="50%">{{ $item->name }}</th>
                            <td width="40%"><input name="pts" class="form-control" type="number" step="0.25" min="0.5" value="{{ $item->pts }}"></td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-outline-warning">modifier</button>
                            </td>
                        </tr>
                    </form>
                    @endif
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
@endsection
