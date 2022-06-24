@php
$candidates = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.is_validated = 1 AND dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.Auth::user()->email.'" ORDER BY is_conformed');
@endphp

@extends('layouts.app')


@section('content')
<div class="container">
    <div class="display-3">Liste des candidat</div>
    <div class="inline-block text-end px-4 mx-4">
        <div class="dropdown">
            <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-print"></i> Générer PV
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <li><a target="_blank" class="dropdown-item text-success fw-bold" href="{{ route('pv.conforme') }}">Les candidats acceptés</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a target="_blank" class="dropdown-item text-danger fw-bold" href="{{ route('pv.non.conforme') }}">Les candidats rejetés</a></li>
            </ul>
          </div>
    </div>
    <div class="table-responsive-md border p-4 m-4">
        <table class="table table-bordered text-center">
            <tbody>
                <tr>
                    <th>Nom et prénom</th>
                    <th width="33%">Specialité</th>
                    <th width="30%">Conformité</th>
                </tr>
                @forelse ($candidates as $item)
                    <tr>
                        <td class="fw-bold link-info" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#Dossier{{ $item->id }}">
                            {{ $item->family_name.' '.$item->name }}
                        </td>
                        <td>{{ $item->diploma_speciality }}</td>
                        <td>
                            @if ($item->is_conformed)
                                @if ($item->is_conformed=="1")
                                    <div class="fw-bold text-success">
                                        <i class="fas fa-check"></i> Conforme
                                    </div>
                                @else
                                <div class="fw-bold text-danger">
                                    <i class="fas fa-times"></i> Non conforme
                                </div>
                                @endif
                            @else
                                <button class="btn btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#Conforme{{ $item->id }}">Conforme</button>
                                <button class="btn btn-outline-danger fw-bold" data-bs-toggle="modal" data-bs-target="#NonConforme{{ $item->id }}">Non-conforme</button>
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

                    <div class="modal fade" id="Conforme{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ConformeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class=" fs-5">
                                    Le dossier de {{ $item->family_name.' '.$item->name }} est-il conforme ?
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light fw-bold" data-bs-dismiss="modal">Non, annuler</button>
                                <form action="{{ route('dossier.conformed') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                                    <input type="hidden" name="dossier_id" value="{{ $item->id }}">
                                    <input type="hidden" name="decision" value="1">
                                    <button type="submit" class="btn btn-success text-white fw-bold">Oui, je suis sûr</button>
                                </form>

                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="modal fade" id="NonConforme{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="NonConformeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('dossier.conformed') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="fs-5">
                                        Le dossier de {{ $item->family_name.' '.$item->name }} est-il pas conforme ?
                                        <label for="Cause" class="p-2 mt-3 text-muted fs-6">Pourquoi? (en arabe)</label>
                                        <input class="form-control" value="مرفوض لعدم تطابق التخصص" minlength="5" name="decision" list="datalistOptions" id="exampleDataList" placeholder="ذكر السبب باللغة العربية">
                                        <datalist id="datalistOptions">
                                            <option value="مرفوض لعدم تطابق التخصص">
                                            <option value="مرفوض لعدم تطابق الشعبة">
                                        </datalist>
                                    </div>
                                    <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Non, annuler</button>
                                    <button type="submit" class="btn btn-danger fw-bold">Oui, je suis sûr</button>
                                </div>
                            </form>
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
