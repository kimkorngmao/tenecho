@extends('admin.layouts.app')

@section('content')
    <div>
        @if ($user)
            {{ $user->username }}
        @endif
    </div>
@endsection
