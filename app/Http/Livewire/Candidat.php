<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dossier;
use App\Models\Session;

class Candidat extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $search = '';
    public $orderBy = 'family_name';
    public $orderAsc = true;

    public function render()
    {
        $session = Session::where('status','!=','off')->first();
        $candidats = Dossier::search($this->search)
                        ->where('is_validated',1)
                        ->where('session_id', $session->id)
                        ->orderBy($this->orderBy, $this->orderAsc? 'asc' : 'desc')
                        ->paginate($this->perPage);
        return view('livewire.candidat')->with('candidats', $candidats);
    }
}
