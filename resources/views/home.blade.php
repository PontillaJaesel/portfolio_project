@extends('layouts.main')
@section('title', 'Welcome | Jaesel Pontilla')
@section('body-class', 'flex justify-center items-center text-center flex-col')

@section('content')
    <div>
        <h1 class="text-6xl font-bold tracking-widest my-8 leading-tight text-white
                   [text-shadow:_0_0_5px_#8847b3,_0_0_10px_#8847b3,_0_0_20px_#8847b3]">
            HI, IT'S JAESEL
        </h1>
        <h2 class="text-xl tracking-wide max-w-lg text-gray-400 mb-8">
            I'm a Third-Year BS Computer Science Student
        </h2>
        <div class="flex gap-4 justify-center mt-12">
            <a href ="{{ route('resume.public', ['user' => 1]) }}" 
               class="bg-gray-300 text-black py-2.5 px-10 rounded-full text-lg font-semibold tracking-widest transition-colors hover:bg-gray-400">
               View Public Portfolio
            </a>
            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=pontillajaesell@gmail.com" 
               target="_blank" 
               class="border border-zinc-700 py-3 px-5 rounded-full text-lg font-semibold tracking-widest transition-colors hover:bg-zinc-800">
               Email
            </a>
        </div>
    </div>
@endsection