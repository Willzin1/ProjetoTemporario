@extends('templates.master')
@section('content')
    <section id="profile">
        @if(session()->has('success'))
            <div class="alert-custom alert-success-custom">
                <p>{{ session('success') }}</p>
            </div>
        @elseif(session()->has('error'))
            <div class="alert-custom alert-danger-custom">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        <h2 class="section-title">Meu Perfil</h2>
        <div class="profile-container">
            <div class="profile-picture">
                <img src="{{ asset('assets/images/avatar.png') }}" alt="Foto do Usuário">
            </div>

            <div class="profile-info">
                <h3>{{ $user->name }}</h3>
                <p><strong>Email: </strong>{{ $user->email }}</p>
                <p><strong>Telefone: </strong> {{ $user->phone }} </p>
                <!-- <p><strong>Localização:</strong> São Paulo, SP</p>-->
                <!-- Botão para editar perfil -->
                <a href="{{ route('users.edit', $user->id) }}"><button class="profile-button" id="edit-profile-btn">Editar Perfil</button></a>

                <li>
                    <form action="{{ route('login.destroy') }}" class="formulario" method="POST">
                        @csrf
                        <button type="submit" class="profile-button btn-red">Sair</button>
                    </form>
                </li>
            </div>
        </div>
    </section>

    <!-- PARTE DAS RESERVAS -->
    <section id="minhasReservas">
        <h2 class="section-title">Minhas Reservas</h2>

        @if($reservas->isEmpty())
            <p>Você ainda não tem reservas.</p>
        @else
            <div class="reservations">
                @foreach($reservas as $reserva)
                    <div class="reservation-card">
                        <p><strong>Data:</strong> {{ $reserva->data->format('d/m/y') }}</p>
                        <p><strong>Hora:</strong> {{ $reserva->hora->format('H:i') }}</p>
                        <p><strong>Quantidade cadeiras:</strong> {{ $reserva->quantidade_cadeiras }}</p>
                        <a href="{{ route('reservas.edit', ['reserva' => $reserva->id]) }}" class="button-link">Editar reserva</a>
                    </div>
                @endforeach
            </div>
        @endif

        <a href="{{ route('reservas.create') }}"><button class="profile-button btn-Res" id="make-reservation">Fazer Nova Reserva</button></a>
    </section>
@endsection
