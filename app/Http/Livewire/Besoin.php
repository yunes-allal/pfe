<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Sector;
use App\Models\Speciality;
use App\Models\Subspeciality;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\True_;

class Besoin extends Component
{

    public $faculties, $departments, $sectors, $specialities, $subspecialities;
    public $selectedFaculty = NULL;
    public $selectedDepartment = NULL;
    public $selectedSector = NULL;
    public $selectedSpeciality = NULL;
    public $selectedSubspeciality = NULL;
    public $positions_number = 1;

    public function mount()
    {
        $this->faculties = Faculty::all();
        $this->departments = collect();
        $this->sectors = collect();
        $this->specialities = collect();
        $this->subspecialities = collect();
    }

    public function render()
        {
            return view('livewire.besoin');
        }


    public function updatedSelectedFaculty($faculty)
    {
        if (!is_null($faculty)) {
            $this->departments = Department::where('faculty_id', $faculty)->get();
        }
    }
    public function updatedSelectedDepartment($department)
    {
        if (!is_null($department)) {
            $this->sectors = Sector::where('department_id', $department)->get();
        }
    }
    public function updatedSelectedSector($sector)
    {
        if (!is_null($sector)) {
            $this->specialities = Speciality::where('sector_id', $sector)->get();
        }
    }
    public function updatedSelectedSpeciality($speciality)
    {
        if (!is_null($speciality)) {
            $this->subspecialities = Subspeciality::where('speciality_id', $speciality)->get();
        }
    }

    public function store(){
        $session = DB::table('sessions')->select('id', 'global_number')
                                    ->where('status','=','declaring')
                                    ->get();

        $global_positions = $session[0]->global_number;
        $positions = DB::table('besoins')->sum('positions_number');

        if($this->positions_number+$positions <= $global_positions){
            DB::table('besoins')->where('sector_id', '=', $this->selectedSector)
                                ->where('speciality_id', '=', $this->selectedSpeciality)
                                ->where('subspeciality_id', '=', $this->selectedSubspeciality)->first() ? $is_new = false : $is_new = true;
            if($is_new){
                if(!($this->selectedSpeciality && DB::table('besoins')->where('sector_id', '=', $this->selectedSector)->where('speciality_id', '=', NULL)->first())){

                    if(!($this->selectedSubspeciality && DB::table('besoins')->where('speciality_id', '=', $this->selectedSpeciality)->where('subspeciality_id', '=', NULL)->first())){

                        \App\Models\Besoin::create([
                            'session_id'=> $session[0]->id,
                            'faculty_id'=> $this->selectedFaculty,
                            'department_id'=> $this->selectedDepartment,
                            'sector_id'=> $this->selectedSector,
                            'speciality_id'=> $this->selectedSpeciality,
                            'subspeciality_id'=> $this->selectedSubspeciality,
                            'positions_number'=> $this->positions_number
                        ]);
                    }else{
                        return redirect()->route('besoins.index')->with('fail','Besoin existe déjà!');
                    }

                }else{
                    return redirect()->route('besoins.index')->with('fail','Besoin existe déjà!');
                }

            }else{
                return redirect()->route('besoins.index')->with('fail','Besoin existe déjà!');
            }

        return redirect()->route('besoins.index')->with('success','Besoin ajoutée avec succès');
        }else{
            return redirect()->route('besoins.index')->with('fail','Vous avez déclaré plus de postes d\'emploi que le nombre total');
        }
    }

    public function hideDepartments(){
        $this->selectedDepartment=NULL;
        $this->selectedSector=NULL;
        $this->selectedSpeciality=NULL;
    }
    public function hideSectors(){
        $this->selectedSector=NULL;
        $this->selectedSpeciality=NULL;
    }
    public function hideSpecialities(){
        $this->selectedSpeciality=NULL;
    }
}
