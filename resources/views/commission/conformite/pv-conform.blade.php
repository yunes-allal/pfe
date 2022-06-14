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
            <div class="inline-block text-center">
                <div class="fs-4 my-1">ملفات الترشح غير المقبولة</div>
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
                @foreach ($candidates as $item)
                @php
                    $i++
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $item->user_id }}</td>
                    <td>{{ $item->family_name_ar.' '.$item->name_ar }}</td>
                    <td>{{ $item->birth_date }}</td>
                    <td>
                        @if ($item->diploma_name=='doctorat')
                            دوكتوراه
                        @else
                            ماجيستر
                        @endif
                    </td>
                    <td>{{ $item->diploma_sector }}</td>
                    <td>{{ $item->diploma_speciality }}</td>
                    <td>//</td>
                    <td>//</td>
                    <td>//</td>
                    <td>
                        @if ($item->is_conformed=="1")
                            مقبول
                        @else
                            {{ $item->is_conformed }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        @php
            $members = App\Models\Commission::where('email',Auth::user()->email)->select('conformity_members')->first();

        @endphp
        <div class="fw-bold text-end fs-6">
            اعضاء اللجنة
            <br>
            {!! $members->conformity_members !!}
        </div>
        <div class="fw-bold text-start fs-6">
           <div>حرر بقالمة في : {{ now()->format('Y/m/d') }}</div>
        </div>

    </body>
    <script>
        window.print()
    </script>
</html>
