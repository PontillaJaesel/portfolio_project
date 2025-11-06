 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- The title will be provided by the page using this layout --}}
    <title>@yield('title', 'My Portfolio')</title>
    
    {{-- This one line loads all your compiled CSS, including Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 
      These are your original global background styles.
      We'll keep them here since they are complex and shared on every page.
    --}}
    <style>
        .image-gradient {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.5;
        }
        .layer-blur {
            height: 0;
            width: 30rem;
            position: absolute;
            top: 20%;
            right: 0;
            box-shadow: 0 0 700px 15px white;
            rotate: -30deg;
            z-index: -1;
        }
    </style>
</head>
{{-- 
  These are your base body styles from your old CSS.
  @yield('body-class') allows pages like 'login' to add more classes.
--}}
<body class="bg-black text-[#e7e7e7] min-h-screen font-sans leading-normal @yield('body-class')">
    
    {{-- The shared background elements --}}
    <img class="image-gradient" src="{{ asset('assets/img/gradient.png') }}" alt="gradient">
    <div class="layer-blur"></div>

    {{-- This is where the content from your other pages will be injected --}}
    <main>
        @yield('content')
    </main>

</body>
</html>