@php
    $criteres = Illuminate\Support\Facades\DB::table('criteres')->where('type','entretien')->get();
    $global = DB::table('criteres')->where('type', 'entretien')->sum('pts');
@endphp

<html lang="ar" dir="rtl">
    <head>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="p-4">
        <div class="container fw-bold fs-6 lh-lg">
            <div class="inline-block text-center fs-5">
              <div class="">الجمهورية الجزائرية الديمقراطية الشعبية</div>
            </div>
            <div>وزارة التعليم العالي و البحث العلمي</div>
            <div>جامعة 8 ماي 1945  قالمة </div>
            <div>كلية الرياضيات و الإعلام الآلي و علوم المادة</div>
            <div>لجنة المحادثة و الانتقاء</div>
            <div class="inline-block text-center">
                <div class="fs-4 my-1">القائمة الإسمية للمترشحين للالتحاق برتبة  أستاذ مساعد قسم ب للسنة المالية {{ now()->format('Y') }}</div>
            </div>
        </div>
        <div class="container-fluid m-4">
          <table class="table table-bordered">
            <tbody>
                <tr>
                    <th width="5%">الرقم التسلسلي</th>
                    <th width="5%">رقم السجل الخاص</th>
                    <th width="10%">إسم و لقب المترشح</th>
                    <th width="10%">المؤهل أو الشهادة</th>
                    <th width="10%">الشعبة</th>
                    <th width="10%">التخصص</th>
                    <th width="10%">{{ $criteres[0]->name_ar }} ({{ $criteres[0]->pts }} نقطة)</th>
                    <th width="10%">{{ $criteres[1]->name_ar }} ({{ $criteres[1]->pts }} نقطة)</th>
                    <th width="10%">{{ $criteres[2]->name_ar }} ({{ $criteres[2]->pts }} نقطة)</th>
                    <th width="10%">{{ $criteres[3]->name_ar }} ({{ $criteres[3]->pts }} نقطة)</th>
                    <th width="10%">المجموع ({{ $global }} نقاط)</th>
                </tr>
                @php
                   $i = 0
                @endphp
                @foreach ($candidates as $item)
                @php
                    $i++;
                    $notes = Illuminate\Support\Facades\DB::table('notes')->where('dossier_id', $item->id)->first();
                    $sector = Illuminate\Support\Facades\DB::table('besoins')
                                        ->join('sectors', 'sectors.id','besoins.sector_id')
                                        ->select('sectors.name')
                                        ->first();
                    $speciality = Illuminate\Support\Facades\DB::table('besoins')
                                        ->join('specialities', 'specialities.id','besoins.speciality_id')
                                        ->select('specialities.name')
                                        ->first();
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $item->user_id }}</td>
                    <td>{{ $item->family_name.' '.$item->name }}</td>
                    <td>
                        @if ($item->diploma_name=='doctorat')
                            دوكتوراه
                        @else
                            ماجيستر
                        @endif
                    </td>
                    <td>{{ $sector->name }}</td>
                    <td>{{ $speciality->name }}</td>
                    <td>{{ $notes->entretien_1 }}</td>
                    <td>{{ $notes->entretien_2 }}</td>
                    <td>{{ $notes->entretien_3 }}</td>
                    <td>{{ $notes->entretien_3 }}</td>
                    <td>{{ $notes->entretien_1+$notes->entretien_2+$notes->entretien_3+$notes->entretien_3 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="fw-bold text-start fs-6">
           <div>حرر بقالمة في : {{ now()->format('Y/m/d') }}</div>
        </div>

    </body>
    <script>
        window.print()
    </script>
</html>
