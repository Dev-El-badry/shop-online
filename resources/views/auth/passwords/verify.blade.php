@extends('layouts.app')

@section('content')
<div>
    Hi {{ $name }},
    <br>
    Thank you for creating an account with us. Don't forget to complete your registration!
    <br>
    Please click on the link below or copy it into the address bar of your browser to confirm your email address:
    <br>

    <h2>{{ $code }}</h2>

    <br/>
</div>
@endsection