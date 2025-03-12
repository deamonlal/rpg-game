@extends('layouts.app')

@section('content')
    <h1>RPG Игра</h1>
    <p>Персонаж: {{ $character->name }} (Уровень {{ $character->level }})</p>

    <a href="/fight">Отправится на поиски монстра</a>
    <a href="/inventory">Найти торговца</a>

    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif
@endsection
