@php
$session = Illuminate\Support\Facades\DB::table('sessions')->where('on_going','true')->select('id')->first();
$candidates = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.Auth::user()->email.'" AND dossiers.is_conformed=1 AND '.$session->id.'= dossiers.session_id');
@endphp

@extends('layouts.app')


@section('content')
<div class="container">
    <div class="display-3">Liste des candidat</div>
    <div class="inline-block text-end px-4 mx-4">
            <a target="_blank" class="btn btn-info" href="{{ route('pv.entretien') }}">
                <i class="fas fa-print"></i> Générer PV
            </a>
    </div>
    <div class="table-responsive-md border p-4 m-4">
        <table class="table table-bordered text-center">
            <tbody>
                <tr>
                    <th>Nom et prenom</th>
                    <th width="33%">Application</th>
                    @php
                        $global = DB::table('criteres')->where('type', 'entretien')->sum('pts');
                    @endphp
                    <th width="30%">Note ({{ $global }}pts)</th>
                </tr>
                @forelse ($candidates as $item)
                    <tr>
                        <td class="fw-bold link-info" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#Dossier{{ $item->id }}">
                            {{ $item->family_name.' '.$item->name }}
                        </td>
                        <td>{{ $item->besoin_id }}</td>
                        <td>
                            @if (App\Models\Note::where('dossier_id', $item->id))
                                    @php
                                        $notes = DB::table('notes')->where('dossier_id', $item->id)->first();
                                    @endphp
                                    @if ($notes)
                                    {{ $notes->entretien_1+$notes->entretien_2+$notes->entretien_3+$notes->entretien_4 }}
                                    @else
                                    <button class="btn btn-info" data-bs-target="#Entretien{{ $item->id }}" data-bs-toggle="modal">Noter</button>
                                    @endif
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
                                    <div class="inline-block border text-center my-2">
                                        <h3 class="p-2">1. Reseignement personnels</h3>
                                    </div>
                                    <div>Nom et prenom: <span class="fw-bold">{{ $item->family_name.' '.$item->name }}</span></div>
                                    <div>Fils de: <span class="fw-bold"></span></div>
                                </section>
                                </div>
                        </div>
                        </div>
                    </div>

                    <div class="modal fade" id="Entretien{{ $item->id }}" tabindex="-1" aria-labelledby="EntretienLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body mt-3">
                                <form action="{{ route('noter.candiat') }}" method="POST">
                                    @csrf
                                <div class="container p-4">
                                    <input type="hidden" name="dossier_id" value="{{ $item->id }}">
                                    @php
                                        $i=1
                                    @endphp
                                    @foreach (Illuminate\Support\Facades\DB::table('criteres')->where('type','entretien')->get() as $item)
                                    <div class="mb-3">
                                        <label for="">{{ $item->name }} ({{ $item->name_ar }})</label>
                                        <input name="critere{{ $i }}" type="number" min="0" step="0.25" max="{{ $item->pts }}" value="0" class="form-control">
                                        @php
                                            $i++
                                        @endphp
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer border-top-0">
                                <button class="btn btn-light fw-bold" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-outline-danger fw-bold">Confirmer</button>
                                </form>
                            </div>
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
