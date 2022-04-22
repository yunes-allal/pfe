@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
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
                <li class="nav-item d-none d-md-block" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-2">Formations</a></li>
                <li class="nav-item d-none d-md-block" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-3">Experience</a></li>
            </ul>
            <div class="tab-content">
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
                                    <input type="text" class="form-control" name="family_name" id="family_name">
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                  <div class="mb-3">
                                    <label for="family name" class="form-label px-2">Prénom<sup class="text-danger"> *</sup></label>
                                    <input type="text" class="form-control" name="name" id="name">
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                  <div class="mb-3">
                                    <label for="arabic family name" class="form-label px-2">Nom en arabe<sup class="text-danger"> *</sup></label>
                                    <input type="text" class="form-control text-end" name="family_name_ar" id="family_name_ar" placeholder="اللقب باللغة العربية">
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                  <div class="mb-3">
                                    <label for="arabic name" class="form-label px-2">Prénom en arabe<sup class="text-danger"> *</sup></label>
                                    <input type="text" class="form-control text-end" name="name_ar" id="name_ar" placeholder="الاسم باللغة العربية">
                                  </div>
                              </div>
                          </div>
                          <div class="row px-4">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                  <div class="mb-3">
                                    <label for="father name" class="form-label px-2">Prénom de pere<sup class="text-danger"> *</sup></label>
                                    <input type="text" class="form-control" name="father_name" id="father_name">
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 px-2 py-2">
                                  <div class="mb-3">
                                    <label for="mother name" class="form-label px-2">Nom et prénom de mere<sup class="text-danger"> *</sup></label>
                                    <div class="input-group">
                                      <input type="text" class="form-control" name="mother_family_name" id="mother_family_name" placeholder="nom">
                                      <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="prénom">
                                    </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row px-4">
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                  <div class="mb-3">
                                    <label for="date de naissance" class="form-label px-2">Date de naissance<sup class="text-danger"> *</sup></label>
                                    <input type="date" class="form-control text-muted" name="birth_date" id="birth_date">
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                  <div class="mb-3">
                                    <label for="lieu de naissance" class="form-label px-2">Lieu de naissance<sup class="text-danger"> *</sup></label>
                                    <input type="text" class="form-control" name="birthplace" id="birthplace">
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                <div class="mb-3">
                                  <label for="sexe" class="form-label px-2">Sexe<sup class="text-danger"> *</sup></label>
                                  <select class="form-select" name="isMan" id="isMan" onchange="displayNationalService()">
                                    <option value="false" selected>Femme</option>
                                    <option value="true">Homme</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                  <div class="mb-3">
                                    <label for="nationalite" class="form-label px-2">Nationalité<sup class="text-danger"> *</sup></label>
                                    <input type="text" value="Algérienne" class="form-control text-muted" name="nationality" id="nationality">
                                  </div>
                              </div>
                          </div>
                          <div class="row px-4">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 px-2 py-2">
                              <div class="mb-3">
                                <label for="idCard" class="form-label px-2">Carte nationale<sup class="text-danger"> *</sup></label>
                                <input type="text" class="form-control" name="id_card" id="id_card" placeholder="numéro de carte nationale">
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
                                        <select onchange="hasChildren()" class="form-control" name="isMarried" id="isMarried">
                                          <option value="false" selected>Célibataire</option>
                                          <option value="true">Marie(e)</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display: none;" id="child_col" class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                      <label for="nombre d'enfants" class="form-label px-2">Nombre d'enfants</label>
                                      <input type="number" min="0" max="15" value="0" class="form-control" name="children_number" id="children_number">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                    <div class="mb-3">
                                      <label for="besoins specifiques" class="form-label px-2">Besoins spécifiques</label>
                                      <input type="text" class="form-control" name="disability_type" id="disability_type" placeholder="Nature de l'handicap">
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
                                      <input type="text" class="form-control" name="commune" id="commune" placeholder="commune">
                                      <input type="text" class="form-control" name="wilaya" id="wilaya" placeholder="wilaya">
                                    </div>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 px-2 py-2">
                                  <div class="mb-3">
                                    <label for="inputCity" class="form-label px-2">Adresse<sup class="text-danger"> *</sup></label>
                                    <input type="text" class="form-control" name="adresse" id="adresse" placeholder="ex: Bat 1 Guelma , N 1">
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
                                    <input type="tel" class="form-control" name="tel" id="tel" placeholder="ex: 07 77 77 77 77">
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 px-2 py-2">
                                  <div class="mb-3">
                                    <label for="email" class="form-label px-2">Email<sup class="text-danger"> *</sup></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="nom.prenom@exemple.com">
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
                                              <option value="accompli" selected>Accomplie</option>
                                              <option value="dispense">Exempté / Dispensé</option>
                                              <option value="sursitaire">Sursitaire</option>
                                              <option value="inscrit">Inscrit</option>
                                          </select>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                  <label for="reference" class="form-label px-2">Référence</label>
                                  <input type="text" class="form-control" name="doc_num" id="doc_num" placeholder="numéro de document">
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 px-2 py-2">
                                <div class="mb-3">
                                  <label for="reference" class="form-label px-2">délivré le:</label>
                                  <input type="date" class="form-control" name="doc_issued_date" id="doc_issued_date">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div id="tab-2" class="tab-pane" role="tabpanel">
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
                <div id="tab-3" class="tab-pane" role="tabpanel">
                    <div class="card text-start">
                        <div class="card-body text-muted">
                          <div class="container">
                            <p class="fw-light fst-italic mx-5 my-4">
                              Vous pouvez ajouter votre expériences professionnelle (le cas échéant)
                            </p>
                            <button type="button" class="btn btn-light text-primary border mx-3 my-4" data-bs-toggle="modal" data-bs-target="#ajouterExperience">
                            <i data-feather="plus-circle"></i> Ajouter
                          </button>
                          </div>


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
        </div>
    </div>
@endsection
