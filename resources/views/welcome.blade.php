<x-guest-layout>
    <div class="h-screen pb-14 bg-right bg-cover">
        <div class="container pt-10 md:pt-18 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center bg-sky-50">
            <!--左側-->
            <div class="flex flex-col w-full xl:w-3/6 justify-center lg:items-start overflow-y-hidden ">
                <h1 class="my-4 text-3xl md:text-5xl text-sky-600 font-bold leading-tight text-center md:text-left slide-in-bottom-h1">marcie</h1>
                <p class="leading-normal text-base md:text-2xl mb-8 text-center md:text-left slide-in-bottom-subtitle">
                    Laravel Site
                </p>
            
                <p class="text-blue-400 font-bold pb-8 lg:pb-6 text-center md:text-left fade-in">
                    welcome
                </p>
                <div class="flex w-full justify-center md:justify-start pb-6 lg:pb-0 fade-in ">
                    {{-- ボタン設定 --}}
                    <a href="{{route('contact.create')}}"><x-primary-button class="bg-sky-700">Contact</x-primary-button></a>
                    <a href="{{route('register')}}"><x-primary-button class="bg-sky-700 ml-2">Register</x-primary-button></a>
                </div>
            </div>
            {{-- 右側 --}}
            <div class="w-full xl:w-3/6 py-6 overflow-y-hidden">
                <img class="w-3/5 mx-auto lg:mr-0 slide-in-bottom rounded-lg shadow-xl bg-white" src="{{asset('white-flowers-flowers-field-depth-of-field-wallpaper-preview.jpg')}}">
            </div>
        </div>
        <div class="container pt-10 md:pt-18 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center">
            <div class="w-full text-sm text-center md:text-left fade-in border-2 p-4 text-sky-800 leading-8 mb-8">
                <P>laravel</p>
            </div>
            <!--フッタ-->
            <div class="w-full pt-10 pb-6 text-sm md:text-left fade-in">
                <p class="text-gray-500 text-center">@2023 marcie</p>
            </div>
        </div>
    </div>
</x-guest-layout>
