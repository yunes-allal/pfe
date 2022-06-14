@php
$session = Illuminate\Support\Facades\DB::table('sessions')->where('status','!=','off')->first();
    function getFaculty($id)
    {
        return DB::table('faculties')->select('name', 'abbr')->where('id', $id)->first();
    }

    function getSector($id)
    {
        return DB::table('sectors')->select('name')->where('id', $id)->first();
    }

    function getSpeciality($id)
    {
        return DB::table('specialities')->select('name')->where('id', $id)->first();
    }
    function getSubspeciality($id)
    {
        return DB::table('subspecialities')->select('name')->where('id', $id)->first();
    }
@endphp
<html>
    <head>
        <title>Imprimer Avis</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="modal-body lh-lg">
            <div class="text-center fs-6 fw-bold">
                République Algérienne Démocratique et Populaire<br>Ministère de l'Enseignement Supérieur et de la Recherche Scientifique<br>Université 08 Mai 1945 Guelma
            </div>
            <div class="text-center fst-italic fs-3 text-decoration-underline fw-bold my-2"><h2>Avis de recrutement</h2></div>
            <p>L'université du 8 mai 1945 de Guelma lance un avis de recrutement extérne de {{ $session->global_number }} maîtres assistants de classe `B` dans les spécialités suivantes:</p>
            <table class="table table-bordered">
                <tbody>
                    @php
                        $besoins = Illuminate\Support\Facades\DB::table('besoins')->where('session_id', $session->id)->get();
                    @endphp
                        <tr>
                            <th>Faculté</th>
                            <th>Filière</th>
                            <th>Spécilaité</th>
                            <th>Nombre de postes</th>
                        </tr>
                        @foreach ($besoins as $item)
                            @php
                                $faculty = getFaculty($item->faculty_id);
                                $sector = getSector($item->sector_id);
                                $speciality = 0;
                                $subspeciality = 0;
                                if($item->speciality_id){
                                    $speciality = getSpeciality($item->speciality_id);
                                }
                                if($item->subspeciality_id){
                                $subspeciality = getSubspeciality($item->subspeciality_id);
                                }
                            @endphp
                            <tr>
                                <td>{{ $faculty->name }}</td>
                                <td>{{ $sector->name }}</td>
                                <td>
                                    @if ($speciality)
                                        {{ $speciality->name }}
                                    @else
                                        Tous les specialités
                                    @endif
                                    @if ($subspeciality)
                                        ({{ $subspeciality->name }})
                                    @endif
                                </td>
                                <td>{{ $item->positions_number }}</td>
                            </tr>
                        @endforeach
                </tbody>

            </table>
            <div class="fs-6 fw-bold text-decoration-underline">Crières de sélection :</div>
            <ul>
                <li>Adéquation du profil de la formation du candidat avec les exigences du poste demandé ( 0 à 5 points ) .</li>
                <li>La formation complémentaire au diplôme exigé dans la même spécialité ( 0 à 5 points ) .</li>
                <li>Les travaux et études réalisés par le candidat dans sa spécialité ( 0 à 2 points ) .</li>
                <li>L'expérience professionnelle acquise par le candidat ( 0 & 4 points ) .</li>
                <li>Le résultat de l'entretien avec le jury de sélection ( 0 à 4 points ) .</li>
            </ul>
        </div>
    </body>
    <script>
        window.print()
    </script>
</html>
