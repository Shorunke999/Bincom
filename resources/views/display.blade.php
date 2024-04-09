<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    The total vote/score of polling unit id {{$id}} is {{$score}}
                </div>
                <a href="{{route('dashboard')}}" class="flex justify-center mt-2 text-red-500" >Go back</a>
            </div>
        </div>
    </div>
</x-app-layout>
