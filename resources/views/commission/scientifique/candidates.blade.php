@php
$session = Illuminate\Support\Facades\DB::table('sessions')->where('status','!=','off')->select('id')->first();
$candidates = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.is_conformed = 1 AND dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.Auth::user()->email.'" AND '.$session->id.'= dossiers.session_id');

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
                    <th>Nom et prénom</th>
                    <th width="33%">Spécialité</th>
                    @php
                        $global = DB::table('criteres')->where('type', 'traveaux_scientifique')->sum('pts');
                    @endphp
                    <th width="30%">Note (4pts)</th>
                </tr>
                @forelse ($candidates as $item)
                    <tr>
                        <td class="fw-bold link-info" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#Dossier{{ $item->id }}">
                            {{ $item->family_name.' '.$item->name }}
                        </td>
                        <td>{{ $item->diploma_speciality }}</td>
                        <td>
                            @if (App\Models\Note::where('dossier_id', $item->id))
                                    @php
                                        $notes = DB::table('notes')->where('dossier_id', $item->id)->first();
                                    @endphp
                                    @if ($notes->ts_1)
                                    {{ $notes->ts_1+$notes->ts_2+$notes->ts_3+$notes->ts_4 }}
                                    @else
                                    <button class="btn fw-bold btn-success text-white" data-bs-target="#Traveaux{{ $item->id }}" data-bs-toggle="modal">Noter les traveaux</button>
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
                                    <img class="img-thumbnail" src="/storage/users_pictures/{{ $item->user_picture }}" alt="">
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

                    <div class="modal fade" id="Traveaux{{ $item->id }}" tabindex="-1" aria-labelledby="TraveauxLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body mt-3">
                                <div class="p-3 mx-3">
                                    <div class="alert alert-danger text-center">
                                        <strong>Faire attention!</strong><br>
                                        Saisissez le nombre d'articles/conférences et non leur note
                                    </div>
                                </div>
                                @php
                                    $criteres = App\Models\Criteres::where('type','traveaux_scientifique')->select('name','pts')->get();
                                @endphp
                                <form action="{{ route('noter.traveaux') }}" method="POST">
                                    @csrf
                                <div class="container p-3">
                                    <input type="hidden" name="dossier_id" value="{{ $item->id }}">
                                    <section class="p-3">
                                        <div class="mb-3">
                                            <label for="">Nombre des: {{ $criteres[0]->name }}( x{{ $criteres[0]->pts }}pts )</label>
                                            <input name="critere1" type="number" class="form-control" min="0"  value="{{ Illuminate\Support\Facades\DB::table('articles')->where('user_id',$item->user_id)->where('is_international', 0)->count() }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Nombre des: {{ $criteres[1]->name }}( x{{ $criteres[1]->pts }}pts )</label>
                                            <input name="critere2" type="number" class="form-control" min="0" value="{{ Illuminate\Support\Facades\DB::table('articles')->where('user_id',$item->user_id)->where('is_international', 1)->count() }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Nombre des: {{ $criteres[2]->name }}( x{{ $criteres[2]->pts }}pts )</label>
                                            <input name="critere3" type="number" class="form-control" min="0" value="{{ Illuminate\Support\Facades\DB::table('conferences')->where('user_id',$item->user_id)->where('is_international', 0)->count() }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Nombre des: {{ $criteres[3]->name }}( x{{ $criteres[3]->pts }}pts )</label>
                                            <input name="critere4" type="number" class="form-control" min="0" value="{{ Illuminate\Support\Facades\DB::table('conferences')->where('user_id',$item->user_id)->where('is_international', 1)->count() }}">
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0">
                                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Annuler</button>
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
