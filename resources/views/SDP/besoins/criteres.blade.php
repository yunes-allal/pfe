@extends('layouts.app')

@section('content')
    <div class="container my-5">

        <h3>Definition des critères</h3>
        <h6 class="text-muted mb-4">Si il y a pas des changements dans les critères, cliquer sur <kbd class="bg-primary fw-bold p-1">Terminer</kbd></h6>
        <div class="text-center text-md-end">
               <button type="submit" class="btn btn-primary" data-bs-target="#confirmation" data-bs-toggle="modal">Terminer</button>
        </div>
        <h4 class="text-center mt-4 pt-5 display-6">Les critères d'entretien</h4>
        <div class="table-responsive-md">
        <table class="table border p-4">
            <tbody>
                @foreach ($criteres as $item)
                    @if ($item->type == 'entretien')
                    <form method="POST" action="{{ route('critères.update', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <tr>
                            <th width="50%">{{ $item->name }}</th>
                            <td width="40%"><input name="pts" class="form-control" type="number" step="0.25" min="0.5" value="{{ $item->pts }}"></td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    </form>
                    @endif
                @endforeach
            </tbody>
        </table>
        </div>
        <h4 class="text-center mt-5 pt-5 display-6">Les critères des traveaux scientifique</h4>
        <div class="table-responsive-md">
        <table class="table border p-4">
            <tbody>
                @foreach ($criteres as $item)
                    @if ($item->type == 'traveaux_scientifique')
                    <form method="POST" action="{{ route('critères.update', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <tr>
                            <th width="50%">{{ $item->name }}</th>
                            <td width="40%"><input name="pts" class="form-control" type="number" step="0.25" min="0.5" value="{{ $item->pts }}"></td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    </form>
                    @endif
                @endforeach
            </tbody>
        </table>
        </div>
    </div>


<div class="modal fade" id="confirmation" tabindex="-1" aria-labelledby="confirmationLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body fs-5 p-4 fw-bold">
            Vérifier les critères une dernière fois avant de soumettre!
        </div>
        <div class="modal-footer border-top-0">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
          <form action="{{ route('session.status.update') }}" method="POST">
                @csrf
                <input name="status" type="hidden" value="inscription">
                <button type="submit" class="btn btn-primary">Terminer</button>
            </form>

        </div>
      </div>
    </div>
  </div>
@endsection
