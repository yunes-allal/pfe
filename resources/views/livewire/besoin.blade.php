<div class="col col-xs-10 col-sm-8 col-md-6 col-lg-3 col-xl-3">
        <form wire:submit.prevent='store' method="post">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Faculte <sup class="text-danger">*</sup></label>
                  <select name="faculty_id" wire:change='hideDepartments'  wire:model="selectedFaculty" class="form-select" name="fac" id="fac">
                      <option selected hidden>Choisir la faculte</option>
                      @foreach ($faculties as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
              </div>
              @if (!is_null($selectedFaculty))
              <div class="mb-3">
                  <label class="form-label">Departement <sup class="text-danger">*</sup></label>
                      <select name="department_id" wire:change='hideSectors' wire:model="selectedDepartment" class="form-select" name="dep" id="dep">
                          <option selected hidden>Choisir le department</option>
                          @foreach ($departments as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                          @endforeach
                      </select>
                </div>
              @endif
              @if (!is_null($selectedDepartment))
                <div class="mb-3">
                  <label class="form-label">Filiere <sup class="text-danger">*</sup></label>
                  <select name="sector_id" wire:change='hideSpecialities' wire:model="selectedSector" class="form-select">
                      <option selected hidden>Choisir le filiere</option>
                  @foreach ($sectors as $item)
                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                  </select>
                </div>
              @endif
              @if (!is_null($selectedSector))
                <div class="mb-3">
                  <label class="form-label">Specialite <sup class="text-danger">*</sup></label>
                  <select name="speciality_id" wire:model="selectedSpeciality" class="form-select">
                      <option value="null" selected>Tous les specialites</option>
                  @foreach ($specialities as $item)
                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                  </select>
                </div>
              @endif
              @if (!is_null($selectedSpeciality))
                <div class="mb-3">
                  <label class="form-label">Sous-Specialite</label>
                  <select wire:model='selectedSubspeciality' name="subspeciality_id" class="form-select">
                      <option value="0" selected>Tous les sous specialites</option>
                      @foreach ($subspecialities as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                </div>
              @endif
              @if (!is_null($selectedSector))
                <div class="mb-3">
                  <label class="form-label">Nombre de postes <sup class="text-danger">*</sup></label>
                  <input wire:model='positions_number' name="positions_number" type="number" min="1"  class="form-control">
                </div>
              @endif
              <div class="text-center">
                  <button class="btn btn-success fw-bold" type="submit">Ajouter</button>
              </div>
        </form>
</div>
