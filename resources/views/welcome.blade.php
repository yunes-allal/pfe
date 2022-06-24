@php
    $session = Illuminate\Support\Facades\DB::table('sessions')->where('status','!=','off')->first();

    function getFaculty($id)
    {
        return DB::table('faculties')->select('name', 'abbr')->where('id', $id)->first();
    }

    function getSector($id)
    {
        return DB::table('sectors')->select('name')->where('id', $id)->first();
    }

    function getSpeciality($id)
    {
        return DB::table('specialities')->select('name')->where('id', $id)->first();
    }
    function getSubspeciality($id)
    {
        return DB::table('subspecialities')->select('name')->where('id', $id)->first();
    }
@endphp

@extends('layouts.app')

@section('content')
        <!-- BODY -->
      <div class="container my-3">
        <div class="row align-items-center" style="background-image: url({{ asset('assets/images/cool-background.svg') }})">
          <div class="col-md-6 col-sm-12">
            <h1 class="display-5 fw-bold">Plateforme de recrutement externe</h1>
            <h1 class="mt-2 lead fw-bold lh-base">pour les maîtres assistants de classe B</p>
            <i class="text-muted">-université de 8 mai 1945 Guelma-</i>
            <div class="mt-4 mb-2 text-center">
                @guest
                   <a href="{{ route('login') }}"><button class="m-3 btn btn-primary btn-lg"><i class="fas fa-sign-in-alt"></i> Se Connecter</button></a>
                @endguest
                @auth
                <a href="{{ route('home') }}"><button class="m-3 btn btn-primary btn-lg"><i class="fas fa-home"></i> Accueil</button></a>
                @endauth
                <a class="m-3 btn btn-outline-secondary btn-lg"><i class="fas fa-info-circle"></i> En Savoir Plus</a>
            </div>
          </div>
          <div class="col">
            <img class="img-responsive img-fluid" src="{{ asset('assets/images/Resume folder-amico.svg') }}">
          </div>
        </div>


        <div id="articles" >
            <div class="d-none d-sm-block" style="height: 10rem;"></div>
            <div class="d-block d-sm-none" style="height: 5rem;"></div>
        </div>

        <section>
            <div class="row g-5 align-items-center">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 order-md-1">
                    <div class="text-center">
                        <h6 class="text-muted">Consultez le dernier Concours de recrutement à</h6>
                        <div class="row align-items-center">
                        <div class="col"><hr></div>
                        <div class="col-6"><h2>l'université de 8 mai 1945 Guelma</h2></div>
                        <div class="col"><hr></div>
                        </div>
                        @if (App\Models\Session::count())
                            <i class="text-muted">Cliquez sur `plus` pour plus de details</i>
                        @endif

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <div class="card p-4 shadow-sm" style="border-radius: 1rem; border-top-right-radius: 0rem">
                        <div class="card-body">
                        @if (App\Models\Session::count())
                            @if ($session->status=="declaring")
                            <div class="text-center">
                                <img class="w-50" src="{{ asset('assets/images/undraw_loading_re_5axr.svg') }}" alt="Comming soon">
                                <div class="fw-bold text-primary mt-2">à venir soyez patient :D </div>
                            </div>
                            @else
                                <div>
                                            @if ($session->status!='off')
                                        <span class="position-absolute top-0 start-100 translate-middle p-2 bg-success border border-light rounded-circle"></span>
                                    @else
                                        <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                                    @endif
                                    <h6>De: <small class="fw-bold text-primary">{{ date('d/m/Y', strtotime($session->start_date)) }}</small></h6>
                                    <h6>à: <small class="fw-bold text-danger">{{ date('d/m/Y', strtotime($session->end_date)) }}</small></h6><br>
                                    <h2 class="card-title text-truncate fw-bold">Avis de recrutement</h2>
                                    <p class="card-text card-title text-secondary">L'Université du 8 mai 1945 de Guelma lance un avis de recrutement extérne de <b class="text-info">{{ $session->global_number }}</b> maîtres assistants de classe `B` dans les spécialités suivantes..</p>
                                    <div class="text-end">
                                        <div class="btn btn-sm btn-info" data-bs-toggle='modal' data-bs-target='#AvisModal'>Plus</div>
                                    </div>

                                    <p class="card-text">
                                    <small class="fw-light text-muted">
                                        @php
                                            Carbon\Carbon::setLocale('fr');
                                            $date = Carbon\Carbon::parse($session->created_at);
                                        @endphp
                                        {{ $date->diffForHumans() }}
                                    </small>
                                    </p>
                                </div>
                            @endif
                        @else
                        <div class="text-center">
                            <img class="w-100" src="{{ asset('assets/images/undraw_not_found_-60-pq.svg') }}" alt="not found">
                            <div class="fw-bold text-primary mt-2">Aucune session détectée :( </div>
                        </div>
                        @endif
                        </div>
                      </div>
                </div>
            </div>
        </section>

        <div style="height: 8rem;"></div>
      </div>


    <div class="modal fade" id="AvisModal" tabindex="-1" aria-labelledby="AvisModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              @if (App\Models\Session::count())
                    <div class="modal-body lh-lg">
                <div class="text-center fs-6">
                    République Algérienne Démocratique et Populaire<br>Ministère de l'Enseignement Supérieur et de la Recherche Scientifique<br>Université 08 Mai 1945 Guelma
                </div>
                <div class="text-center fst-italic fs-3 text-decoration-underline fw-bold"><h2>Avis de recrutement</h2></div>
                <p>L'université du 8 mai 1945 de Guelma lance un avis de recrutement extérne de {{ $session->global_number }} maîtres assistants de classe `B` dans les spécialités suivantes:</p>
                <table class="table table-bordered">
                    <tbody>
                        @php
                            $besoins = Illuminate\Support\Facades\DB::table('besoins')->where('session_id', $session->id)->get();
                        @endphp
                            <tr>
                                <th>Faculte</th>
                                <th>Filiere</th>
                                <th>Specilaite</th>
                                <th>Nombre de postes</th>
                            </tr>
                            @foreach ($besoins as $item)
                                @php
                                    $faculty = getFaculty($item->faculty_id);
                                    $sector = getSector($item->sector_id);
                                    $speciality = 0;
                                    $subspeciality = 0;
                                    if($item->speciality_id){
                                        $speciality = getSpeciality($item->speciality_id);
                                    }
                                    if($item->subspeciality_id){
                                    $subspeciality = getSubspeciality($item->subspeciality_id);
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $faculty->name }}</td>
                                    <td>{{ $sector->name }}</td>
                                    <td>
                                        @if ($speciality)
                                            {{ $speciality->name }}
                                        @else
                                            Tous les specialités
                                        @endif
                                        @if ($subspeciality)
                                            ({{ $subspeciality->name }})
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>

                </table>
                <div class="fs-6 fw-bold text-decoration-underline">Crières de sélection :</div>
                <ul>
                    <li>Adéquation du profil de la formation du candidat avec les exigences du poste demandé ( 0 à 5 points ) .</li>
                    <li>La formation complémentaire au diplôme exigé dans la même spécialité ( 0 à 5 points ) .</li>
                    <li>Les travaux et études réalisés par le candidat dans sa spécialité ( 0 à 2 points ) .</li>
                    <li>L'expérience professionnelle acquise par le candidat ( 0 & 4 points ) .</li>
                    <li>Le résultat de l'entretien avec le jury de sélection ( 0 à 4 points ) .</li>
                </ul>
                NB : le départage des candidats déclarés ex - aquo ; s'effectue selon l'ordre de priorité suivant:
                </div>
              @endif

          </div>
        </div>
      </div>
@endsection
