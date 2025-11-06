@extends('layouts.main')
@section('title', 'Resume | ' . $user->name)
@section('body-class', 'flex justify-center flex-col items-center p-5')

@section('content')
    <div class="container max-w-6xl w-full bg-black/85 p-8 rounded-xl shadow-lg shadow-white/5 text-[#e7e7e7]">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 bg-zinc-900/30 p-5 rounded-lg text-center">
                <img src="{{ asset('assets/img/profile.jpg') }}" alt="Profile Photo" class="w-32 h-32 object-cover rounded-full mx-auto">
                <h1 class="text-3xl font-bold mt-4 mb-1 text-white">{{ $user->name }}</h1>
                <p class="font-semibold text-lg text-gray-300">{{ $user->title }}</p>
                <p class="mt-4 text-gray-300">
                    {{ $user->email }}<br>
                    {{ $user->phone }}<br>
                    {{ $user->address }}
                </p>
                <div class="flex justify-center gap-4 my-4">
                    <a href="https://github.com/PontillaJaesel" target="_blank" class="py-2 px-6 rounded-md bg-[#8847b3] text-white font-semibold transition hover:bg-purple-700">GitHub</a>
                    <a href="https://www.linkedin.com/in/jaesel-pontilla-89715333b/" target="_blank" class="py-2 px-6 rounded-md bg-[#8847b3] text-white font-semibold transition hover:bg-purple-700">LinkedIn</a>
                </div>
                <hr class="border-t-2 border-zinc-700 my-6">
                <h2 class="text-2xl text-gray-300 text-center mb-4">Skills</h2>
                @foreach ($user->skills as $skill)
                    @php $parts = explode(":", $skill->skill, 2); @endphp
                    <div class="bg-purple-900/10 border border-[#8847b3] rounded-xl py-2.5 px-4 mb-3 w-10/12 mx-auto shadow-sm shadow-purple-500/10">
                        <ul class="text-left">
                            <li>
                                <strong class="text-white">{{ $parts[0] }}:</strong>
                                @if (isset($parts[1])) {{ $parts[1] }} @endif
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>

            <div class="lg:col-span-2 bg-zinc-900/50 p-5 rounded-lg">
                @php
                    $sectionBoxClass = "bg-purple-900/10 border border-[#8847b3] rounded-xl p-5 mb-6 shadow-sm shadow-purple-500/10";
                    $sectionDivider = "<hr class=\"border-t-2 border-zinc-700 my-6\">";
                @endphp

                <div class="section">
                    <h2 class="text-2xl text-gray-300 mb-4">Profile</h2>
                    <div class="{{ $sectionBoxClass }}">
                        <p class="text-justify">{!! nl2br(e($user->summary)) !!}</p>
                    </div>
                </div>
                {!! $sectionDivider !!}

                <div class="section">
                    <h2 class="text-2xl text-gray-300 mb-4">Education</h2>
                    @foreach ($user->education as $edu)
                        <div class="{{ $sectionBoxClass }}">
                            <p><strong class="text-white">{{ $edu->degree }}</strong> – {{ $edu->school }} ({{ $edu->year_range }})</p>
                            <ul class="list-disc list-inside ml-2">
                                <li><strong>Relevant Courses:</strong> {{ $edu->courses }}</li>
                            </ul>
                        </div>
                    @endforeach
                </div>
                {!! $sectionDivider !!}
                
                <div class="section">
                    <h2 class="text-2xl text-gray-300 mb-4">Organizations</h2>
                    @foreach ($user->organizations as $org)
                        <div class="{{ $sectionBoxClass }}">
                            <p><strong class="text-white text-lg">{{ $org->name }}</strong></p>
                            <ul class="mt-2 ml-4">
                                @foreach ($org->positions as $pos)
                                    <li class="mt-1">
                                        <strong>{{ $pos->role }}</strong> ({{ $pos->year_range }})
                                        <ul class="list-disc list-inside ml-4 text-gray-300">
                                            <li>{{ $pos->details }}</li>
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                {!! $sectionDivider !!}

                <div class="section">
                    <h2 class="text-2xl text-gray-300 mb-4">Experience</h2>
                    @foreach ($user->experience as $job)
                        <div class="{{ $sectionBoxClass }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-1 font-semibold text-white">
                                    <strong>{{ $job->position }}</strong><br>
                                    {{ $job->company }}<br>
                                    <small>{{ $job->year_range }}</small>
                                </div>
                                <div class="md:col-span-2 text-justify">{{ $job->details }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {!! $sectionDivider !!}

                <div class="section">
                    <h2 class="text-2xl text-gray-300 mb-4">Projects</h2>
                    @foreach ($user->projects as $project)
                         <div class="{{ $sectionBoxClass }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-1 font-semibold text-white">
                                    <strong>{{ $project->title }}</strong><br>
                                    {{ $project->organization }}<br>
                                    <small>{{ $project->year }}</small>
                                </div>
                                <div class="md:col-span-2 text-justify">{{ $project->details }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {!! $sectionDivider !!}
                
                <div class="admin-buttons flex justify-center gap-4">

                    <a href="{{ route('home') }}" 
                    class="flex-1 rounded-md bg-zinc-600 px-6 py-2 text-center font-semibold text-white transition hover:bg-zinc-500">
                    Back to Home
                    </a>

                    @auth
                        <a href="{{ route('resume.edit') }}" 
                        class="flex-1 rounded-md bg-[#8847b3] px-6 py-2 text-center font-semibold text-white transition hover:bg-purple-700">
                        Edit Portfolio
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf
                            
                            {{-- ▼▼▼ THESE ARE THE CLASSES THAT FIX THE BUTTON ▼▼▼ --}}
                            <a href="{{ route('logout') }}" 
                            class="block w-full rounded-md bg-zinc-400 px-6 py-2 text-center font-semibold text-black transition hover:bg-zinc-300"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </a>
                        </form>

                    @else
                        <a href="{{ route('login') }}" 
                        class="rounded-md bg-[#8847b3] px-6 py-2 font-semibold text-white transition hover:bg-purple-700">
                        Log In to edit portfolio
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection