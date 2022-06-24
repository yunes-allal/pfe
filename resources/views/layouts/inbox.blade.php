@php
    $messages = App\Models\Message::where('sent_to', $user)->orderBy('created_at', 'desc')->get();
@endphp

@extends('layouts.app')

@section('content')
    <div class="container my-5">
        @foreach ($messages as $message)
        <hr class="my-4">
        <header>
            <i class="far fa-envelope fs-5 text-muted mx-3"></i>
            <span class="fw-bold fs-5">
            @if ($message->subject == 'conforme' || $message->subject == 'non-conforme')
                Etat de dossier (conformité)
            @else
                @if ($message->subject == 'recours')
                    Demande de recours
                @else
                    {{ $message->subject }}
                @endif
            @endif
            </span>
            @php
                Carbon\Carbon::setLocale('fr');
                $date = Carbon\Carbon::parse($message->created_at);
            @endphp
            <small class="text-muted fw-light mx-3">{{ $date->format('j F Y H:i') }}</small>
        </header>


        <section class="mx-3 px-5 my-3">


            {!! str_replace("#", "<br>", $message->body) !!}

            {{--! Pour le candidat --}}
            @if ($message->subject == 'non-conforme')
                @if (App\Models\Message::where('user_id',Auth::id())->where('subject','recours')->count())
                <div class="my-3">
                    <a class="btn btn-sm btn-success text-white fw-bold disabled">
                        <i class="fas fa-check"></i> Demande de recours a été envoyée
                    </a>
                </div>
                @else
                <div class="my-3">
                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#recours">
                        <i class="fas fa-paper-plane me-2"></i> Envoyer un recours
                    </a>
                </div>
                @endif
            @endif

            {{--! Pour le SDP --}}
            @if ($message->subject == 'recours')
                <div class="my-3">
                    @php
                        $dossier = App\Models\Dossier::where('user_id',$message->user_id)->first();
                    @endphp

                    <button class="btn btn-sm btn-outline-info w-25">Apercu sur le dossier</button>
                    <form class="my-3" action="{{ route('dossier.conformed') }}" method="POST">
                        @csrf
                        <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                        <input type="hidden" name="user_id" value="{{ $message->user_id }}">
                        <input type="hidden" name="decision" value="1">
                        <button type="submit" class="btn btn-sm fw-bold text-white btn-success">Accepter</button>
                    </form>
                    <form class="my-3" action="{{ route('dossier.conformed') }}" method="POST">
                        @csrf
                        <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                        <input type="hidden" name="user_id" value="{{ $message->user_id }}">
                        <input type="hidden" name="decision" value="{{ $dossier->is_conformed }}">
                        <button type="submit" class="btn btn-sm fw-bold btn-danger">Rejeter</button>
                    </form>
                </div>
            @endif
        </section>


        <footer class="mx-3 px-5 fw-bold">
            Cordialement,<br>
            @php
                $sent_from = App\Models\User::where('id', $message->user_id)->select('name')->first();
            @endphp
            {{ $sent_from->name }}.
        </footer>
        @endforeach
        <hr class="my-4">
    </div>


    {{-- MODALS --}}
<div class="modal fade" id="recours" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="recoursLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="recoursLabel">Envoyer un demande de recours</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="alert alert-danger">
               <b>Attention,</b> tu peut demander de faire un recours une seule fois!
            </div>

            @php
                $sdp = App\Models\User::where('type', 'sdp')->select('id')->first();
            @endphp
            <form method="POST" action="{{ route('send.message') }}">
                @csrf
            @if ($sdp)
                <input type="hidden" name="sent_to" value="{{ $sdp->id }}">
            @endif
            <input type="hidden" name="subject" value="recours">
          <div class="mb-3">
            <label for="" class="form-label fw-bold">La demande de recours</label>
            <textarea class="form-control" name="body" id="body" rows="3" placeholder="Tapez votre demande ici.."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Envoyer</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection
