@extends('layouts.app')

@section('content')
    <form action="{{ route('auth.authenticate') }}" method="POST" class="flex flex-col gap-2 max-w-md">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <label for="email" class="text-sm text-gray-700">Email</label>
        <input type="text" id="email" name="email" class="outline-0 ring ring-gray-300 focus:ring-black focus:border-black px-1">

        <label for="password" class="text-sm text-gray-700">Password</label>
        <input type="password" id="password" name="password" class="outline-0 ring ring-gray-300 focus:ring-black focus:border-black px-1">

        <button type="submit" class="cursor-pointer bg-black text-white px-4 w-fit mt-1">LOGIN</button>
    </form>
@endsection
