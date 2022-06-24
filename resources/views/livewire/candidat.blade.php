@php

@endphp
<div>
    <div class="container-fluid">
        @php
            $counter = App\Models\Dossier::whereDate('updated_at', Carbon\Carbon::today())->where('is_validated',1)->count();
        @endphp
        <form class="row my-3" action="">
            <div class="mb-3 col-xs-12 col-sm-6">
                <input wire:model='search' class="form-control" type="text" placeholder="Chercher sur..">
            </div>
            <div class="mb-3 col-xs-12 col-sm-6 col-md-2 ">
              <select wire:model='orderBy' class="form-select">
                <option value="family_name">Nom</option>
                <option value="diploma_speciality">Specialité</option>
                <option value="updated_at">Date d'inscription</option>
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
        <div class="table-responsive-md border p-4">
            <div class="fw-bold text-info mb-3 text-end">
                Aujourd'hui, <span class="text-danger"> {{ $counter }}</span> candidats ont déposé leur dossier
            </div>
            <table class="table table-borderless caption-top">
                <caption>Page: {{ $candidats->currentPage() }}</caption>
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Nom et prenom</th>
                        <th>Specialité</th>
                        <th class="text-center">date d'inscription</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($candidats as $item)
                        <tr>
                            <td class="text-center">{{ $item->id }}</td>
                            <td class="text-success fw-bold">{{ $item->family_name }} {{ $item->name }}</td>
                            <td>{{ $item->diploma_speciality }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center fw-bold text-muted" colspan="4">
                                <img class="img-fluid w-25" src="{{ asset('assets/images/empty-box.png') }}" alt="empty box">
                                <p>Aucun candidat ne correspond à votre recherche</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center my-4">
                {!! $candidats->links('pagination::simple-bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
