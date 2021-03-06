@php
    //if($errors->any()){dd($errors);}
    $dossier = Illuminate\Support\Facades\DB::table('dossiers')->where('user_id', Auth::id())->first();
    $current_tab = $dossier->current_tab;


    $session = Illuminate\Support\Facades\DB::table('sessions')->where('status','!=', 'off')->first();
    $besoins = [];
    $modification_available = false;
    if($session){
        $besoins = Illuminate\Support\Facades\DB::table('besoins')->where('session_id',$session->id)->get();
        if($session->status == 'inscription' && now() < $session->end_date && !$dossier->is_validated){
            $modification_available = true;
        }else{
            $modification_available = false;
        }
    }

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
    <div class="container">
        <div class="text-center">
            @if ($errors->any())
                <div class="alert alert-danger fw-bold fs-3">
                    <i class="fas fa-exclamation-circle fs-1"></i><br>
                    Vous devez remplir tous les champs obligatoires avant de valider votre dossier.
                </div>
            @endif
        </div>
        <form method="POST" action="{{ route('candidat.update.dossier') }}" enctype="multipart/form-data">
            @csrf
                <div class="text-center text-md-end my-3">
                    @if ($modification_available)
                    <button type="submit" class="btn btn-warning text-white fw-bold">Mettre a jour</button>
                    @if (!$dossier->is_validated)
                        <button data-bs-toggle="modal" data-bs-target="#validateDossier" type="button" class="btn btn-outline-secondary fw-bold">Valider</button>
                    @endif

                    @endif
                    <input type="hidden" name="id" value="{{ $dossier->id }}">
                    <input type="hidden" id="current_tab" name="current_tab" value="{{ $current_tab }}">
                </div>
                <ul id="tabs" class="nav nav-tabs fw-bold" role="tablist">
                    <li onclick='changeTab(1)' class="nav-item"  role="presentation"><a class="nav-link" id="nav-link-1" role="tab" data-bs-toggle="tab" href="#tab-1" data-bs-toggle="tooltip" title="Personnel"><div class="d-block d-md-none">1</div><div class="d-none d-md-block">Personnel</div></a></li>
                    <li onclick='changeTab(2)' class="nav-item" role="presentation"><a class="nav-link" id="nav-link-2" role="tab" data-bs-toggle="tab" href="#tab-2" data-bs-toggle="tooltip" title="Dipl??me"><div class="d-block d-md-none">2</div><div class="d-none d-md-block">Dipl??me</div></a></li>
                    <li onclick='changeTab(3)' class="nav-item" role="presentation"><a class="nav-link" id="nav-link-3" role="tab" data-bs-toggle="tab" href="#tab-3" data-bs-toggle="tooltip" title="Traveaux"><div class="d-block d-md-none">3</div><div class="d-none d-md-block">Traveaux</div></a></li>
                    <li onclick='changeTab(4)' class="nav-item" role="presentation"><a class="nav-link" id="nav-link-4" role="tab" data-bs-toggle="tab" href="#tab-4" data-bs-toggle="tooltip" title="Exp??riences"><div class="d-block d-md-none">4</div><div class="d-none d-md-block">Exp??riences</div></a></li>
                    <li onclick='changeTab(5)' class="nav-item" role="presentation"><a class="nav-link" id="nav-link-5" role="tab" data-bs-toggle="tab" href="#tab-5" data-bs-toggle="tooltip" title="Situation"><div class="d-block d-md-none">5</div><div class="d-none d-md-block">Situation</div></a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane" role="tabpanel">
                        <div class="card text-start">
                            <div class="card-body text-muted">
                                {{-- section 0 - application --}}
                            <div class="py-3 pt-4">
                                <small class="px-4 mt-5 text-dark fw-bold">Application</small>
                                <div class="row px-4 mt-2">
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8 px-2 py-2">
                                        <div class="mb-3">
                                            <label for="father name" class="form-label px-2">Application<sup class="text-danger"> *</sup></label>

                                            <select @if (!$modification_available) disabled @endif name="besoin_id" class="form-select @error('choix') is-invalid @enderror">
                                                <option disabled @if (!$dossier->besoin_id)selected @endif>Selectionner une choix</option>
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
                                                    <option value="{{ $item->id }}" @if ($dossier->besoin_id == $item->id)
                                                        selected
                                                    @endif>
                                                        <abbr title="{{ $faculty->name }}">{{ $faculty->abbr }}</abbr> - {{ $sector->name }}
                                                        @if ($speciality)
                                                            {{ ' - '.$speciality->name }}
                                                        @endif
                                                        @if ($subspeciality)
                                                            {{ ' - '.$subspeciality->name }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('choix')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 1 - identity -->
                            <div class="py-3 pt-4">
                                <small class="px-4 mt-5 text-dark fw-bold">Identit??</small>
                                <div class="row px-4">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                    @if (!$dossier->user_picture)
                                        <label for="profilePicture" class="form-label px-2">Importer votre photo<sup class="text-danger"> *</sup></label>
                                        <input type="file" class="form-control @error('user_picture') is-invalid @enderror" name="user_picture" id="user_picture">
                                        @error('user_picture')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                        @enderror
                                    @else
                                    <img class="img-thumbnail" src="storage/users_pictures/{{ $dossier->user_picture }}" alt="">
                                    @endif
                                    </div>
                                </div>
                                </div>
                                <div class="row px-4">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="name" class="form-label px-2">Nom<sup class="text-danger"> *</sup></label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control @error('family_name') is-invalid @enderror " name="family_name" id="family_name" value="{{ $dossier->family_name }}">
                                        @error('family_name')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="family name" class="form-label px-2">Pr??nom<sup class="text-danger"> *</sup></label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $dossier->name }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="arabic family name" class="form-label px-2">Nom en arabe<sup class="text-danger"> *</sup></label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control text-end @error('family_name_ar') is-invalid @enderror" name="family_name_ar" id="family_name_ar" placeholder="?????????? ???????????? ??????????????" value="{{ $dossier->family_name_ar }}">
                                        @error('family_name_ar')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="arabic name" class="form-label px-2">Pr??nom en arabe<sup class="text-danger"> *</sup></label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control text-end @error('name_ar') is-invalid @enderror " name="name_ar" id="name_ar" placeholder="?????????? ???????????? ??????????????" value={{ $dossier->name_ar }}>
                                        @error('name_ar')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row px-4">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="father name" class="form-label px-2">Pr??nom de pere</label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="father_name" id="father_name" value="{{ $dossier->father_name }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="mother name" class="form-label px-2">Nom et pr??nom de mere</label>
                                        <div class="input-group">
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="mother_family_name" id="mother_family_name" placeholder="nom" value="{{ $dossier->mother_family_name }}">
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="mother_name" id="mother_name" placeholder="pr??nom" value="{{ $dossier->mother_name }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-4">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="date de naissance" class="form-label px-2">Date de naissance<sup class="text-danger"> *</sup></label>
                                        <input @if (!$modification_available) disabled @endif type="date" max="{{ now()->subYears(20)->format('Y-m-d') }}" class="form-control @error('birth_date') is-invalid @enderror " name="birth_date" id="birth_date" value="{{ $dossier->birth_date }}">
                                        @error('birth_date')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="lieu de naissance" class="form-label px-2">Lieu de naissance<sup class="text-danger"> *</sup></label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control @error('birthplace') is-invalid @enderror" name="birthplace" id="birthplace" value="{{ $dossier->birthplace }}">
                                        @error('birthplace')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                    <label for="sexe" class="form-label px-2">Sexe<sup class="text-danger"> *</sup></label>
                                    <select @if (!$modification_available) disabled @endif  class="form-select" name="isMan" id="isMan" onchange="displayNationalService()">
                                        <option value="0" @if (!$dossier->isMan) selected @endif >Femme</option>
                                        <option value="1" @if ($dossier->isMan) selected @endif>Homme</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="nationalite" class="form-label px-2">Nationalit??<sup class="text-danger"> *</sup></label>
                                        <input @if (!$modification_available) disabled @endif type="text" value="Alg??rienne" class="form-control @error('nationality') is-invalid @enderror" name="nationality" id="nationality" value="{{ $dossier->nationality }}">
                                        @error('nationality')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row px-4">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                    <label for="idCard" class="form-label px-2">Carte nationale<sup class="text-danger"> *</sup></label>
                                    <input @if (!$modification_available) disabled @endif onkeypress="return onlyNumberKey(event)" type="text" class="form-control @error('id_card') is-invalid @enderror" maxlength="18" minlength="18" name="id_card" id="id_card" value="{{ $dossier->id_card }}" placeholder="num??ro de carte nationale">
                                    @error('id_card')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                    @enderror
                                </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                    <label for="date de naissance" class="form-label px-2">Photo de la carte<sup class="text-danger"> *</sup></label>
                                    @if (!$dossier->id_card_pic)
                                        <input @if (!$modification_available) disabled @endif type="file" class="form-control @error('id_card_picture') is-invalid @enderror" name="id_card_pic" id="id_card_pic">
                                        @error('id_card_picture')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                        @enderror
                                    @else
                                        <div class="text-success fw-bold mt-2"><i class="fas fa-check"></i> Image envoy??e</div>
                                    @endif

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
                                        <label for="situation familiale" class="form-label px-2">Situation familiale</label>
                                            <select @if (!$modification_available) disabled @endif onchange="hasChildren()" class="form-select" name="isMarried" id="isMarried">
                                            <option value="0" @if (!$dossier->isMarried) selected @endif >C??libataire</option>
                                            <option value="1" @if ($dossier->isMarried) selected @endif>Marie(e)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="display: none;" id="child_col" class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                        <div class="mb-3">
                                        <label for="nombre d'enfants" class="form-label px-2">Nombre d'enfants</label>
                                        <input @if (!$modification_available) disabled @endif type="number" min="0" max="15" value="{{ $dossier->children_number }}" class="form-control" name="children_number" id="children_number">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                        <div class="mb-3">
                                        <label for="besoins specifiques" class="form-label px-2">Besoins sp??cifiques</label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="disability_type" id="disability_type" placeholder="Nature de l'handicap" value="{{ $dossier->disability_type }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 3 - residence -->
                            <div class="py-3">
                                <small class="px-4 mt-5 text-dark fw-bold">r??sidence</small>
                                <div class="row px-4 mt-2">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="lieu de residence" class="form-label px-2">Lieu de r??sidence</label>
                                        <div class="input-group">
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="commune" id="commune" placeholder="commune" value="{{ $dossier->commune }}">
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="wilaya" id="wilaya" placeholder="wilaya" value="{{ $dossier->wilaya }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="inputCity" class="form-label px-2">Adresse<sup class="text-danger"> *</sup></label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" id="adresse" value="{{ $dossier->adresse }}" placeholder="ex: Bat 1 Guelma , N 1">
                                        @error('adresse')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
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
                                        <label for="phone" class="form-label px-2">Num??ro de t??l??phone<sup class="text-danger"> *</sup></label>
                                        <input @if (!$modification_available) disabled @endif onkeypress="return onlyNumberKey(event)" min="10" max="10" type="tel" class="form-control @error('tel') is-invalid @enderror" name="tel" id="tel" value="{{ $dossier->tel }}" placeholder="ex: 07 77 77 77 77">
                                        @error('tel')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="email" class="form-label px-2">Email</label>
                                        <input @if (!$modification_available) disabled @endif disabled type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}">
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
                                        <label for="service national" class="form-label px-2">Service Nationale</label>
                                            <select @if (!$modification_available) disabled @endif class="form-select" name="national_service" id="national_service">
                                                <option value="accompli" @if($dossier->national_service == 'accompli') selected @endif>Accomplie</option>
                                                <option value="dispense" @if($dossier->national_service == 'dispense') selected @endif>Exempt?? / Dispens??</option>
                                                <option value="sursitaire" @if($dossier->national_service == 'sursitaire') selected @endif>Sursitaire</option>
                                                <option value="inscrit" @if($dossier->national_service == 'inscrit') selected @endif>Inscrit</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                    <div class="mb-3">
                                    <label for="reference" class="form-label px-2">R??f??rence</label>
                                    <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="doc_num" id="doc_num" placeholder="num??ro de document" value="{{ $dossier->doc_num }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                    <div class="mb-3">
                                    <label for="reference" class="form-label px-2">d??livr?? le:</label>
                                    <input @if (!$modification_available) disabled @endif type="date" max="{{ now()->format('Y-m-d') }}" class="form-control" name="doc_issued_date" id="doc_issued_date" value="{{ $dossier->doc_issued_date }}">
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
                                            <label for="diploma name" class="form-label">D??nomination du dipl??me<sup class="text-danger"> *</sup></label>
                                            <select @if (!$modification_available) disabled @endif onchange="magisterDiploma()" id="diploma_name" class="form-select @error('diplome') is-invalid @enderror" name="diploma_name">
                                            @if (!$dossier->diploma_name)
                                                <option selected disabled>Selectionner une choix</option>
                                            @endif
                                            <option value="doctorat" @if($dossier->diploma_name=="doctorat") selected @endif>Doctorat</option>
                                            <option value="magister" @if($dossier->diploma_name=="magister") selected @endif>Magister</option>
                                            </select>
                                            @error('diplome')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Mention<sup class="text-danger"> *</sup></label>
                                            <select @if (!$modification_available) disabled @endif name="diploma_mark" id="diploma_mark" class="form-select @error('mention') is-invalid @enderror">
                                                @if (!$dossier->diploma_mark)
                                                <option selected disabled>Selectionner une choix</option>
                                                @endif
                                                <option id="d1" @if ($dossier->diploma_mark=="Honorable") selected @endif value='Honorable' >Honorable</option>
                                                <option id="d2" @if ($dossier->diploma_mark=="Tr??s Honorable") selected @endif value='Tr??s Honorable'>Tr??s honorable</option>
                                                <option id="m1" @if ($dossier->diploma_mark=="Assez bien") selected @endif value='Assez bien'>Assez bien</option>
                                                <option id="m2" @if ($dossier->diploma_mark=="Bien") selected @endif value='Bien'>Bien</option>
                                                <option id="m3" @if ($dossier->diploma_mark=="Tr??s Bien") selected @endif value='Tr??s Bien'>Tr??s Bien</option>
                                            </select>
                                            @error('mention')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Fili??re<sup class="text-danger"> *</sup></label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control @error('filiere') is-invalid @enderror" name="diploma_sector" value="{{ $dossier->diploma_sector }}">
                                        @error('filiere')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Sp??cialit??<sup class="text-danger"> *</sup></label>
                                    <input @if (!$modification_available) disabled @endif type="text" class="form-control @error('specialite') is-invalid @enderror" name="diploma_speciality" value="{{ $dossier->diploma_speciality }}">
                                    @error('specialite')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Date d'obtention du dipl??me</label>
                                            <input @if (!$modification_available) disabled @endif type="date" class="form-control" max="{{ now()->format('Y-m-d') }}" name="diploma_date" value="{{ $dossier->diploma_date }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Num??ro</label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="diploma_number" value="{{ $dossier->diploma_number }}">
                                    </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-12 col-md-8">
                                        <label for="" class="form-label">Duree de la formation pour obtenu le dipl??me</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">De</span>
                                            <input @if (!$modification_available) disabled @endif type="date" max="{{ now()->subYears(2)->format('Y-m-d') }}" class="form-control" name="diploma_start_date" value="{{ $dossier->diploma_start_date }}">
                                            <span class="input-group-text" id="basic-addon1">A</span>
                                            <input @if (!$modification_available) disabled @endif type="date" max="{{ now()->format('Y-m-d') }}" class="form-control" name="diploma_end_date" value="{{ $dossier->diploma_end_date }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Institution</label>
                                            <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="diploma_institution" value="{{ $dossier->diploma_institution }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Magister table -->
                            <div id="magisterCase">
                                    <h5 class="p-3 display-6 mt-3 text-muted text-center">Formations compl??mentaires</h5>
                                    @if ($modification_available)
                                    <div class="alert alert-danger p-5">
                                        <h5 class="fw-bold">Remarques:</h5>
                                        <ul>
                                            <li>Remplir cette partie en cas de magister seulement</li>
                                            <li>Vouz avez le droit d'ajouter 3 formations au maximum</li>
                                            <li>Tous les champs sont obligatoires</li>
                                        </ul>
                                    </div>
                                    <div class="text-center">
                                        @if (App\Models\FormationsComp::where('user_id', $dossier->user_id)->count()<3)
                                          <button type="button" class="btn btn-lg btn-outline-primary border mb-5" data-bs-toggle="modal" data-bs-target="#ajouterFormation">
                                        Ajouter</button>
                                        @endif
                                    </div>

                                    @endif
                                <div class="table-responsive-lg px-3 mt-2">
                                        <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Inscription au doctorat</th>
                                                <th>Sp??cialit??</th>
                                                <th>Num??ro</th>
                                                <th>Institution</th>
                                                <th>Date d'inscription</th>
                                                @if ($modification_available)
                                                <th>Supprimer</th>
                                                @endif

                                            </tr>
                                                @php
                                                    $j = 1
                                                @endphp
                                                @foreach (App\Models\FormationsComp::where('user_id', $dossier->user_id)->get() as $item)
                                                <tr>
                                                    <td>Inscription: {{ $j++ }}</td>
                                                    <td>{{ $item->fc_speciality }}</td>
                                                    <td>{{ $item->fc_number }}</td>
                                                    <td>{{ $item->fc_institution }}</td>
                                                    <td>{{ $item->fc_inscription_date }}</td>
                                                    @if ($modification_available)
                                                    <td class="text-center">
                                                        <a data-bs-toggle="modal" href="#deleteFormation" data-id="{{ $item->id }}" class="open-delete-formation btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                    @endif

                                                </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab-3" class="tab-pane" role="tabpanel">
                        <div class="card text-start">
                            <div class="card-body text-muted">
                            <div class="container text-center">
                                @if ($modification_available)
                                <p class="fw-light fst-italic mx-5 my-4">
                                    Vous pouvez ajouter ici les travaux ou ??tudes r??alis??s (le cas ??ch??ant)
                                    </p>
                                <button type="button" class="btn btn-lg btn-outline-primary border mb-5" data-bs-toggle="modal" data-bs-target="#ajouterTravail">
                                Ajouter</button>
                                <hr class="my-3">
                                @endif
                            </div>

                            <div class="table-responsive">
                                <div class="mt-4 fw-bold px-3">
                                    Les revues
                                </div>
                                <table class="table table-bordered text-center">
                                    <tbody>
                                        <tr>
                                            <th>Type</th>
                                            <th>Titre</th>
                                            <th>Revue</th>
                                            <th>Ann??e</th>
                                            <th>Cat??gorie</th>
                                            <th>URL</th>
                                            <th>PDF</th>
                                            @if ($modification_available)
                                            <th width="10%">Supprimer</th>
                                            @endif

                                        </tr>
                                    @forelse (Illuminate\Support\Facades\DB::table('articles')
                                    ->where('user_id', $dossier->user_id)->get() as $item)
                                        <tr>
                                            <td>Revue
                                                @php
                                                    $item->is_international?print('internationale'):print('nationale');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $item->article_title?print($item->article_title):print('-');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $item->article?print($item->article):print('-');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $item->article_date?print($item->article_date):print('-');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $item->article_category?print($item->article_category):print('-');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $item->article_link?print($item->article_link):print('-');
                                                @endphp
                                            </td>
                                            @if ($item->article_file)
                                                <td style="max-width: 150px;" class="text-truncate">
                                                <a target="_blank" class="link link-info fw-bold mt-2" href="{{route('getArticle', $item->article_file)}}">{{ $item->article_file }}</a>
                                                </td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if ($modification_available)
                                            <td class="text-center">
                                                <a data-bs-toggle="modal" href="#deleteArticle" data-id="{{ $item->id }}" class="open-delete-article btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                            @endif

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">La liste des revues est vide</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                </table>
                                <div class="mt-4 fw-bold px-3">
                                    Les conf??rences
                                </div>
                                <table class="table table-bordered text-center">
                                    <tbody>
                                        <tr>
                                            <th>Type</th>
                                            <th>Nom de conf??rence</th>
                                            <th>Lieu de conf??rence</th>
                                            <th>Date de conf??rence</th>
                                            <th>Titre de conf??rence</th>
                                            <th>Auteurs de conf??rence</th>
                                            <th>URL</th>
                                            <th>Attestation</th>
                                            @if ($modification_available)
                                            <th width="10%">Supprimer</th>
                                            @endif
                                        </tr>
                                    @forelse (Illuminate\Support\Facades\DB::table('conferences')
                                    ->where('user_id', $dossier->user_id)->get() as $item)
                                        <tr>
                                            <td>Conf??rence
                                                @php
                                                    $item->is_international?print('internationale'):print('nationale');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $item->conference_name?print($item->conference_name):print('-');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $item->conference_place?print($item->conference_place):print('-');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $item->conference_date?print(date('d/m/Y', strtotime($item->conference_date))):print('-');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $item->communication_title?print($item->communication_title):print('-');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $item->conference_authors?print($item->conference_authors):print('-');
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $item->conference_link?print($item->conference_link):print('-');
                                                @endphp
                                            </td>
                                            <td style="max-width: 150px;" class="text-truncate">
                                                <a target="_blank" class="link link-info fw-bold mt-2" href="{{route('getCertificate', $item->certificate)}}">{{ $item->certificate }}</a>
                                            </td>
                                            @if ($modification_available)
                                            <td class="text-center">
                                                <a data-bs-toggle="modal" href="#deleteConference" data-id="{{ $item->id }}" class="open-delete-conference btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9">La liste des conf??rences est vide</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                </table>
                            </div>
                            </div>
                        </div>

                    </div>
                    <div id="tab-4" class="tab-pane" role="tabpanel">
                        <div class="card text-start">
                            <div class="card-body text-muted">
                                <div class="p-4 text-center">
                                    <div class="alert alert-warning fw-bold">
                                        <i class="fas fa-exclamation-circle fs-1"></i><br>
                                        les p??riode de travaille non d??clar??es au niveau de la caisse nationalee des assurances sociales ne sont pas prise en cosid??ration.
                                        <br>
                                        ?????????? ?????????? ???????? ???? ???????? ???????? ?????? ?????????? ?????????????? ???????????? ?????????????? ?????????????????? ???? ???????? ???? ????????????????
                                    </div>
                                </div>
                            <div class="container text-center">
                                @if ($modification_available)
                                <p class="fw-light fst-italic mx-5 my-4">
                                    Vous pouvez ajouter votre exp??riences professionnelle (le cas ??ch??ant)
                                </p>

                                <button type="button" class="btn btn-lg btn-outline-primary border mb-5" data-bs-toggle="modal" data-bs-target="#ajouterExperience">
                                Ajouter</button>
                                @endif
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered text-center">
                                    <tbody>
                                        <tr>
                                                <th>D??nomiation de l'administration ou de l'insitution (organisme d'emplyeur)</th>
                                                <th>Fonction ou poste de travail occup??</th>
                                                <th>P??riode</th>
                                                <th>attestation de travail ou contrat</th>
                                                <th style="max-width: 15vw">motif de la rupture de la relation de travail</th>
                                                @if ($modification_available)
                                                <th>Supprimer</th>
                                                @endif
                                        </tr>
                                        @forelse (Illuminate\Support\Facades\DB::table('experience_pros')
                                        ->where('user_id', $dossier->user_id)->get() as $item)
                                            <tr>
                                                <td>{{ $item->ep_institution }}</td>
                                                <td>{{ $item->ep_workplace }}</td>
                                                <td>{{ $item->ep_periode }} mois</td>
                                                <td>{{ $item->ep_work_certificate_ref }} ({{ date('d-m-Y', strtotime($item->ep_work_certificate_date)) }})</td>

                                                <td>
                                                    @php
                                                        $item->ep_mark?print($item->ep_mark):print('-');
                                                    @endphp
                                                </td>
                                                @if ($modification_available)
                                                <td class="text-center">
                                                    <a data-bs-toggle="modal" href="#deleteExperience" data-id="{{ $item->id }}" class="open-delete-experience btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                                                </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    Vous n'avez ajout?? aucune experience professionnelle
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>

                    </div>
                    <div id="tab-5" class="tab-pane" role="tabpanel">
                            <div class="card text-start">
                            <div class="card-body text-muted">
                                <div class="p-4">
                                    <div class="alert alert-warning fw-bold text-center">
                                        <i class="fas fa-exclamation-circle fs-1"></i><br>
                                        Renseignements concerant la situation professionnelle actuelle
                                        <br>
                                        ?????? ?????????? ???????? ?????????????????? ???????????????? ??????
                                    </div>
                                </div>
                                <div class="row px-4 gy-3">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="denomination" class="form-label px-2">D??nomination de garde occup??</label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="sp_workplace" id="sp_workplace" value="{{ $dossier->sp_workplace }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="date" class="form-label px-2">Date de la premi??re nomination</label>
                                        <input @if (!$modification_available) disabled @endif type="date" max="{{ now()->subDays(1)->format('Y-m-d') }}" class="form-control" name="sp_first_nomination_date" id="sp_first_nomination_date" value="{{ $dossier->sp_first_nomination_date }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="date"  class="form-label px-2">Date de nomination de poste actuelle</label>
                                        <input @if (!$modification_available) disabled @endif type="date" max="{{ now()->format('Y-m-d') }}" class="form-control" name="sp_nomination_date" id="sp_nomination_date" value="{{ $dossier->sp_nomination_date }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="category" class="form-label px-2">Cat??gorie</label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="sp_category" id="sp_category" value="{{ $dossier->sp_category }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="echelon" class="form-label px-2">Echelon</label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="sp_echelon" id="sp_echelon" value="{{ $dossier->sp_echelon }}">
                                    </div>
                                    </div>
                                    <div class="col-12 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="category" class="form-label px-2">R??f??rence de l'accord de l'organisme employeur pour la participation du candidat au concours</label>
                                        <div class="input-group">
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="sp_agreement_ref" id="sp_agreement_ref" placeholder="Num??ro" value="{{ $dossier->sp_agreement_ref }}">
                                        <input @if (!$modification_available) disabled @endif type="date" max="{{ now()->subDays(1)->format('Y-m-d') }}"  class="form-control" name="sp_agreement_date" id="sp_agreement_date" value="{{ $dossier->sp_agreement_date }}">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label class="form-label px-2">L'autorit?? ayant pouvoir de signature</label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="sp_authority" id="sp_authority" value="{{ $dossier->sp_authority }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="adresse" class="form-label px-2">Adresse de l'administration</label>
                                        <input @if (!$modification_available) disabled @endif type="text" class="form-control" name="sp_adresse" id="sp_adresse" value="{{ $dossier->sp_adresse }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label px-2">Tel</label>
                                        <input @if (!$modification_available) disabled @endif type="tel" minlength="10" maxlength="10" class="form-control" name="sp_tel" id="sp_tel" value="{{ $dossier->sp_tel }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label px-2">Fax</label>
                                        <input @if (!$modification_available) disabled @endif type="tel" class="form-control" name="sp_fax" id="sp_fax" value="{{ $dossier->sp_fax }}">
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                    <div class="mb-3">
                                        <label for="email" class="form-label px-2">Email</label>
                                        <input @if (!$modification_available) disabled @endif type="email" class="form-control" name="sp_email" id="sp_email" placeholder="company@example.com" value="{{ $dossier->sp_email }}">
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

        {{-- Les formations complementaire --}}
        {{--! DELETE --}}
        <form action="{{ route('delete.formation') }}" method="POST">
            @csrf
            <div class="modal fade hide" id="deleteFormation" tabindex="-1" aria-labelledby="deleteFormationLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-3">
                        ??tes-vous s??r de vouloir supprimer cette formation?<br>
                        <input type="hidden" name="id" id="formationId">
                        <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                    </div>
                    <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </div>
                </div>
            </div>
        </form>
        {{--! ADD  --}}
        <form action="{{ route('formation.store') }} " method="POST">
            @csrf
            <!-- Modal -->
            <div class="modal fade" id="ajouterFormation" tabindex="-1" aria-labelledby="ajouterFormationLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouveau formation compl??mentaire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger text-center">
                            <strong>vous devez remplir tous les champs obligatoires</strong>
                        </div>
                    <div class="container px-3 py-3">
                        <div class="row gy-3">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 py-2">
                            <div class="mb-3">
                            <label for="Specialit??" class="form-label">Specialit??<sup class="text-danger"> *</sup></label>
                            <input type="text" class="form-control" name="fc_speciality" id="fc_speciality">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 py-2">
                            <div class="mb-3">
                            <label for="Institution" class="form-label">Institution<sup class="text-danger"> *</sup></label>
                            <input type="text" class="form-control" name="fc_institution" id="fc_institution">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 py-2">
                            <div class="mb-3">
                            <label for="Num??ro" class="form-label">Num??ro<sup class="text-danger"> *</sup></label>
                            <input type="text" class="form-control" name="fc_number" id="fc_number">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 py-2">
                            <div class="mb-3">
                            <label for="Date d'inscription" class="form-label">Date d'inscription<sup class="text-danger"> *</sup></label>
                            <input type="date" max="{{ now()->subDays(1)->format('Y-m-d') }}" class="form-control" name="fc_inscription_date" id="fc_inscription_date">
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <input type="hidden" name="user_id" value="{{ $dossier->user_id }}">
                    <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </div>
                </div>
            </div>
        </form>

        {{-- Conference --}}
        {{--! ADD --}}
        <form action="{{ route('conference.store') }} " method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Modal -->
            <div class="modal fade" id="ajouterConference" tabindex="-1" aria-labelledby="ajouterConferenceLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouvel conf??rence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="container p-3">
                        <div class="alert alert-danger text-center">
                            <strong>vous devez remplir tous les champs obligatoires</strong>
                        </div>
                        <div class="row g-3">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 py-2">
                                <div class="mb-3">
                                  <label for="filiere" class="form-label">Nature de conf??rence<sup class="text-danger"> *</sup></label>
                                  <select name="is_international" class="form-select">
                                      <option disabled selected>Selectionner votre choix</option>
                                      <option value="0">Conf??rence nationale</option>
                                      <option value="1">Conf??rence internationale</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                  <label for="filiere" class="form-label">Conf??rence<sup class="text-danger"> *</sup></label>
                                  <input type="text" class="form-control" name="conference_name">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                  <label for="filiere" class="form-label">Lieu de conf??rence<sup class="text-danger"> *</sup></label>
                                  <input type="text" class="form-control" name="conference_place">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                  <label for="filiere" class="form-label">Date de conf??rence<sup class="text-danger"> *</sup></label>
                                  <input name="conference_date" max="{{ now()->format('Y-m-d') }}" type="date" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                  <label for="filiere" class="form-label">Titre de communication<sup class="text-danger"> *</sup></label>
                                  <input type="text" class="form-control" name="communication_title">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                  <label for="filiere" class="form-label">Auteurs de conf??rence<sup class="text-danger"> *</sup></label>
                                  <input type="text" class="form-control" name="conference_authors">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12 px-2 py-2">
                                <div class="mb-3">
                                  <label for="filiere" class="form-label">URL</label>
                                  <input type="url" name="conference_link" class="form-control" placeholder="https://www.exemple.com">
                                </div>
                            </div>
                            <div class="col-xs-12 px-2 py-2">
                                <div class="mb-3">
                                  <label for="file" class="form-label">Attestation<sup class="text-danger"> *</sup></label>
                                  <input type="file" name="certificate" class="form-control">
                                  <small class="text-danger fw-bold">(jpg, jpeg, png, pdf)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <input type="hidden" name="user_id" value="{{ $dossier->user_id }}">
                    <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                    <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </div>
                </div>
            </div>
        </form>
        {{--! DELETE --}}
        <form action="{{ route('delete.conference') }}" method="POST">
            @csrf
            <div class="modal fade hide" id="deleteConference" tabindex="-1" aria-labelledby="deleteConferenceLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-3">
                        ??tes-vous s??r de vouloir supprimer cette conf??rence?<br>
                        <input type="hidden" name="id" id="conferenceId">
                        <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                    </div>
                    <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </div>
                </div>
            </div>
        </form>

        {{-- Revue --}}
        {{--! ADD --}}
        <form action="{{ route('revue.store') }} " method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Modal -->
            <div class="modal fade" id="ajouterRevue" tabindex="-1" aria-labelledby="ajouterRevueLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouvel Revue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="container p-3">
                        <div class="alert alert-danger text-center">
                            <strong>vous devez remplir tous les champs obligatoires</strong>
                        </div>
                        <div class="row g-3">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 px-2 py-2">
                                <div class="mb-3">
                                  <label class="form-label">Nature de revue<sup class="text-danger"> *</sup></label>
                                  <select name="is_international" class="form-select">
                                      <option value="0" selected>Revue nationale</option>
                                      <option value="1">Revue internationale</option>
                                  </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                  <label class="form-label">Date de revue (Ann??e)<sup class="text-danger"> *</sup></label>
                                  <input type="number" min="1980" max="{{ now()->format('Y') }}" value="{{ now()->format('Y') }}" class="form-control" name="article_date">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 px-2 py-2">
                                <div class="mb-3">
                                  <label class="form-label">Titre (?????????? ????????????)<sup class="text-danger"> *</sup></label>
                                  <input type="text" class="form-control" name="article_title">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                  <label class="form-label">Revue (??????????????)<sup class="text-danger"> *</sup></label>
                                  <input type="text" class="form-control" name="article">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 px-2 py-2">
                                <div class="mb-3">
                                  <label class="form-label">Cat??gorie</label>
                                  <select class="form-select" name="category" id="category">
                                      <option selected disabeled>Selectionner une choix</option>
                                      <option value="A+">A+</option>
                                      <option value="A">A</option>
                                      <option value="B">B</option>
                                      <option value="C">C</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 px-2 py-2">
                                <div class="mb-3">
                                  <label class="form-label">URL</label>
                                  <input type="url" name="article_link" class="form-control" placeholder="https://www.exemple.com">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 px-2 py-2">
                                <div class="mb-3">
                                  <label class="form-label">Article</label>
                                  <input type="file" name="article_file" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <input type="hidden" name="user_id" value="{{ $dossier->user_id }}">
                    <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                    <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </div>
                </div>
            </div>
        </form>
        {{--! DELETE --}}
        <form action="{{ route('delete.article') }}" method="POST">
            @csrf
            <div class="modal fade hide" id="deleteArticle" tabindex="-1" aria-labelledby="deleteArticleLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-3">
                        ??tes-vous s??r de vouloir supprimer cette article?<br>
                        <input type="hidden" name="id" id="articleId">
                        <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                    </div>
                    <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </div>
                </div>
            </div>
        </form>

        {{-- Conference ou revue --}}

        <div class="modal fade" id="ajouterTravail" tabindex="-1" aria-labelledby="ajouterTravailLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="row g-4">
                      <div data-bs-toggle="modal" data-bs-target="#ajouterRevue" class="col-6">
                          <div class="card shadow-sm">
                              <div class="card-body p-4 text-center">
                                  <img src="{{ asset('assets/images/Add files-amico.svg') }}" alt="">
                                  <h4 class="text-muted">Revue</h4>
                              </div>
                          </div>
                      </div>
                      <div class="col">
                        <div data-bs-toggle="modal" data-bs-target="#ajouterConference"  class="card shadow-sm">
                            <div class="card-body p-4 text-center">
                                <img src="{{ asset('assets/images/Conference speaker-pana.svg') }}" alt="">
                                <h4 class="text-muted">Conference</h4>
                            </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
        </div>

          {{-- Les experiences professionnels --}}
        {{--! ADD --}}
        <form action="{{ route('experience.store') }}" method="POST">
            @csrf
          <!-- Modal -->
          <div class="modal fade" id="ajouterExperience" tabindex="-1" aria-labelledby="ajouterExperienceLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Nouveau exp??rience professionnelle</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="container p-3">
                      <div class="alert alert-danger text-center">
                          <strong>vous devez remplir tous les champs obligatoires</strong>
                      </div>
                    <div class="row gy-3">
                      <div class="col-12 col-lg-6 p-2">
                        <div class="mb-3">
                          <label for="nom d'institution" class="form-label">D??nomination de l'institution<sup class="text-danger"> *</sup></label>
                          <input type="text" class="form-control" name="ep_institution" id="ep_institution" aria-describedby="hint1">
                          <small id="hint1" class="form-text text-muted">institution ou administration</small>
                        </div>
                      </div>
                      <div class="col-12 col-lg-6 p-2">
                        <div class="mb-3">
                          <label for="filiere" class="form-label">Poste de travail occup??<sup class="text-danger"> *</sup></label>
                          <input type="text" class="form-control" name="ep_workplace" id="ep_workplace">
                        </div>
                      </div>
                      <div class="col-12 col-lg-6 p-2">
                        <div class="mb-3">
                          <label class="form-label">Num??ro d'attestation de travail<sup class="text-danger"> *</sup></label>
                          <input type="text" class="form-control" name="ep_work_certificate_ref" id="ep_work_certificate_ref">
                          <small id="hint2" class="form-text text-muted">Attestation ou contrat</small>
                        </div>
                      </div>
                      <div class="col-12 col-lg-6 p-2">
                        <div class="mb-3">
                          <label class="form-label">Date d'attestation de travail<sup class="text-danger"> *</sup></label>
                          <input type="date" max="{{ now()->subMonths(1)->format('Y-m-d') }}" class="form-control" name="ep_work_certificate_date" id="ep_work_certificate_date">
                        </div>
                      </div>
                      <div class="col-12 col-lg-6 p-2">
                        <div class="mb-3">
                          <label class="form-label">P??riode de travail (nombre de mois)<sup class="text-danger"> *</sup></label>
                          <input type="number" min="1" value="1" class="form-control" name="ep_periode" id="ep_periode">
                        </div>
                      </div>

                      <div class="mb-3">
                        <textarea class="form-control" name="ep_mark" id="ep_mark" rows="3" placeholder="Motif de la rupture de la relation de travail"></textarea>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" name="user_id" value="{{ $dossier->user_id }}">
                <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                  <button type="submit" name="add_exp" class="btn btn-primary">Ajouter</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        {{--! DELETE --}}
        <form action="{{ route('delete.experience') }}" method="POST">
            @csrf
            <div class="modal fade hide" id="deleteExperience" tabindex="-1" aria-labelledby="deleteExperienceLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-3">
                        ??tes-vous s??r de vouloir supprimer cette exp??rience?<br>
                        <input type="hidden" name="id" id="experienceId">
                        <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                    </div>
                    <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </div>
                </div>
            </div>
        </form>

        {{-- Validation du dossier --}}
        <form method="POST" action="{{ route('validate.dossier') }}">
            @csrf
            <div class="modal fade" id="validateDossier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="validateDossierLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-danger fw-bold text-center">
                            <div class="fs-5">FAIRE ATTENTION!!</div>
                            Une fois que vous soumettez, vous ne pouvez jamais revenir et modifier vos informations
                        </div>
                        <div class="form-check p-3 text-muted fs-6 mt-3 mx-2">
                            <input class="form-check-input" type="checkbox" id="checkme">
                            <label class="form-check-label" for="checkme">
                                <i>
                                   je soussign??, declare sur l'honneur, l'exactitude des renseignements fournis dans ce document et assumer toutes les cons??quences de toute d??claration fausse ou inexacte y compris l'anuulation de mon admission au concours.
                                </i>

                            </label>
                        </div>
                        <div class="validation-data">
                            <input type="hidden" name="id" value="{{ $dossier->id }}">
                            {{-- Personnel --}}
                            <input type="hidden" name="choix" value="{{ $dossier->besoin_id }}">
                            <input type="hidden" name="name" value="{{ $dossier->name }}">
                            <input type="hidden" name="family_name" value="{{ $dossier->family_name }}">
                            <input type="hidden" name="name_ar" value="{{ $dossier->name_ar }}">
                            <input type="hidden" name="family_name_ar" value="{{ $dossier->family_name_ar }}">
                            <input type="hidden" name="birth_date" value="{{ $dossier->birth_date }}">
                            <input type="hidden" name="birthplace" value="{{ $dossier->birthplace }}">
                            <input type="hidden" name="id_card" value="{{ $dossier->id_card }}">
                            <input type="hidden" name="id_card_picture" value="{{ $dossier->id_card_pic }}">
                            <input type="hidden" name="nationality" value="{{ $dossier->nationality }}">
                            <input type="hidden" name="adresse" value="{{ $dossier->adresse }}">
                            <input type="hidden" name="tel" value="{{ $dossier->tel }}">
                            {{-- diplome --}}
                            <input type="hidden" name="diplome" value="{{ $dossier->diploma_name }}">
                            <input type="hidden" name="mention" value="{{ $dossier->diploma_mark }}">
                            <input type="hidden" name="filiere" value="{{ $dossier->diploma_sector }}">
                            <input type="hidden" name="specialite" value="{{ $dossier->diploma_speciality }}">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                      <button id="submit" type="submit" disabled class="btn btn-outline-danger">Valider et terminer</button>
                    </div>
                  </div>
                </div>
              </div>
        </form>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        var checker = document.getElementById('checkme');
        var submit = document.getElementById('submit');
        checker.onchange = function() {
        submit.disabled = !this.checked;
        };

        // Delete formation
        $(document).on("click", ".open-delete-formation", function () {
            var formationId = $(this).data('id');
            $("#formationId").val( formationId );
            $('#deleteFormation').modal('show');
        });
        //Delete Conference
        $(document).on("click", ".open-delete-conference", function () {
            var formationId = $(this).data('id');
            $("#conferenceId").val( formationId );
            $('#deleteConference').modal('show');
        });
        //Delete article
        $(document).on("click", ".open-delete-article", function () {
            var formationId = $(this).data('id');
            $("#articleId").val( formationId );
            $('#deleteArticle').modal('show');
        });
        //Delete article
        $(document).on("click", ".open-delete-experience", function () {
            var experienceId = $(this).data('id');
            $("#experienceId").val( experienceId );
            $('#deleteExperience').modal('show');
        });

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


        if(document.getElementById("diploma_name").value == "magister")
                {
                    document.getElementById("d1").style.display = 'none';
                    document.getElementById("d2").style.display = 'none';
                    document.getElementById("m1").style.display = 'block';
                    document.getElementById("m2").style.display = 'block';
                    document.getElementById("m3").style.display = 'block';
            }else{
                if(document.getElementById("diploma_name").value == "doctorat"){
                    document.getElementById("d1").style.display = 'block';
                    document.getElementById("d2").style.display = 'block';
                    document.getElementById("m1").style.display = 'none';
                    document.getElementById("m2").style.display = 'none';
                    document.getElementById("m3").style.display = 'none';
                }else{
                    document.getElementById("d1").style.display = 'none';
                    document.getElementById("d2").style.display = 'none';
                    document.getElementById("m1").style.display = 'none';
                    document.getElementById("m2").style.display = 'none';
                    document.getElementById("m3").style.display = 'none';
                }

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

        function magisterDiploma()
        {
            if(document.getElementById("diploma_name").value == "magister")
                {
                    document.getElementById("d1").style.display = 'none';
                    document.getElementById("d2").style.display = 'none';
                    document.getElementById("m1").style.display = 'block';
                    document.getElementById("m2").style.display = 'block';
                    document.getElementById("m3").style.display = 'block';
                    document.getElementById("magisterCase").style.display = 'block';
                    document.getElementById("diploma_mark").value = '';
            }else{
                    document.getElementById("magisterCase").style.display = 'none';
                    document.getElementById("diploma_mark").value = '';
                    document.getElementById("d1").style.display = 'block';
                    document.getElementById("d2").style.display = 'block';
                    document.getElementById("m1").style.display = 'none';
                    document.getElementById("m2").style.display = 'none';
                    document.getElementById("m3").style.display = 'none';
            }
        }

        function onlyNumberKey(evt) {
            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        function changeTab(tab){
            document.getElementById('current_tab').value = tab;
        }
        document.getElementById('tab-'+{{ $current_tab }}).classList.add('active');
        document.getElementById('nav-link-'+{{ $current_tab }}).classList.add('active');
    </script>
@endsection
