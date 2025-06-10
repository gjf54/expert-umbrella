@extends('layouts.dashboard_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/dashboard/tokens/main.css') }}">
@endsection

@section('title')
    Токены регистрации
@endsection

@section('content')
    @php($user = App\Models\User::where(['id' => Auth::user()->id])->first())
    <div class="tokens">
        <div class="d-flex flex-row align-items-center">
            <span role="title">Выделенные токены</span>
            <a href="{{ route('dashboard_tokens_token_form') }}" class="btn btn-primary <?= $user->can('god') ? '' : 'disabled' ?>" style="text-decoration:none;color:#FFF;font-weight:bold;margin-left:20px">+</a>
        </div>
        <div class="tokens_bar d-flex flex-row">
                @foreach ($tokens->reverse() as $token)
                    @if ($token->user == null)
                        <div class="token d-flex flex-row" id="<?= 'token-'.$token->id ?>">
                            <div class="token_background">
                                <span role="token">{{ '#' . $token->token }}</span>
                                @if($user->can('god'))<div id="remove_token_button" onclick="delete_token('{{ $token->id }}')"></div>@endif
                            </div>
                        </div>
                    @endif
                @endforeach
        </div>
    </div>
    <div class="activated_tokens">
        <span role="title">Использованные токены</span>
        <div class="tokens_bar d-flex flex-row">
            @foreach ($tokens->reverse() as $token)
                @if ($token->user != null)
                    <div class="activated_token d-flex flex-row">
                        <div class="token_background token_background_activated">
                            <span role="token">{{ '#' . $token->token }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        <div>
    </div>
@endsection

@section('scripts')
    <script>
        delete_token_url = "{{ route('process_delete_token') }}"
    </script>
    <script src="{{ asset('js/dashboard/tokens/tokens_page.js') }}"></script>
@endsection