@extends('errors.layout')

@php $espera = (int) ($exception->getHeaders()['Retry-After'] ?? 60); @endphp

@section('codigo', '429')
@section('mensaje', 'Calma brodeerrr, demasiados intentos')
@section('detalle')
    Por seguridad bloqueamos el acceso un momento. Vuelve a intentarlo en {{ $espera }} segundos.
@endsection