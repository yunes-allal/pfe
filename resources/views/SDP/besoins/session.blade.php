@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h3>Creation d'une nouvelle session</h3>
        <form class="px-3 py-5" action="{{ route('session') }}" method="post">
            @csrf
            <div class="row gx-5 gy-3">
                <div class="col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="session" class="form-label">Session <sup class="text-danger">*</sup></label>
                        <input type="month" class="form-control" name="name" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="nombre globale" class="form-label">Nombre globale de postes<sup class="text-danger">*</sup></label>
                        <input type="number" min="1" value="1" class="form-control" name="global_number" id="global_number">
                    </div>
                    <div class="mb-3">
                        <label for="condition" class="form-label">Condition <sup class="text-danger">*</sup></label>
                        <select class="form-select" name="onlyDoctorat" id="onlyDoctorat">
                            <option value="false" selected>Doctorat + Magister</option>
                            <option value="true">Doctorat seulement</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="date d'ouverture" class="form-label">Date d'ouverture <sup class="text-danger">*</sup></label>
                        <input onchange="changeDate()" type="date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" name="start_date" id="start_date">
                    </div>
                    <div class="mb-3">
                        <label for="date de cloture" class="form-label">Date de cloture <sup class="text-danger">*</sup></label>
                        <input type="date" min="" class="form-control" name="end_date" id="end_date">
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="decision" class="form-label">Decision d'ouverture <sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <input type="text" placeholder="Numero de decision" class="form-control" name="decision" id="decision">
                            <input type="date" class="form-control" name="decision_date" id="decision_date">
                        </div>
                        <div class="input-group mt-2">
                            <input type="text" placeholder="Numero de l'accord" class="form-control" name="agreement" id="agreement">
                            <input type="date" class="form-control" name="agreement_date" id="agreement_date">
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="file" placeholder="(optionnel)" class="form-control">
                    </div>
                </div>
            </div>
            <center><button style="width:20%" class="my-3 btn btn-outline-success" type="submit">Creer</button></center>

        </form>
    </div>

    <script>
        function changeDate(){
            let start_date = new Date(document.getElementById('start_date').value);
            const end_date = new Date();

            end_date.setDate(start_date.getDate() + 15);
            //document.getElementById('end_date').setAttribute("min", end_date);
            document.getElementById('end_date').value = end_date;
            console.log(end_date);
        }
    </script>
@endsection
