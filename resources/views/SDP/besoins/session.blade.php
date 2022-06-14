@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h3>Création d'une nouvelle session</h3>
        <form class="mt-5 card p-4 rounded-3 shadow-sm" action="{{ route('session') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row gx-5 gy-3 p-4">
                <div class="col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="session" class="form-label fw-bold">Session <sup class="text-danger">*</sup></label>
                        <input value="{{ old('name') }}" type="month" min="{{ now()->format('Y-m') }}" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                        @error('name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nombre globale" class="form-label fw-bold">Nombre globale de postes<sup class="text-danger">*</sup></label>
                        <input type="number" min="1" value="1" class="form-control @error('global_number') is-invalid @enderror" name="global_number" id="global_number">
                        @error('global_number')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="condition" class="form-label fw-bold">Condition <sup class="text-danger">*</sup></label>
                        <select class="form-select @error('decision') is-invalid @enderror" name="onlyDoctorat" id="onlyDoctorat">
                            <option value="false" selected>Doctorat + Magister</option>
                            <option value="true">Doctorat seulement</option>
                        </select>
                        @error('decision')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="date d'ouverture" class="form-label fw-bold">Date d'ouverture <sup class="text-danger">*</sup></label>
                        <input value="{{ old('start_date') }}" type="date" min="{{ Carbon\Carbon::now()->addDays(1)->format('Y-m-d') }}" class="@error('start_date') is-invalid @enderror form-control" name="start_date" id="start_date">
                        @error('start_date')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="date de cloture" class="form-label fw-bold">Période d'inscription (Nombre des jours) <sup class="text-danger">*</sup></label>
                        <input type="number" min="15" value="15" class="@error('duration') is-invalid @enderror form-control" name="duration" id="duration">
                        @error('duration')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="decision" class="form-label fw-bold">Décision d'ouverture</label>
                        <div class="input-group">
                            <input type="text" placeholder="Numero de decision" class="form-control" name="decision" id="decision">
                            <input value="{{ old('decision_date') }}" type="date" class="form-control @error('decision_date') is-invalid @enderror" name="decision_date" id="decision_date">
                            @error('decision_date')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        </div>
                        <div class="input-group mt-2">
                            <input type="text" placeholder="Numero de l'accord" class="form-control" name="agreement" id="agreement">
                            <input value="{{ old('agreement_date') }}" type="date" class="form-control @error('agreement_date') is-invalid @enderror" name="agreement_date" id="agreement_date">
                            @error('agreement_date')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="decision_file" class="form-control @error('decision_file') is-invalid @enderror">
                        @error('decision_file')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-center text-md-end">
                <button type="button" class="btn btn-primary my-3 btn btn-success btn-lg fw-bold text-white mx-md-4" data-bs-toggle="modal" data-bs-target="#confirmation">
                    <i class="fas fa-plus"></i> Créer
                </button>
            </div>
            <div class="modal fade" id="confirmation" tabindex="-1" aria-labelledby="confirmationLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body fs-5">
                        <p class="p-4 fw-bold">
                          Veuillez vérifier les informations avant de les soumettre car <span class="text-danger">il n'y a aucune autre possibilité de les modifier</span>
                        </p>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkme">
                            <label class="form-check-label text-muted" for="checkme">
                                <i>Êtes-vous sûr de vouloir créer cette session?</i>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                      <button id="submit" type="submit" class="btn btn-outline-danger" disabled>Oui, continuer</button>
                    </div>
                  </div>
                </div>
              </div>
        </form>
    </div>

    <script>
        var checker = document.getElementById('checkme');
        var submit = document.getElementById('submit');
        checker.onchange = function() {
        submit.disabled = !this.checked;
        };
    </script>
@endsection
