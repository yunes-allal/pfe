@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-warning alert-dismissible fade show p-3 text-center">
            <i class="fas fa-exclamation-circle fs-4"></i><br>
            <strong class="fs-5 px-2"> Faire attention!</strong><br>
            Vérifiez l'e-mail du destinataire avant l'envoi
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <h3 class="fw-bold">L'envoie de les comptes</h3>
        <i class="fw-light">
            @if (App\Models\Session::where('status','conformity')->count() && App\Models\Dossier::where('is_validated',1)->where('is_conformed', NULL)->count() != 0)
                ( Etape de validation des dossiers "conformité" )
            @else
                @if (App\Models\Session::where('status','conformity')->count())
                    ( Etape d'entretien)
                @else
                    ( Etape de vérification les traveaux scientifiques)
                @endif
            @endif
        </i>
        <div class="table-responsive my-4 card p-4 rounded-3 shadow-sm">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <table class="table table-bordered text-center">
            <tbody>
                <tr>
                    <th width="10%">Département</th>
                    <th width="20%">Date de début</th>
                    <th width="20%">Nombre des jours</th>
                    <th>
                        Email de destinataire (
                            @if (App\Models\Session::where('status','interview')->count())
                                Le CSD
                            @else
                                Le chef de département
                            @endif
                            )
                    </th>
                    <th width="10%">Envoyer</th>
                </tr>
                @foreach ($commissions as $item)
                @php
                    $department = Illuminate\Support\Facades\DB::table('departments')->where('id','=',$item->department_id)
                                                        ->select('name')
                                                        ->first();
                @endphp

                @if (!$item->sent_to || $start_date = $item->start_date==NULL)
                    <form action="{{ route('commission.mail') }}" action="POST">
                        @csrf
                        <tr>
                            <td>{{ $department->name }}</td>
                            <td>
                                <input value="{{ old('start_date') }}" type="date" min="{{ now()->format('Y-m-d') }}" class="form-control" name="start_date">
                            </td>
                            <td>
                                <input type="number" value="1" min="1" class="form-control" name="periode">
                            </td>
                            <td>
                                <input value="@if ($item->sent_to) {{ $item->sent_to }} @else {{ old('email') }}  @endif" type="email" class="form-control" name="email" placeholder="exemple@email.com">
                            </td>
                            <input type="hidden" name="email_dep" value="{{ $item->email }}">
                            <input type="hidden" name="password" value="{{ $item->password }}">
                            <td class="text-center">
                                <button type="submit" class="btn btn-outline-dark rounded">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </td>
                        </tr>
                    </form>
                @else
                <form action="{{ route('commission.redo.mail') }}" action="POST">
                    @csrf
                    <tr>
                        <td>{{ $department->name }}</td>
                        <td>
                            {{ date('d-m-Y', strtotime($item->start_date)) }}
                        </td>
                        <td>
                            {{ Carbon\Carbon::parse($item->end_date)->diffInDays(Carbon\Carbon::parse($item->start_date))}} Jours
                        </td>
                        <td>
                            {{ $item->sent_to }}
                        </td>
                        <td class="text-center">
                            <button type="submit" class="btn btn-outline-dark rounded">
                                <i class="fas fa-redo"></i> Renvoyer
                            </button>
                        </td>
                    </tr>
                    <input type="hidden" name="email" value="{{ $item->email }}">
                </form>
                @endif

                @endforeach
            </tbody>
            </table>
        </div>
    </div>
@endsection
