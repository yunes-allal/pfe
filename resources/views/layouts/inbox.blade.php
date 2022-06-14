@php
    $messages = App\Models\Message::where('sent_to', $user)->orderBy('created_at', 'desc')->get();
@endphp

@extends('layouts.app')

@section('content')
    <div class="container my-5">
        @foreach ($messages as $message)
        <hr class="my-4">
        <header>
            <i class="far fa-envelope fs-5 text-muted mx-3"></i>
            <span class="fw-bold fs-5">
            @if ($message->subject == 'conforme' || $message->subject == 'non-conforme')
                Etat de dossier (conformité)
            @else
                @if ($message->subject == 'recours')
                    Demande de recours
                @else
                    {{ $message->subject }}
                @endif
            @endif
            </span>
            @php
                Carbon\Carbon::setLocale('fr');
                $date = Carbon\Carbon::parse($message->created_at);
            @endphp
            <small class="text-muted fw-light mx-3">{{ $date->format('j F Y H:i') }}</small>
        </header>


        <section class="mx-3 px-5 my-3">


            {!! str_replace("#", "<br>", $message->body) !!}

            {{--! Pour le candidat --}}
            @if ($message->subject == 'non-conforme')
                @if (App\Models\Message::where('user_id',Auth::id())->where('subject','recours')->count())
                <div class="my-3">
                    <a class="btn btn-sm btn-success text-white fw-bold disabled">
                        <i class="fas fa-check"></i> Demande de recours a été envoyée
                    </a>
                </div>
                @else
                <div class="my-3">
                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#recours">
                        <i class="fas fa-paper-plane me-2"></i> Envoyer un recours
                    </a>
                </div>
                @endif
            @endif

            {{--! Pour le SDP --}}
            @if ($message->subject == 'recours' && !$message->is_replied)
                <div class="my-3">
                    @php
                        $dossier = App\Models\Dossier::where('user_id',$message->user_id)->first();
                        $item = $dossier;
                    @endphp

                    <button data-bs-toggle="modal" data-bs-target="#ApercuDossier" class="btn btn-sm btn-outline-info w-25">Apercu sur le dossier</button>

                    <div class="modal fade" id="ApercuDossier" tabindex="-1" aria-labelledby="ApercuDossierLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
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
                    <form class="my-3" action="{{ route('dossier.conformed') }}" method="POST">
                        @csrf
                        <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                        <input type="hidden" name="user_id" value="{{ $message->user_id }}">
                        <input type="hidden" name="decision" value="1">
                        <button type="submit" class="btn btn-sm fw-bold text-white btn-success">Accepter</button>
                    </form>
                    <form class="my-3" action="{{ route('dossier.conformed') }}" method="POST">
                        @csrf
                        <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                        <input type="hidden" name="user_id" value="{{ $message->user_id }}">
                        <input type="hidden" name="decision" value="{{ $dossier->is_conformed }}">
                        <button type="submit" class="btn btn-sm fw-bold btn-danger">Rejeter</button>
                    </form>
                </div>
            @endif
        </section>


        <footer class="mx-3 px-5 fw-bold">
            Cordialement,<br>
            @php
                $sent_from = App\Models\User::where('id', $message->user_id)->select('name')->first();
            @endphp
            {{ $sent_from->name }}.
        </footer>
        @endforeach
        <hr class="my-4">
    </div>


    {{-- MODALS --}}
<div class="modal fade" id="recours" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="recoursLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="recoursLabel">Envoyer un demande de recours</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="alert alert-danger">
               <b>Attention,</b> tu peut demander de faire un recours une seule fois!
            </div>

            @php
                $sdp = App\Models\User::where('type', 'sdp')->select('id')->first();
            @endphp
            <form method="POST" action="{{ route('send.message') }}">
                @csrf
            @if ($sdp)
                <input type="hidden" name="sent_to" value="{{ $sdp->id }}">
            @endif
            <input type="hidden" name="subject" value="recours">
          <div class="mb-3">
            <label for="" class="form-label fw-bold">La demande de recours</label>
            <textarea class="form-control" name="body" id="body" rows="3" placeholder="Tapez votre demande ici.."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Envoyer</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection
