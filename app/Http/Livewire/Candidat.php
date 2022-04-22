<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Candidat extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $search = '';
    public $orderBy = 'name';
    public $orderAsc = true;

    public function render()
    {
        $candidats = User::search($this->search)
                        ->orderBy($this->orderBy, $this->orderAsc? 'asc' : 'desc')
                        ->paginate($this->perPage);
        return view('livewire.candidat')->with('candidats', $candidats);
    }
}
