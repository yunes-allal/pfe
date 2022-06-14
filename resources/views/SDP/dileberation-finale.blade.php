@php
    $commissions = DB::table('commissions')->get();
    $session = App\Models\Session::where('status','!=','off')->first();
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        @forelse ($commissions as $item)
            @php
                $department = App\Models\Department::where('id',$item->department_id)->select('name')->first();
                $candidats = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.$item->email.'" AND dossiers.is_conformed=1 AND '.$session->id.'= dossiers.session_id ORDER BY dossiers.mark desc');
            @endphp

            <h2>Department de : {{ $department->name }}</h2>
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <tbody>
                        <tr>
                            <th>Nom et prénom</th>
                            <th>Nombres de mois</th>
                            <th>Note d'experience</th>
                            <th>Note finale</th>
                        </tr>
                        @forelse ($candidats as $candidat)
                        @php
                            $experience = App\Models\ExperiencePro::where('user_id',$candidat->user_id)->sum('ep_periode');
                            $note = App\Models\Note::where('dossier_id',$candidat->id)->select('ep_mark')->first();
                        @endphp
                        <tr>
                           <td>
                               <a data-bs-toggle="modal" data-bs-target="#Dossier{{ $candidat->id }}" class="fw-bold text-sucess">
                                   {{ $candidat->family_name }} {{ $candidat->name }}
                                </a>
                            </td>
                            <td>{{ $experience }}</td>

                            <td>
                                @if (is_float($note->ep_mark))
                                    {{ $note->ep_mark }}
                                @else
                                   <div data-bs-toggle="modal" data-bs-target="#Dossier{{ $candidat->id }}" class="btn btn-info">Noter</div>
                                @endif
                            </td>
                            <td>{{ $candidat->mark }}</td>
                        </tr>

                        <div class="modal fade" id="Dossier{{ $candidat->id }}" tabindex="-1" aria-labelledby="DossierLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <section class="m-2 p-2 lh-lg">
                                        <img class="img-thumbnail" src="/storage/users_pictures/{{ $candidat->user_picture }}" alt="">

                                        <div class="inline-block border text-center my-2 bg-light">
                                            <h3 class="p-2">1. Reseignement personnels</h3>
                                        </div>
                                        <div>Nom et prénom: <span class="fw-bold">{{ $candidat->family_name.' '.$candidat->name }}</span></div>
                                        <div>Fils de:
                                            <span class="fw-bold">
                                                @if ($candidat->father_name) {{ $candidat->father_name }} @else / @endif
                                            </span>
                                            <span class="ms-5">et de:</span>
                                            <span class="fw-bold">
                                                @if ($candidat->mother_family_name) {{ $candidat->mother_family_name }} @else @if ($candidat->mother_name) {{ ' '.$candidat->mother_name }} @else / @endif @endif
                                            </span>
                                        </div>
                                        <div>Date et lieu de naissance: <span class="fw-bold">{{ date('d-m-Y', strtotime($candidat->birth_date)) }} {{ $candidat->birthplace }}</span></div>
                                        <div>Nationalité: <span class="fw-bold">{{ $candidat->nationality }}</span></div>
                                        <div>Situation familiale: @if ($candidat->isMarried) Marié @else Célibataire @endif</div>
                                        <div>La nature de l'handicap: <span class="fw-bold">@if ($candidat->disability_type) {{ $candidat->disability_type }} @else / @endif</span></div>
                                        <div>Lieu de résidence: <span class="fw-bold">{{ $candidat->commune }} {{ $candidat->wilaya }} ( {{ $candidat->adresse }} )</span></div>
                                        <div>Numéro de téléphone: <span class="fw-bold">{{ $candidat->tel }}</span></div>
                                        @php
                                            $user = App\Models\User::where('id', $candidat->user_id)->select('email')->first();
                                        @endphp
                                        <div>Email: <span class="fw-bold">{{ $user->email }}</span></div>
                                        @if ($candidat->isMan)
                                            <div>Situation vis à vis du service national: <span class="fw-bold">{{ $candidat->national_service }}</span></div>
                                            <div>Référence du document: Numéro: <span class="fw-bold"> @if ($candidat->doc_num) {{ $candidat->doc_num }} @else / @endif</span>
                                            <span class="ms-3">Délivré le: <span class="fw-bold">@if ($candidat->doc_issued_date) {{ date('d-m-Y', strtotime($candidat->doc_issued_date)) }} @else / @endif</span></span></div>
                                        @endif
                                        <div class="inline-block border text-center my-2 mt-4 bg-light">
                                            <h3 class="p-2">2. Reseignement concernant le titre ou le diplôme obtenu</h3>
                                        </div>
                                        <div>Dénomination du diplôme: <span class="fw-bold">@if ($candidat->diploma_name=='doctorat') Doctorat @else Magister @endif</span>
                                        <span class="ms-3">Avec mention: <span class="fw-bold">{{ $candidat->diploma_mark }}</span></span>
                                        </div>
                                        <div>Filière: <span class="fw-bold">{{ $candidat->diploma_sector }}</span>
                                        <span class="ms-3">Spécialité: <span class="fw-bold">{{ $candidat->diploma_speciality }}</span></span></div>
                                        <div>Date d'obtention du diplôme: <span class="fw-bold">@if ($candidat->diploma_date) {{ date('d-m-Y', strtotime($candidat->diploma_date)) }} @else / @endif</span>
                                        <span class="ms-3">Numéro: <span class="fw-bold">@if ($candidat->diploma_number) {{ $candidat->diploma_number }} @else / @endif</span></span></div>
                                        <div>Durée de la formation pour l'obtention du diplôme: <span class="fw-bold">@if ($candidat->diploma_start_date) {{ date('d/m/Y', strtotime($candidat->diploma_start_date)) }} @else / @endif @if ($candidat->diploma_end_date) {{ ' '.date('d/m/Y', strtotime($candidat->diploma_end_date)) }} @endif</span></div>
                                        <div>Institution ayant délivré le diplôme: <span class="fw-bold">@if ($candidat->diploma_institution) {{ $candidat->diploma_institution }} @else / @endif</span></div>
                                        @if ($candidat->diploma_name=='magister')
                                            <div class="inline-block border text-center my-2 mt-4 bg-light"><h3 class="p-2">Les formations complémentaires</h3></div>
                                            <div class="row">
                                                        @php $i = 0 @endphp
                                                        @forelse (App\Models\FormationsComp::where('user_id',$candidat->user_id)->get() as $formation)
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
                                                ->where('user_id', $candidat->user_id)->get() as $article)
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
                                                ->where('user_id', $candidat->user_id)->get() as $conference)
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
                                            ->where('user_id', $candidat->user_id)->get() as $ep)
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
                                                @if ($candidat->sp_workplace) {{ $candidat->sp_workplace }} @else / @endif
                                            </span></div>
                                        <div>Date de la première nomination:
                                            <span class="fw-bold">
                                                @if ($candidat->sp_first_nomination_date) {{ date('d-m-Y',strtotime($candidat->sp_first_nomination_date)) }} @else / @endif
                                            </span></div>
                                        <div>Date de nomination dans le garde ou poste occupé actuellement:
                                            <span class="fw-bold">
                                                @if ($candidat->sp_nomination_date) {{ date('d-m-Y',strtotime($candidat->sp_nomination_date)) }} @else / @endif
                                            </span></div>
                                        <div>Catégorie:
                                            <span class="fw-bold">
                                                @if ($candidat->sp_category) {{ $candidat->sp_category }} @else / @endif
                                            </span></div>
                                        <div>Echelon:
                                            <span class="fw-bold">
                                                @if ($candidat->sp_echelon) {{ $candidat->sp_echelon }} @else / @endif
                                            </span></div>
                                        <div>Référence de l'accord de l'organisme employeur pour la participation du candidat au concours:
                                            <span class="fw-bold">
                                                @if ($candidat->sp_agreement_ref) {{ $candidat->sp_agreement_ref }} @else / @endif
                                                @if ($candidat->sp_agreement_date) {{ date('d-m-Y',strtotime($candidat->sp_agreement_date)) }} @endif
                                            </span></div>
                                        <div>L'autorité ayant pouvoir de signature:
                                            <span class="fw-bold">
                                                @if ($candidat->sp_authority) {{ $candidat->sp_authority }} @else / @endif
                                            </span></div>
                                        <div>Adresse de l'administration:
                                            <span class="fw-bold">
                                                @if ($candidat->sp_adresse) {{ $candidat->sp_adresse }} @else / @endif
                                            </span></div>
                                        <div>Tel:
                                            <span class="fw-bold">
                                                @if ($candidat->sp_tel) {{ $candidat->sp_tel }} @else / @endif
                                            </span></div>
                                        <div>Fax:
                                            <span class="fw-bold">
                                                @if ($candidat->sp_fax) {{ $candidat->sp_fax }} @else / @endif
                                            </span></div>
                                        <div>Email:
                                            <span class="fw-bold">
                                                @if ($candidat->sp_email) {{ $candidat->sp_email }} @else / @endif
                                            </span></div>
                                    </section>
                                </div>
                              </div>
                            </div>
                          </div>

                        <div class="modal fade" id="Dossier{{ $candidat->id }}" tabindex="-1" aria-labelledby="DossierLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-body">
                                  <div class="px-4 mt-3">
                                    <form method="POST" action="{{ route('update.ep.mark') }}">
                                        @csrf
                                      <div class="mb-3">
                                          <label for="">Note selon l'experience professionnelle (4pts)</label>
                                          <input name="ep_mark" type="number" value="0" min="0" max="4" class="form-control">
                                        </div>
                                        <input type="hidden" name="id" value="{{ $candidat->id }}">
                                  </div>
                                </div>
                                <div class="modal-footer border-top-0 mt-0">
                                  <button type="button" class="btn btn-ligth" data-bs-dismiss="modal">Annuler</button>
                                  <button type="submit" class="btn btn-outline-danger">Noter et terminer</button>
                                </form>
                                </div>
                              </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4">Pas des candidats</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <hr class="my-5">
        @empty

        @endforelse

    </div>
@endsection
