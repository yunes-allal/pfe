@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <tbody>
                    <tr>
                        <th width="20%"><small> Nom et prénom</small></th>
                        <th width="10%"><small> Correspondance de spécialisation de certificat(2pts)</small></th>
                        <th width="10%"><small> Appréciation du certificat(3pts)</small></th>
                        <th width="10%"><small> Les formations complémentaires(5pts)</small></th>
                        <th width="10%"><small> Travaux et études scientifiques(2pts)</small></th>
                        <th width="20%"><small> Les expérience professionnelles(4pts)</small></th>
                        <th width="10%"><small> Entretien avec le comité de sélection(4pts)</small></th>
                        <th width="10%"><small> Le total</small></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
