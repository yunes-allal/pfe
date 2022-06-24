@php
function getFaculty($id)
    {
        return DB::table('faculties')->select('name_ar')->where('id', $id)->first();
    }

function getSector($id)
    {
        return DB::table('sectors')->select('name_ar')->where('id', $id)->first();
    }
@endphp
<html lang="ar" dir="rtl">
    <head>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <style>
        @media print {
        footer{
            page-break-after: always;
        }
        }
    </style>
    <body>
        @foreach (App\Models\Commission::select('email','department_id')->get() as $item)
            @php
                $dossiers = DB::select('SELECT dossiers.* FROM `besoins`, `commissions`, `dossiers` WHERE dossiers.besoin_id = besoins.id AND commissions.department_id = besoins.department_id AND commissions.email = "'.$item->email.'"AND dossiers.is_conformed=1');
                $besoin = App\Models\Besoin::where('id', $dossiers[0]->besoin_id)->first();
                $faculty = getFaculty($besoin->faculty_id);
                $sector = getSector($besoin->sector_id);
            @endphp
            <div class="container fw-bold fs-6 lh-lg">
                <div class="inline-block text-center fs-5">
                  <div class="">الجمهورية الجزائرية الديمقراطية الشعبية</div>
                </div>
                <div>وزارة التعليم العالي و البحث العلمي</div>
                <div>جامعة 8 ماي 1945  قالمة </div>
                <div>كلية {{ $faculty->name_ar }}</div>
                <div>شعبة {{ $sector->name_ar }}</div>
                <div class="inline-block text-center">
                    <div class="fs-4 my-1">ملفات الترشح المقبولة</div>
                </div>
            </div>
            <div class="container-fluid m-4">
                <table class="table table-bordered">
                  <tbody>
                      <tr>
                          <th width="5%">الرقم التسلسلي</th>
                          <th width="10%">رقم السجل الخاص</th>
                          <th width="20%">إسم و لقب المترشح</th>
                          <th width="10%">تاريخ الميلاد</th>
                          <th width="10%">الشهادة</th>
                          <th width="10%">الشعبة</th>
                          <th width="10%">التخصص</th>
                          <th width="5%">الوضعية تجاه  الخدمة الوطنية</th>
                          <th width="5%">تاريخ إنقضاء التأجيل من الخدمة الوطنية(بالنسبة للمؤجل)</th>
                          <th width="5%">تاريخ إنقضاء سريان صحيفة السوابق القضائية رقم 03</th>
                          <th width="10%">ملاحظات</th>
                      </tr>
              @php
                  $i = 0
              @endphp
            @foreach ($dossiers as $item)
                @php
                    $i++
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $item->user_id }}</td>
                    <td>{{ $item->family_name_ar.' '.$item->name_ar }}</td>
                    <td>
                        @if ($item->diploma_name=='doctorat')
                            دوكتوراه
                        @else
                            ماجيستر
                        @endif
                    </td>
                    <td>{{ $item->birth_date }}</td>
                    <td>{{ $item->diploma_sector }}</td>
                    <td>{{ $item->diploma_speciality }}</td>
                    <td>/</td>
                    <td>/</td>
                    <td>/</td>
                    <td>مقبول</td>
                </tr>
            @endforeach
                </tbody>
            </table>
            <footer>
            <div>حرر بقالمة في : {{ now()->format('Y/m/d') }}</div>
        </footer>
        </div>
        <br><br>
        @endforeach
    </body>
    <script>
        window.print()
    </script>
</html>
