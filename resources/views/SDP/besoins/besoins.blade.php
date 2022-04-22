@php
    use Illuminate\Support\Facades\DB;

    $global_number = DB::table('besoins')->sum('positions_number');

    function getFaculty($id)
    {
        return DB::table('faculties')->select('name', 'abbr')->where('id', $id)->get();
    }

    function getSector($id)
    {
        return DB::table('sectors')->select('name')->where('id', $id)->get();
    }

    function getSpeciality($id)
    {
        return DB::table('specialities')->select('name')->where('id', $id)->get();
    }
    function getSubspeciality($id)
    {
        return DB::table('subspecialities')->select('name')->where('id', $id)->get();
    }
@endphp

@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="text-end d-none d-md-block"><a class="btn btn-primary" href="{{ route('criteres.create') }}">Suivant</a></div>
        <h3>Expression des besoins</h3>
        <p class="fs-5 text-muted mb-5">Toutes les besoins énoncées ci-dessous appartiennent au session de:
            <small class="fw-bold text-success">
                @php
                    $session = DB::table('sessions')->select('name','global_number')
                                    ->where('on_going','=','true')
                                    ->get();
                    $session_name = Carbon\Carbon::parse($session[0]->name)->locale('fr_FR');
                    print(Str::ucfirst($session_name->monthName).'  '.$session_name->year);
                @endphp
            </small>
        </p>
        @if ($success = Session::get('success'))
            <div class="alert alert-success w-50">{{ $success }}</div>
        @endif
        @if ($fail = Session::get('fail'))
            <div class="alert alert-danger w-50">{{ $fail }}</div>
        @endif
        <div class="row gx-5 gy-4 justify-content-center">
            @if ($global_number < $session[0]->global_number)
                @livewire('besoin')
            @endif
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 table-responsive d-none d-md-block">
                <table class="table table-bordered caption-top">
                    <caption>Liste des besoins</caption>
                    <thead class="border border-muted">
                        <th>Faculte</th>
                        <th>Filiere</th>
                        <th>Specialite</th>
                        <th class="text-truncate border-end-0">Nombre de postes</th>
                    </thead>
                    <tbody class="border border-muted">
                        @forelse ($besoins as $item)
                        <tr>
                        <td class="text-truncate">
                            @php
                                $faculty = getFaculty($item->faculty_id);
                            @endphp
                            <abbr title="{{ $faculty[0]->name }}">{{ $faculty[0]->abbr }}</abbr>
                            </td>
                            <td>
                                @php
                                $sector = getSector($item->sector_id);
                                @endphp
                                {{ $sector[0]->name }}
                            </td>
                            <td>
                                @php
                                if (!$item->speciality_id) {
                                    print('Tous les specialites');
                                }else{
                                    $speciality = getSpeciality($item->speciality_id);
                                    $subspeciality = getSubspeciality($item->subspeciality_id);
                                    if ($subspeciality) {
                                    print($speciality[0]->name.' ( '.$subspeciality[0]->name.' )');
                                    }else{
                                        print($speciality[0]->name);
                                    }
                                }
                                @endphp
                            </td>
                            <td>{{ $item->positions_number }}</td>
                            <td>
                                <form method="POST" action="{{ route('besoins.destroy', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger p-1" data-bs-toggle="modal" data-bs-target="#delete">
                                    <small>Supprimer</small>
                                    </button>
                                    {{-- Modal --}}
                                    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body text-muted mb-0 mt-2">
                                                Êtes-vous sûr de vouloir supprimer définitivement cet élément?
                                            </div>
                                            <div class="modal-footer border-top-0 mt-0">
                                            <button type="button" class="btn btn-light rounded" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-danger rounded">Supprimer</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center fw-bold text-muted" colspan="5">
                                <img class="img-fluid w-25" src="{{ asset('assets/images/empty-box.png') }}" alt="empty box">
                                <p>Vous n'avez déclaré aucun besoin</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="border border-muted">
                        <th colspan="3">Total</th>
                        <th colspan="2">
                            {{$global_number}}
                            /{{$session[0]->global_number}}</th>
                    </tfoot>
                </table>
            </div>
        </div>
        {{-- display cards on small screens --}}
        <div class="d-block d-md-none mt-5">
            @if ($global_number < $session[0]->global_number)
                <hr class="my-5 text-muted">
            @else
                <div class="text-center"><a class="btn btn-primary" href="{{ route('criteres.create') }}" data-bs-toggle="modal" data-bs-target="#exampleModal">suivant</a></div>
            @endif
            <h5 class="my-4">List des besoins <span class="fw-bold">{{ $global_number }}/{{ $session[0]->global_number }}</span></h5>
            <div>
                @forelse ($besoins as $item)
                    <div style="border-radius: 2rem;border-top-right-radius: 0rem" class="card mx-auto mb-4 shadow-sm w-75 p-3">
                        <div class="card-body">
                            <h5 class="fw-bold">
                                @php
                                    $sector = getSector($item->sector_id);
                                @endphp
                                {{ $sector[0]->name }}
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">{{ $item->positions_number }}</span>
                                <span class="fs-6 text-muted">
                                    <small>
                                        @php
                                            if (!$item->speciality_id) {
                                                print('Tous les specialites');
                                            }else{
                                                $speciality = getSpeciality($item->speciality_id);
                                                $subspeciality = getSubspeciality($item->subspeciality_id);
                                                if ($subspeciality) {
                                                print($speciality[0]->name.' - '.$subspeciality[0]->name);
                                                }else{
                                                    print($speciality[0]->name);
                                                }
                                            }
                                        @endphp
                                    </small>
                                </span>
                            </h5>
                            <hr class="text-muted">
                            <small class="badge bg-primary">
                                @php
                                    $faculty = getFaculty($item->faculty_id);
                                @endphp
                                {{ $faculty[0]->abbr }}

                            </small>
                            <div class="text-center mt-3">
                                <form method="POST" action="{{ route('besoins.destroy', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger p-1" data-bs-toggle="modal" data-bs-target="#delete-sm">
                                    <small>Supprimer</small>
                                    </button>
                                    {{-- Model --}}
                                    <div class="modal fade" id="delete-sm" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body text-muted mb-0 mt-2">
                                                Êtes-vous sûr de vouloir supprimer définitivement cet élément?
                                            </div>
                                            <div class="modal-footer border-top-0 mt-0">
                                            <button type="button" class="btn btn-light rounded" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-danger rounded">Supprimer</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center fw-bold text-muted">
                        <img class="img-fluid w-25" src="{{ asset('assets/images/empty-box.png') }}" alt="empty box">
                        <p>Vous n'avez déclaré aucun besoin</p>
                    </div>
                @endforelse
            </div>
        </div>
        </div>


        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Session de:
                        @php
                            $session = DB::table('sessions')->where('on_going','=','true')
                                            ->get();
                            $session_name = Carbon\Carbon::parse($session[0]->name)->locale('fr_FR');
                            print(Str::ucfirst($session_name->monthName).'  '.$session_name->year);
                        @endphp
                        , qui contient {{ $session[0]->global_number }} postes
                    </p>
                    <p>ouvre depuis: {{ date('d-m-Y', strtotime($session[0]->start_date)) }}</p>
                    <p>jusqu'a: {{ date('d-m-Y', strtotime($session[0]->end_date)) }}</p>
                    <p class="text-muted">apres cette etape tu peut pas changer les besoins</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                  <button type="button" class="btn btn-success">Valider</button>
                </div>
              </div>
            </div>
          </div>
@endsection
