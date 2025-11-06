@extends('layouts.main')
@section('title', 'Login | Resume Project')
@section('body-class', 'flex justify-center items-center text-center flex-col')

@section('content')
    <div class="bg-[rgb(13,7,17)]/85 border border-[#8847b3] p-10 w-[400px] rounded-[15px] shadow-lg shadow-white/5 text-[#e7e7e7]">
        <h2 class="mb-5 text-white text-3xl">Login</h2>
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <input 
              type="text" 
              name="username" 
              placeholder="Username" 
              {{-- Changed w-[90%] and removed mx-auto --}}
              class="block w-full p-3 border border-zinc-700 rounded-full bg-zinc-900 text-[#e7e7e7]"
              required 
              value="{{ old('username') }}">
            
            <input 
              type="password" 
              name="password" 
              placeholder="Password" 
              {{-- Changed w-[90%] and removed mx-auto --}}
              class="block w-full p-3 border border-zinc-700 rounded-full bg-zinc-900 text-[#e7e7e7]"
              required>
              
            <button 
              type="submit"
              {{-- This button is already correct at w-full --}}
              class="w-full p-3 bg-gray-300 text-black text-base font-semibold rounded-full transition-colors hover:bg-gray-400">
              Login
            </button>
        </form>
        @if ($errors->any())
            <p class="text-red-500 mt-2.5 text-sm">{{ $errors->first() }}</p>
        @endif
        <p class="mt-4"><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Back to Home</a></p>
    </div>
@endsection