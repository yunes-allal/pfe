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
                    <th width="10%">الرقم التسلسلي</th>
                    <th width="10%">رقم السجل الخاص</th>
                    <th width="20%">إسم و لقب المترشح</th>
                    <th width="20%">تاريخ الميلاد</th>
                    <th width="20%">سبب الرفض بالتفصيل (وثائق ناقصة أو منتهية الصلاحية أو أي سبب آخر )</th>
                    <th width="20%">ملاحظة</th>
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
                    <td>{{ $item->family_name.' '.$item->name }}</td>
                    <td>{{ $item->birth_date }}</td>
                    <td>
                        @if ($item->is_conformed=="1")
                            مقبول
                        @else
                            {{ $item->is_conformed }}
                        @endif
                    </td>
                    <td></td>
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
