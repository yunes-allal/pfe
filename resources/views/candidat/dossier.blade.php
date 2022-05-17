@extends('layouts.app')

@section('content')
    <div class="container">

        <form method="POST" action="{{ route('candidat.update.dossier') }}">
            @csrf
                <div class="text-end my-3">
                    <button type="submit" class="btn btn-warning text-white">Mettre a jour</button>
                    <input type="hidden" name="id" value="{{ $dossier[0]->id }}">
                </div>

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item dropdown 	d-block d-md-none">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Les sections</a>
                        <div class="dropdown-menu">
                            <a class="nav-link dropdown-item" role="tab" data-bs-toggle="tab" href="#tab-1">Personnel</a>
                            <a class="nav-link dropdown-item" role="tab" data-bs-toggle="tab" href="#tab-2">Formations</a>
                            <a class="nav-link dropdown-item" role="tab" data-bs-toggle="tab" href="#tab-3">Experience</a>
                        </div>
                    </li>
                    <li class="nav-item d-none d-md-block "  role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab" href="#tab-1">Personnel</a></li>
                    <li class="nav-item d-none d-md-block" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-2">Diplome</a></li>
                    <li class="nav-item d-none d-md-block" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-3">Formations</a></li>
                    <li class="nav-item d-none d-md-block" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-4">Experience</a></li>
                    <li class="nav-item d-none d-md-block" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-5">Situation</a></li>
                </ul>

                <div class="tab-content"></div>
                    <div id="tab-1" class="tab-pane active" role="tabpanel">
                        <div class="card text-start">
                            <div class="card-body text-muted">
                            <!-- Section 1 - identity -->
                            <div class="py-3 pt-4">
                                <small class="px-4 mt-5 text-dark fw-bold">Identité</small>
                                <div class="row px-4 mt-2">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                    <label for="profilePicture" class="form-label px-2">Importer votre photo<sup class="text-danger"> *</sup></label>
                                    <input type="file" class="form-control" name="picture" id="picture">
                                    </div>
                                </div>
                                </div>
                                <div class="row px-4">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="name" class="form-label px-2">Nom<sup class="text-danger"> *</sup></label>
                                        <input type="text" class="form-control" name="family_name" id="family_name" value="{{ $dossier[0]->family_name }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="family name" class="form-label px-2">Prénom<sup class="text-danger"> *</sup></label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ $dossier[0]->name }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="arabic family name" class="form-label px-2">Nom en arabe<sup class="text-danger"> *</sup></label>
                                        <input type="text" class="form-control text-end" name="family_name_ar" id="family_name_ar" placeholder="اللقب باللغة العربية" value="{{ $dossier[0]->family_name_ar }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="arabic name" class="form-label px-2">Prénom en arabe<sup class="text-danger"> *</sup></label>
                                        <input type="text" class="form-control text-end" name="name_ar" id="name_ar" placeholder="الاسم باللغة العربية" value={{ $dossier[0]->name_ar }}>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-4">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="father name" class="form-label px-2">Prénom de pere<sup class="text-danger"> *</sup></label>
                                        <input type="text" class="form-control" name="father_name" id="father_name" value="{{ $dossier[0]->father_name }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="mother name" class="form-label px-2">Nom et prénom de mere<sup class="text-danger"> *</sup></label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="mother_family_name" id="mother_family_name" placeholder="nom" value="{{ $dossier[0]->mother_family_name }}">
                                        <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="prénom" value="{{ $dossier[0]->mother_name }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-4">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="date de naissance" class="form-label px-2">Date de naissance<sup class="text-danger"> *</sup></label>
                                        <input type="date" max="{{ now()->subYears(20)->format('Y-m-d') }}" class="form-control text-muted" name="birth_date" id="birth_date" value="{{ $dossier[0]->birth_date }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="lieu de naissance" class="form-label px-2">Lieu de naissance<sup class="text-danger"> *</sup></label>
                                        <input type="text" class="form-control" name="birthplace" id="birthplace" value="{{ $dossier[0]->birthplace }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                    <label for="sexe" class="form-label px-2">Sexe<sup class="text-danger"> *</sup></label>
                                    <select class="form-select" name="isMan" id="isMan" onchange="displayNationalService()">
                                        <option value="0" @if (!$dossier[0]->isMan) selected @endif >Femme</option>
                                        <option value="1" @if ($dossier[0]->isMan) selected @endif>Homme</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="nationalite" class="form-label px-2">Nationalité<sup class="text-danger"> *</sup></label>
                                        <input type="text" value="Algérienne" class="form-control text-muted" name="nationality" id="nationality" value="{{ $dossier[0]->nationality }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row px-4">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                    <label for="idCard" class="form-label px-2">Carte nationale<sup class="text-danger"> *</sup></label>
                                    <input onkeypress="return onlyNumberKey(event)" type="text" class="form-control" maxlength="18" minlength="18" name="id_card" id="id_card" value="{{ $dossier[0]->id_card }}" placeholder="numéro de carte nationale">
                                </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                    <label for="date de naissance" class="form-label px-2">Photo de la carte<sup class="text-danger"> *</sup></label>
                                    <input type="file" class="form-control" name="id_card_pic" id="id_card_pic">
                                </div>
                            </div>
                            </div>
                            </div>
                            <!-- Section 2 - situation -->
                            <div class="py-3">
                                <small class="px-4 mt-5 text-dark fw-bold">Situation</small>
                                <div class="row px-4 mt-2">
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                        <div class="mb-3">
                                        <label for="situation familiale" class="form-label px-2">Situation familiale<sup class="text-danger"> *</sup></label>
                                            <select onchange="hasChildren()" class="form-select" name="isMarried" id="isMarried">
                                            <option value="0" @if (!$dossier[0]->isMarried) selected @endif >Célibataire</option>
                                            <option value="1" @if ($dossier[0]->isMarried) selected @endif>Marie(e)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="display: none;" id="child_col" class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                        <div class="mb-3">
                                        <label for="nombre d'enfants" class="form-label px-2">Nombre d'enfants</label>
                                        <input type="number" min="0" max="15" value="{{ $dossier[0]->children_number }}" class="form-control" name="children_number" id="children_number">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                        <div class="mb-3">
                                        <label for="besoins specifiques" class="form-label px-2">Besoins spécifiques</label>
                                        <input type="text" class="form-control" name="disability_type" id="disability_type" placeholder="Nature de l'handicap" value="{{ $dossier[0]->disability_type }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 3 - residence -->
                            <div class="py-3">
                                <small class="px-4 mt-5 text-dark fw-bold">résidence</small>
                                <div class="row px-4 mt-2">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="lieu de residence" class="form-label px-2">Lieu de résidence<sup class="text-danger"> *</sup></label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="commune" id="commune" placeholder="commune" value="{{ $dossier[0]->commune }}">
                                        <input type="text" class="form-control" name="wilaya" id="wilaya" placeholder="wilaya" value="{{ $dossier[0]->wilaya }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="inputCity" class="form-label px-2">Adresse<sup class="text-danger"> *</sup></label>
                                        <input type="text" class="form-control" name="adresse" id="adresse" value="{{ $dossier[0]->adresse }}" placeholder="ex: Bat 1 Guelma , N 1">
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!-- Section 4 - contact infos -->
                            <div class="py-3">
                                <small class="px-4 mt-5 text-dark fw-bold">Contacte</small>
                                <div class="row px-4 mt-2">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label px-2">Numéro de téléphone<sup class="text-danger"> *</sup></label>
                                        <input type="tel" class="form-control" name="tel" id="tel" value="{{ $dossier[0]->tel }}" placeholder="ex: 07 77 77 77 77">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="email" class="form-label px-2">Email<sup class="text-danger"> *</sup></label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" placeholder="nom.prenom@exemple.com">
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!-- Section 5 - national service -->
                            <div style="display: none;" id="national_service_section" class="py-3 pb-4">
                                <small class="px-4 mt-5 text-dark fw-bold">Service nationale</small>
                                <div class="row px-4 mt-2">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="service national" class="form-label px-2">Service Nationale<sup class="text-danger"> *</sup></label>
                                            <select class="form-select" name="national_service" id="national_service">
                                                <option value="accompli" @if($dossier[0]->national_service == 'accompli') selected @endif>Accomplie</option>
                                                <option value="dispense" @if($dossier[0]->national_service == 'dispense') selected @endif>Exempté / Dispensé</option>
                                                <option value="sursitaire" @if($dossier[0]->national_service == 'sursitaire') selected @endif>Sursitaire</option>
                                                <option value="inscrit" @if($dossier[0]->national_service == 'inscrit') selected @endif>Inscrit</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                    <div class="mb-3">
                                    <label for="reference" class="form-label px-2">Référence</label>
                                    <input type="text" class="form-control" name="doc_num" id="doc_num" placeholder="numéro de document" value="{{ $dossier[0]->doc_num }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                    <div class="mb-3">
                                    <label for="reference" class="form-label px-2">délivré le:</label>
                                    <input type="date" max="{{ now()->format('Y-m-d') }}" class="form-control" name="doc_issued_date" id="doc_issued_date" value="{{ $dossier[0]->doc_issued_date }}">
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane" role="tabpanel">
                        <div class="card text-start p-4">
                            <div class="card-body text-muted">
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Denomination du diplome</label>
                                            <select onchange="magisterDiploma()" id="diploma_name" class="form-select" name="diploma_name">
                                            <option value="doctorat" @if($dossier[0]->diploma_name=="doctorat") selected @endif>Doctorat</option>
                                            <option value="magister" @if($dossier[0]->diploma_name=="magister") selected @endif>Magister</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Mention</label>
                                            <input type="text" class="form-control" name="diploma_mark" value="{{ $dossier[0]->diploma_mark }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Filiere</label>
                                        <input type="text" class="form-control" name="diploma_sector" value="{{ $dossier[0]->diploma_sector }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Specialite</label>
                                    <input type="text" class="form-control" name="diploma_speciality" value="{{ $dossier[0]->diploma_speciality }}">
                                </div>
                            </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Date d'obtention du diplome</label>
                                            <input type="date" class="form-control" max="{{ now()->format('Y-m-d') }}" name="diploma_date" value="{{ $dossier[0]->diploma_date }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Numero</label>
                                        <input type="text" class="form-control" name="diploma_number" value="{{ $dossier[0]->diploma_number }}">
                                    </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-12 col-md-8">
                                        <label for="" class="form-label">Duree de la formation pour obtenu le diplome</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">De</span>
                                            <input type="date" class="form-control" name="diploma_start_date" value="{{ $dossier[0]->diploma_start_date }}">
                                            <span class="input-group-text" id="basic-addon1">A</span>
                                            <input type="date" class="form-control" name="diploma_end_date" value="{{ $dossier[0]->diploma_end_date }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Institution</label>
                                            <input type="text" class="form-control" name="diploma_institution" value="{{ $dossier[0]->diploma_institution }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Magister table -->
                            <div id="magisterCase">
                                    <h5 class="p-3 display-6 mt-3 text-muted text-center">Cas de magister</h5>
                                <div class="table-responsive-lg p-3">
                                        <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Inscription au doctorat</th>
                                                <th>Spécialité</th>
                                                <th>Institution</th>
                                                <th>Numéro</th>
                                                <th>Date d'inscription</th>
                                            </tr>
                                            <tr>
                                                <td>1ère inscription</td>
                                                <td><input class="form-control" type="text" name="mag_first_speciality"></td>
                                                <td><input class="form-control" type="text" name="mag_first_institution"></td>
                                                <td><input class="form-control" type="text" name="mag_first_num"></td>
                                                <td><input class="form-control" type="date" name="mag_first_date"></td>
                                            </tr>
                                            <tr>
                                                <td>2ème inscription</td>
                                                <td><input class="form-control" type="text" name="mag_second_speciality"></td>
                                                <td><input class="form-control" type="text" name="mag_second_institution"></td>
                                                <td><input class="form-control" type="text" name="mag_second_num"></td>
                                                <td><input class="form-control" type="date" name="mag_second_date"></td>
                                            </tr>
                                            <tr>
                                                <td>3ème inscription</td>
                                                <td><input class="form-control" type="text" name="mag_third_speciality"></td>
                                                <td><input class="form-control" type="text" name="mag_third_institution"></td>
                                                <td><input class="form-control" type="text" name="mag_third_num"></td>
                                                <td><input class="form-control" type="date" name="mag_second_date"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane" role="tabpanel">
                        <div class="card text-start">
                            <div class="card-body text-muted">
                            <div class="container">
                                <p class="fw-light fst-italic mx-5 my-4">
                                Vous pouvez ajouter votre formations complémentaires au diplôme exigé dans la même spécialité (le cas échéant)
                                </p>
                                <button type="button" class="btn btn-light text-primary border mx-3 my-4" data-bs-toggle="modal" data-bs-target="#ajouterFormation">
                                <i data-feather="plus-circle"></i> Ajouter
                            </button>
                            </div>


                            <!-- Modal -->
                            <div class="modal fade" id="ajouterFormation" tabindex="-1" aria-labelledby="ajouterFormationLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Nouveau formation complémentaire</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="container px-3 py-3">
                                        <div class="row gy-3">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 px-2 py-2">
                                            <div class="mb-3">
                                            <label for="nature de diplome" class="form-label">Nature du diplôme</label>
                                            <input type="text" class="form-control" name="fc_diploma" id="fc_diploma">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 px-2 py-2">
                                            <div class="mb-3">
                                            <label for="filiere" class="form-label">Filière</label>
                                            <input type="text" class="form-control" name="fc_field" id="fc_field">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 px-2 py-2">
                                            <div class="mb-3">
                                            <label for="specialite" class="form-label">Spécialité</label>
                                            <input type="text" class="form-control" name="fc_major" id="fc_major">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 px-2 py-2">
                                            <div class="mb-3">
                                            <label for="etablissement d'origine" class="form-label">Établissement d'origine</label>
                                            <input type="text" class="form-control" name="fc_origin" id="fc_origin" aria-describedby="hint1">
                                            <small id="hint1" class="form-text text-muted">Institution ayant délivré le diplôme</small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 px-2 py-2">
                                            <div class="mb-3">
                                            <label for="numero de diplome" class="form-label">Numéro de diplôme</label>
                                            <input type="text" class="form-control" name="fc_diploma_ref" id="fc_diploma_ref">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 px-2 py-2">
                                            <div class="mb-3">
                                            <label for="date de delivrance" class="form-label">Date de délivrance de diplôme</label>
                                            <input type="date" class="form-control" name="fc_diploma_date" id="fc_diploma_date">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 px-2 pb-2">
                                            <div class="mb-3">
                                            <label for="debut de formation" class="form-label">Debut de la formation</label>
                                            <input type="date" class="form-control" name="fc_start_date" id="fc_start_date">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 px-2 pb-2">
                                            <div class="mb-3">
                                            <label for="fin de formation" class="form-label">Fin de la formation</label>
                                            <input type="date" class="form-control" name="fc_end_date" id="fc_end_date">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 px-2 pb-2">
                                            <div class="mb-3">
                                            <label for="inscription de Phd" class="form-label">Inscription au doctorat</label>
                                            <input type="date" class="form-control" name="fc_phd_register_date" id="fc_phd_register_date">
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                                    <button type="button" class="btn btn-primary">Ajouter</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane" role="tabpanel">
                        <div class="card text-start">
                            <div class="card-body text-muted">
                            <div class="container">
                                <p class="fw-light fst-italic mx-5 my-4">
                                Vous pouvez ajouter votre expériences professionnelle (le cas échéant)
                                </p>

                                <button type="button" class="btn btn-light text-primary border mx-3 my-4" data-bs-toggle="modal" data-bs-target="#ajouterExperience">
                                Ajouter</button>
                            </div>

                            <div class="mt-5">
                                @forelse (Illuminate\Support\Facades\DB::table('experience_pros')
                                            ->where('dossier_id', $dossier[0]->id)->get() as $item)
                                    <table class="table">
                                        <tbody class="text-muted">
                                            <tr>
                                                <th>Denomiation de l'administration ou de l'insitution (organisme d'emplyeur)</th>
                                                <th style="max-width: 15vw">Fonction ou poste de travail occupe</th>
                                                <th style="max-width: 20vw">Periode</th>
                                                <th style="max-width: 15vw">attestation de travail ou contrat</th>
                                                <th style="max-width: 15vw">motif de la rupture de la relation de travail</th>
                                                <th style="max-width: 15vw">supprimer</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $item->ep_institution }}</td>
                                                <td style="max-width: 15vw">{{ $item->ep_workplace }}</td>
                                                <td>{{ date('d/m/Y', strtotime($item->ep_start_date)) }} - {{ date('d/m/Y', strtotime($item->ep_end_date)) }}</td>
                                                <td style="max-width: 15vw">{{ $item->ep_work_certificate_ref }} <br> {{ date('d/m/Y', strtotime($item->ep_work_certificate_date)) }}</td>
                                                <td style="max-width: 15vw">{{ $item->ep_mark }}</td>
                                                <td style="max-width: 15vw"><div class="btn btn-danger">supprimer</div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @empty
                                    <div class="mx-4 text-muted">Pas des experiences declarees</div>
                                @endforelse
                            </div>

                            </div>
                        </div>

                    </div>
                    <div id="tab-5" class="tab-pane" role="tabpanel">
                            <div class="card text-start">
                            <div class="card-body text-muted">
                                <div class="row px-4 gy-3">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="denomination" class="form-label px-2">Dénomination de garde occupé</label>
                                        <input type="text" class="form-control" name="sp_workplace" id="sp_workplace" value="{{ $dossier[0]->sp_workplace }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="date" class="form-label px-2">Date de la première nomination</label>
                                        <input type="date" class="form-control" name="sp_first_nomination_date" id="sp_first_nomination_date" value="{{ $dossier[0]->sp_first_nomination_date }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="date" class="form-label px-2">Date de nomination de poste actuelle</label>
                                        <input type="date" class="form-control" name="sp_nomination_date" id="sp_nomination_date" value="{{ $dossier[0]->sp_nomination_date }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="category" class="form-label px-2">Catégorie</label>
                                        <input type="text" class="form-control" name="sp_category" id="sp_category" value="{{ $dossier[0]->sp_category }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="echelon" class="form-label px-2">Echelon</label>
                                        <input type="text" class="form-control" name="sp_echelon" id="sp_echelon" value="{{ $dossier[0]->sp_echelon }}">
                                    </div>
                                    </div>
                                    <div class="col-12 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="category" class="form-label px-2">Référence de l'accord de l'organisme employeur pour la participation du candidat au concours</label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="sp_agreement_ref" id="sp_agreement_ref" placeholder="Numéro" value="{{ $dossier[0]->sp_agreement_ref }}">
                                        <input type="date" class="form-control" name="sp_agreement_date" id="sp_agreement_date" value="{{ $dossier[0]->sp_agreement_date }}">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label class="form-label px-2">L'autorité ayant pouvoir de signature</label>
                                        <input type="text" class="form-control" name="sp_authority" id="sp_authority" value="{{ $dossier[0]->sp_authority }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="adresse" class="form-label px-2">Adresse de l'administration</label>
                                        <input type="text" class="form-control" name="sp_adresse" id="sp_adresse" value="{{ $dossier[0]->sp_adresse }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label px-2">Tel</label>
                                        <input type="tel" class="form-control" name="sp_tel" id="sp_tel" value="{{ $dossier[0]->sp_tel }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label px-2">Fax</label>
                                        <input type="tel" class="form-control" name="sp_fax" id="sp_fax" value="{{ $dossier[0]->sp_fax }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="email" class="form-label px-2">Email</label>
                                        <input type="email" class="form-control" name="sp_email" id="sp_email" placeholder="company@example.com" value="{{ $dossier[0]->sp_email }}">
                                    </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
        </form>
    </div>

        {{-- Modals --}}
        <form action="{{ route('experience.store') }}" method="POST">
            @csrf
          <!-- Modal -->
          <div class="modal fade" id="ajouterExperience" tabindex="-1" aria-labelledby="ajouterExperienceLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Nouveau expérience professionnelle</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="container px-3 py-3">
                    <div class="row gy-3">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 py-2">
                        <div class="mb-3">
                          <label for="nom d'institution" class="form-label">Dénomination de l'institution</label>
                          <input type="text" class="form-control" name="ep_institution" id="ep_institution" aria-describedby="hint1">
                          <small id="hint1" class="form-text text-muted">institution ou administration</small>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 py-2">
                        <div class="mb-3">
                          <label for="filiere" class="form-label">Poste de travail occupé</label>
                          <input type="text" class="form-control" name="ep_workplace" id="ep_workplace">
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 pb-2">
                        <div class="mb-3">
                          <label class="form-label">Date de debut</label>
                          <input type="date" class="form-control" name="ep_start_date" id="ep_start_date">
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 pb-2">
                        <div class="mb-3">
                          <label class="form-label">Date de fin</label>
                          <input type="date" class="form-control" name="ep_end_date" id="ep_end_date">
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 py-2">
                        <div class="mb-3">
                          <label class="form-label">Numéro d'attestation de travail</label>
                          <input type="text" class="form-control" name="ep_work_certificate_ref" id="ep_work_certificate_ref">
                          <small id="hint2" class="form-text text-muted">Attestation ou contrat</small>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 py-2">
                        <div class="mb-3">
                          <label class="form-label">Date d'attestation de travail</label>
                          <input type="date" class="form-control" name="ep_work_certificate_date" id="ep_work_certificate_date">
                        </div>
                      </div>
                      <div class="mb-3">
                        <textarea class="form-control" name="ep_mark" id="ep_mark" rows="3" placeholder="Motif de la rupture de la relation de travail"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="dossier_id" value="{{ $dossier[0]->id }}">
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                  <button type="submit" name="add_exp" class="btn btn-primary">Ajouter</button>
                </div>
              </div>
            </div>
          </div>
        </form>

    <script>
        if(document.getElementById("isMarried").value == "1"){
        document.getElementById("child_col").style.display = 'block';
        }else{
            document.getElementById("child_col").style.display = 'none';
        }
        if(document.getElementById("isMan").value == "1"){
        document.getElementById("national_service_section").style.display = 'block';
        }else{
            document.getElementById("national_service_section").style.display = 'none';
        }
        if(document.getElementById("diploma_name").value == "magister"){
            document.getElementById("magisterCase").style.display = 'block';
        }else{
            document.getElementById("magisterCase").style.display = 'none';
        }

        function hasChildren(){
            if(document.getElementById("isMarried").value == "1"){
                document.getElementById("child_col").style.display = 'block';
            }else{
                document.getElementById("child_col").style.display = 'none';
                document.getElementById("children_number").value = '0';
            }
        }

        function displayNationalService(){
            if(document.getElementById("isMan").value == "1"){
                document.getElementById("national_service_section").style.display = 'block';
            }else{
                document.getElementById("national_service_section").style.display = 'none';
            }
        }

        function magisterDiploma(){
            if(document.getElementById("diploma_name").value == "magister"){
            document.getElementById("magisterCase").style.display = 'block';
            }else{
                document.getElementById("magisterCase").style.display = 'none';
            }
        }

        function onlyNumberKey(evt) {
            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>
@endsection
