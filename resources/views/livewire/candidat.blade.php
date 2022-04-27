@php

@endphp
<div>
    <div class="container-fluid">
        <form class="row my-3" action="">
            <div class="mb-3 col-xs-12 col-sm-6">
                <input wire:model='search' class="form-control" type="text" placeholder="Chercher sur..">
            </div>
            <div class="mb-3 col-xs-12 col-sm-6 col-md-2 ">
              <select wire:model='orderBy' class="form-select">
                <option value="name">Nom</option>
                <option value="email">Specialite</option>
                <option value="created_at">Date d'inscription</option>
              </select>
            </div>
            <div class="mb-3 col-xs-12 col-sm-6 col-md-2 ">
                <select wire:model='orderAsc' class="form-select">
                  <option value="1">Croissant</option>
                  <option value="0">Décroissant</option>
                </select>
            </div>
            <div class="mb-3 col-xs-12 col-sm-6 col-md-2 ">
              <select wire:model='perPage' class="form-select">
                <option value="5" selected>5</option>
                <option value="15">15</option>
                <option value="{{ App\Models\User::all()->count() }}">Tous</option>
              </select>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered caption-top">
                <caption>Page: {{ $candidats->currentPage() }}</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom et prenom</th>
                        <th>Specialite</th>
                        <th>date d'inscription</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($candidats as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td class="text-success fw-bold">{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                        </tr>

                    @empty

                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center my-3">
                {!! $candidats->links('pagination::simple-bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
