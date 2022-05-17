@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Affectation des commissions</h3>
        <p class="">
            dans cette étape, vous devez attribuer chaque compte au chef de departement correspondant
        </p>
        <div class="table-responsive my-4">
            <table class="table bordereless ">
            <tbody>
                <tr>
                    <th>Nom de departement</th>
                    <th>Email du destinataire</th>
                    <th></th>
                </tr>
                @foreach ($commissions as $item)
                @php
                    $department = Illuminate\Support\Facades\DB::table('departments')->where('id','=',$item->department_id)
                                                        ->select('name')
                                                        ->get();
                @endphp
                <form action="{{ route('commission.mail') }}" action="POST">
                    @csrf
                    <tr>
                        <td>{{ $department[0]->name }}</td>
                        <td>
                            <input type="email" class="form-control" name="email" placeholder="exemple@email.com">
                        </td>
                        <input type="hidden" name="email_dep" value="{{ $item->email }}">
                        <input type="hidden" name="password" value="{{ $item->password }}">
                        <td class="text-center">
                            <button type="submit" class="btn btn-outline-primary">
                                Envoyer
                            </button>
                        </td>
                    </tr>
                </form>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
@endsection
