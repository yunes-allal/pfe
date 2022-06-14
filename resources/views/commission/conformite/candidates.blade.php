@php
$session = Illuminate\Support\Facades\DB::table('sessions')->where('status','!=','off')->select('id')->first();
$candidates = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.is_validated = 1 AND dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.Auth::user()->email.'" AND dossiers.session_id='.$session->id.' ORDER BY is_conformed');
$commission = App\Models\Commission::where('email',Auth::user()->email)->select('conformity_members')->first();

@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="display-3">Liste des candidat</div>
    <div class="inline-block text-end px-4 mx-4">
        <div class="dropdown">
            <a class="btn btn-info dropdown-toggle @if (!$commission->conformity_members) disabled @endif" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-print"></i> Générer PV
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <li><a target="_blank" class="dropdown-item text-success fw-bold" href="{{ route('pv.conforme') }}">Les candidats acceptés</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a target="_blank" class="dropdown-item text-danger fw-bold" href="{{ route('pv.non.conforme') }}">Les candidats rejetés</a></li>
            </ul>
          </div>
    </div>

    <h5 class="mx-4 mt-2 text-muted"><strong>Les membres de cette commission</strong></h5>
    @if (!$commission->conformity_members)
    <form action="{{ route('update.members') }}" method="POST"  class="row gx-4 gy-4 mx-4 text-center">
        @csrf
        <div class="col-12 col-md-3">
            <input type="text" name="member1" class="form-control" placeholder="Nom du membre 1">
        </div>
        <div class="col-12 col-md-3">
            <input type="text" name="member2" class="form-control" placeholder="Nom du membre 2">
        </div>
        <div class="col-12 col-md-3">
            <input type="text" name="member3" class="form-control" placeholder="Nom du membre 3">
        </div>
        <div class="col-12 col-md-3">
            <button type="submit" class="btn btn-info">Envoyer</button>
        </div>
    </form>
    @else
    <div class="mx-5">{!! $commission->conformity_members !!}</div>
    @endif

    <div class="table-responsive border p-4 m-4">
        <table class="table table-bordered text-center">
            <tbody>
                <tr>
                    <th>Nom et prénom</th>
                    <th width="33%">Specialité</th>
                    <th width="30%">Conformité</th>
                </tr>
                @forelse ($candidates as $item)
                    <tr>
                        <td class="fw-bold link-info" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#Dossier{{ $item->id }}">
                            {{ $item->family_name.' '.$item->name }}
                        </td>
                        <td>{{ $item->diploma_speciality }}</td>
                        <td>
                            @if ($item->is_conformed)
                                @if ($item->is_conformed=="1")
                                    <div class="fw-bold text-success">
                                        <i class="fas fa-check"></i> Conforme
                                    </div>
                                @else
                                <div class="fw-bold text-danger">
                                    <i class="fas fa-times"></i> Non conforme
                                </div>
                                @endif
                            @else
                                <button class="@if (!$commission->conformity_members) disabled @endif m-2 btn btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#Conforme{{ $item->id }}">Conforme</button>
                                <button class="@if (!$commission->conformity_members) disabled @endif m-2 btn btn-outline-danger fw-bold" data-bs-toggle="modal" data-bs-target="#NonConforme{{ $item->id }}">Non-conforme</button>
                            @endif

                        </td>
                    </tr>



                    <!-- Modal -->
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

                    <div class="modal fade" id="Conforme{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ConformeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class=" fs-5">
                                    Le dossier de {{ $item->family_name.' '.$item->name }} est-il conforme ?
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light fw-bold" data-bs-dismiss="modal">Non, annuler</button>
                                <form action="{{ route('dossier.conformed') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                                    <input type="hidden" name="dossier_id" value="{{ $item->id }}">
                                    <input type="hidden" name="decision" value="1">
                                    <button type="submit" class="btn btn-success text-white fw-bold">Oui, je suis sûr</button>
                                </form>

                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="modal fade" id="NonConforme{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="NonConformeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('dossier.conformed') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="fs-5">
                                        Le dossier de {{ $item->family_name.' '.$item->name }} est-il pas conforme ?
                                        <label for="Cause" class="p-2 mt-3 text-muted fs-6">Pourquoi? (en arabe)</label>
                                        <input class="form-control" value="مرفوض لعدم تطابق التخصص" minlength="5" name="decision" list="datalistOptions" id="exampleDataList" placeholder="ذكر السبب باللغة العربية">
                                        <datalist id="datalistOptions">
                                            <option value="مرفوض لعدم تطابق التخصص">
                                            <option value="مرفوض لعدم تطابق الشعبة">
                                        </datalist>
                                    </div>
                                    <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Non, annuler</button>
                                    <button type="submit" class="btn btn-danger fw-bold">Oui, je suis sûr</button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td class="text-center fw-bold text-muted" colspan="4">
                            <img class="img-fluid w-25" src="{{ asset('assets/images/empty-box.png') }}" alt="empty box">
                            <p>Liste des candidat est vide</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
