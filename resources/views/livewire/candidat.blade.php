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
                            <td data-bs-toggle='modal' data-bs-target='#Dossier{{ $item->id }}' class="text-success fw-bold">{{ $item->family_name }} {{ $item->name }}</td>
                            <td>{{ $item->diploma_speciality }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                        </tr>
                        <div class="modal fade" id="Dossier{{ $item->id }}" tabindex="-1" aria-labelledby="DossierLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <section class="m-2 p-2 lh-lg">
                                        <img class="img-thumbnail" src="/storage/users_pictures/{{ $item->user_picture }}" alt="">

                                        <div class="inline-block border text-center my-2 bg-light">
                                            <h3 class="p-2">1. Reseignement personnels</h3>
                                        </div>
                                        <div>Nom et prénom: <span class="fw-bold">{{ $item->family_name.' '.$item->name }}</span></div>
                                        <div>Fils de:
                                            <span class="fw-bold">
                                                @if ($item->father_name) {{ $item->father_name }} @else / @endif
                                            </span>
                                            <span class="ms-5">et de:</span>
                                            <span class="fw-bold">
                                                @if ($item->mother_family_name) {{ $item->mother_family_name }} @else @if ($item->mother_name) {{ ' '.$item->mother_name }} @else / @endif @endif
                                            </span>
                                        </div>
                                        <div>Date et lieu de naissance: <span class="fw-bold">{{ date('d-m-Y', strtotime($item->birth_date)) }} {{ $item->birthplace }}</span></div>
                                        <div>Nationalité: <span class="fw-bold">{{ $item->nationality }}</span></div>
                                        <div>Situation familiale: @if ($item->isMarried) Marié @else Célibataire @endif</div>
                                        <div>La nature de l'handicap: <span class="fw-bold">@if ($item->disability_type) {{ $item->disability_type }} @else / @endif</span></div>
                                        <div>Lieu de résidence: <span class="fw-bold">{{ $item->commune }} {{ $item->wilaya }} ( {{ $item->adresse }} )</span></div>
                                        <div>Numéro de téléphone: <span class="fw-bold">{{ $item->tel }}</span></div>
                                        @php
                                            $user = App\Models\User::where('id', $item->user_id)->select('email')->first();
                                        @endphp
                                        <div>Email: <span class="fw-bold">{{ $user->email }}</span></div>
                                        @if ($item->isMan)
                                            <div>Situation vis à vis du service national: <span class="fw-bold">{{ $item->national_service }}</span></div>
                                            <div>Référence du document: Numéro: <span class="fw-bold"> @if ($item->doc_num) {{ $item->doc_num }} @else / @endif</span>
                                            <span class="ms-3">Délivré le: <span class="fw-bold">@if ($item->doc_issued_date) {{ date('d-m-Y', strtotime($item->doc_issued_date)) }} @else / @endif</span></span></div>
                                        @endif
                                        <div class="inline-block border text-center my-2 mt-4 bg-light">
                                            <h3 class="p-2">2. Reseignement concernant le titre ou le diplôme obtenu</h3>
                                        </div>
                                        <div>Dénomination du diplôme: <span class="fw-bold">@if ($item->diploma_name=='doctorat') Doctorat @else Magister @endif</span>
                                        <span class="ms-3">Avec mention: <span class="fw-bold">{{ $item->diploma_mark }}</span></span>
                                        </div>
                                        <div>Filière: <span class="fw-bold">{{ $item->diploma_sector }}</span>
                                        <span class="ms-3">Spécialité: <span class="fw-bold">{{ $item->diploma_speciality }}</span></span></div>
                                        <div>Date d'obtention du diplôme: <span class="fw-bold">@if ($item->diploma_date) {{ date('d-m-Y', strtotime($item->diploma_date)) }} @else / @endif</span>
                                        <span class="ms-3">Numéro: <span class="fw-bold">@if ($item->diploma_number) {{ $item->diploma_number }} @else / @endif</span></span></div>
                                        <div>Durée de la formation pour l'obtention du diplôme: <span class="fw-bold">@if ($item->diploma_start_date) {{ date('d/m/Y', strtotime($item->diploma_start_date)) }} @else / @endif @if ($item->diploma_end_date) {{ ' '.date('d/m/Y', strtotime($item->diploma_end_date)) }} @endif</span></div>
                                        <div>Institution ayant délivré le diplôme: <span class="fw-bold">@if ($item->diploma_institution) {{ $item->diploma_institution }} @else / @endif</span></div>
                                        @if ($item->diploma_name=='magister')
                                            <div class="inline-block border text-center my-2 mt-4 bg-light"><h3 class="p-2">Les formations complémentaires</h3></div>
                                            <div class="row">
                                                        @php $i = 0 @endphp
                                                        @forelse (App\Models\FormationsComp::where('user_id',$item->user_id)->get() as $formation)
                                                        @php $i++ @endphp
                                                        <div class="col-12 col-md-4 card">
                                                            <span>Inscription: <span class="fw-bold">{{ $i }}</span></span>
                                                            <span>Spécialité: <span class="fw-bold">{{ $formation->fc_speciality }}</span> </span>
                                                            <span>Institution: <span class="fw-bold">{{ $formation->fc_institution }}</span></span>
                                                            <span>Numéro: <span class="fw-bold">{{ $formation->fc_number }}</span></span>
                                                            <span>Date d'inscription: <span class="fw-bold">{{ $formation->fc_inscritpion_date }}</span></span>
                                                        </div>
                                                        @empty
                                                            <div class="text-center fw-bold">
                                                                Pas des formations déclarées
                                                            </div>
                                                        @endforelse
                                            </div>
                                        @endif
                                        <div class="inline-block border text-center my-2 mt-4 bg-light">
                                            <h3 class="p-2">3. Reseignement sur les travaux ou études réalisés</h3>
                                        </div>
                                        <small class="fw-bold">Les revues</small>
                                        <div class="row">
                                                @forelse (Illuminate\Support\Facades\DB::table('articles')
                                                ->where('user_id', $item->user_id)->get() as $article)
                                                <div class="card col-12 col-md-6 p-3">
                                                    <div class="card-body">
                                                        <li class="fw-bold">Type: <span class="fw-normal">
                                                            Revue
                                                            @php
                                                                $article->is_international?print('internationale'):print('nationale');
                                                            @endphp
                                                        </span></li>
                                                        <li class="fw-bold">Titre: <span class="fw-normal">
                                                            @php
                                                                $article->article_title?print($article->article_title):print('-');
                                                            @endphp
                                                        </span></li>
                                                        <li class="fw-bold">Revue: <span class="fw-normal">
                                                            @php
                                                                $article->article?print($article->article):print('-');
                                                            @endphp
                                                        </span></li>
                                                        <li class="fw-bold">Année: <span class="fw-normal">
                                                            @php
                                                                $article->article_date?print($article->article_date):print('-');
                                                            @endphp
                                                        </span></li>
                                                        <li class="fw-bold">Catégorie: <span class="fw-normal">
                                                            @php
                                                                $article->article_category?print($article->article_category):print('-');
                                                            @endphp
                                                        </span></li>
                                                        <li class="fw-bold">URL: <span class="fw-normal">
                                                            @php
                                                                $article->article_link?print($article->article_link):print('-');
                                                            @endphp
                                                        </span></li>
                                                        <li class="fw-bold">PDF: <span class="fw-normal">
                                                            @if ($article->article_file)
                                                            <div style="max-width: 150px;" class="text-truncate">
                                                            <a target="_blank" class="link link-info fw-bold mt-2" href="{{route('getArticle', $article->article_file)}}">{{ $article->article_file }}</a>
                                                            </div>
                                                            @else
                                                                -
                                                            @endif
                                                        </span></li>
                                                    </div>
                                                </div>
                                                @empty
                                                    <div class="text-start px-3">
                                                        <small class="fw-bold text-danger">La liste des revues est vide</small>
                                                    </div>
                                                @endforelse
                                        </div>
                                        <small class="fw-bold">Les conférences</small>
                                        <div class="row">
                                                @forelse (Illuminate\Support\Facades\DB::table('conferences')
                                                ->where('user_id', $item->user_id)->get() as $conference)
                                                <div class="card col-12 col-md-6 p-3">
                                                    <div class="card-body">
                                                        <li class="fw-bold">Type:
                                                            <span class="fw-normal">
                                                                @php
                                                                    $conference->is_international?print('internationale'):print('nationale');
                                                                @endphp
                                                            </span>
                                                        </li>
                                                        <li class="fw-bold">Nom de conférence:
                                                            <span class="fw-normal">
                                                                @php
                                                                    $conference->conference_name?print($conference->conference_name):print('-');
                                                                @endphp
                                                            </span>
                                                        </li>
                                                        <li class="fw-bold">Lieu de conférence:
                                                            <span class="fw-normal">
                                                                @php
                                                                    $conference->conference_place?print($conference->conference_place):print('-');
                                                                @endphp
                                                            </span>
                                                        </li>
                                                        <li class="fw-bold">Date de conférence:
                                                            <span class="fw-normal">
                                                                @php
                                                                    $conference->conference_date?print(date('d/m/Y', strtotime($conference->conference_date))):print('-');
                                                                @endphp
                                                            </span>
                                                        </li>
                                                        <li class="fw-bold">Titre de conférence:
                                                            <span class="fw-normal">
                                                                @php
                                                                    $conference->communication_title?print($conference->communication_title):print('-');
                                                                @endphp
                                                            </span>
                                                        </li>
                                                        <li class="fw-bold">Auteurs de conférence:
                                                            <span class="fw-normal">
                                                                @php
                                                                    $conference->conference_authors?print($conference->conference_authors):print('-');
                                                                @endphp
                                                            </span>
                                                        </li>
                                                        <li class="fw-bold">URL:
                                                            <span class="fw-normal">
                                                                @php
                                                                    $conference->conference_link?print($conference->conference_link):print('-');
                                                                @endphp
                                                            </span>
                                                        </li>
                                                        <li class="fw-bold">Attestation:
                                                            <span class="fw-normal">
                                                                <div style="max-width: 150px;" class="text-truncate">
                                                                    <a target="_blank" class="link link-info fw-bold mt-2" href="{{route('getCertificate', $conference->certificate)}}">{{ $conference->certificate }}</a>
                                                                </div>
                                                            </span>
                                                        </li>
                                                    </div>
                                                </div>
                                                @empty
                                                    <div class="text-start px-3">
                                                        <small class="fw-bold text-danger">La liste des conférences est vide</small>
                                                    </div>
                                                @endforelse
                                        </div>
                                        <div class="inline-block border text-center my-2 mt-4 bg-light">
                                            <h3 class="p-2">4. Reseignement concerant l'expérience professionnelle</h3>
                                        </div>
                                        <div class="row">
                                            @forelse (Illuminate\Support\Facades\DB::table('experience_pros')
                                            ->where('user_id', $item->user_id)->get() as $ep)
                                            <div class="card col-12 col-md-6 p-3">
                                                <div class="card-body">
                                                    <li class="fw-bold">Insitution:
                                                        <span class="fw-normal">
                                                            @php
                                                                $ep->ep_institution?print($ep->ep_institution):print('-');
                                                            @endphp
                                                        </span>
                                                    </li>
                                                    <li class="fw-bold">Poste de travail:
                                                        <span class="fw-normal">
                                                            @php
                                                                $ep->ep_workplace?print($ep->ep_workplace):print('-');
                                                            @endphp
                                                        </span>
                                                    </li>
                                                    <li class="fw-bold">Période:
                                                        <span class="fw-normal">
                                                            @php
                                                                $ep->ep_periode?print($ep->ep_periode):print('-');
                                                            @endphp
                                                         mois</span>
                                                    </li>
                                                    <li class="fw-bold">Attestation de travail:
                                                        <span class="fw-normal">
                                                            @php
                                                                $ep->ep_work_certificate_ref?print($ep->ep_work_certificate_ref):print('');
                                                            @endphp
                                                            (
                                                                @php
                                                                    $ep->ep_work_certificate_date?print(date('d/m/Y', strtotime($ep->ep_work_certificate_date))):print('');
                                                                @endphp
                                                            )
                                                        </span>
                                                    </li>
                                                    <li class="fw-bold">motif de la rupture:
                                                        <span class="fw-normal">
                                                            @php
                                                                $ep->ep_mark?print($ep->ep_mark):print('-');
                                                            @endphp
                                                        </span>
                                                    </li>
                                                </div>
                                            </div>
                                            @empty
                                                <div class="text-start px-3">
                                                    <small class="fw-bold text-danger">La liste des expériences est vide</small>
                                                </div>
                                            @endforelse
                                        </div>
                                        <div class="inline-block border text-center my-2 mt-4 bg-light">
                                            <h3 class="p-2">5. Reseignement concerant la situation professionnelle actuelle</h3>
                                        </div>
                                        <div>Dénomination de la fonction ou garde occupé à la date de participation au concours:
                                            <span class="fw-bold">
                                                @if ($item->sp_workplace) {{ $item->sp_workplace }} @else / @endif
                                            </span></div>
                                        <div>Date de la première nomination:
                                            <span class="fw-bold">
                                                @if ($item->sp_first_nomination_date) {{ date('d-m-Y',strtotime($item->sp_first_nomination_date)) }} @else / @endif
                                            </span></div>
                                        <div>Date de nomination dans le garde ou poste occupé actuellement:
                                            <span class="fw-bold">
                                                @if ($item->sp_nomination_date) {{ date('d-m-Y',strtotime($item->sp_nomination_date)) }} @else / @endif
                                            </span></div>
                                        <div>Catégorie:
                                            <span class="fw-bold">
                                                @if ($item->sp_category) {{ $item->sp_category }} @else / @endif
                                            </span></div>
                                        <div>Echelon:
                                            <span class="fw-bold">
                                                @if ($item->sp_echelon) {{ $item->sp_echelon }} @else / @endif
                                            </span></div>
                                        <div>Référence de l'accord de l'organisme employeur pour la participation du candidat au concours:
                                            <span class="fw-bold">
                                                @if ($item->sp_agreement_ref) {{ $item->sp_agreement_ref }} @else / @endif
                                                @if ($item->sp_agreement_date) {{ date('d-m-Y',strtotime($item->sp_agreement_date)) }} @endif
                                            </span></div>
                                        <div>L'autorité ayant pouvoir de signature:
                                            <span class="fw-bold">
                                                @if ($item->sp_authority) {{ $item->sp_authority }} @else / @endif
                                            </span></div>
                                        <div>Adresse de l'administration:
                                            <span class="fw-bold">
                                                @if ($item->sp_adresse) {{ $item->sp_adresse }} @else / @endif
                                            </span></div>
                                        <div>Tel:
                                            <span class="fw-bold">
                                                @if ($item->sp_tel) {{ $item->sp_tel }} @else / @endif
                                            </span></div>
                                        <div>Fax:
                                            <span class="fw-bold">
                                                @if ($item->sp_fax) {{ $item->sp_fax }} @else / @endif
                                            </span></div>
                                        <div>Email:
                                            <span class="fw-bold">
                                                @if ($item->sp_email) {{ $item->sp_email }} @else / @endif
                                            </span></div>
                                    </section>
                                </div>
                              </div>
                            </div>
                          </div>
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

