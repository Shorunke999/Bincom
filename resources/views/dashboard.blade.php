<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (session('relaymessage'))
        <div>
            {{session('relaymessage')}}
        </div>
    @endif
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form  method="post" action="{{route('switchForm')}}">
                        @csrf
                        <div class="mt-4">
                            Get polling unit score using Polling unit Id: <button 
                            class=" rounded bg-indigo-600 ml-2"  name="activeForm" value="active1">G0</button>
                        </div>
                    <div class="mt-4">
                            Get polling unit score for a LGA: <button  
                            class=" rounded bg-indigo-600 ml-2" type="submit" name="activeForm" value="active2" >Go</button>
                    </div>
                    <div class="mt-4">
                        Save party score for polling unit <button  
                        class=" rounded bg-indigo-600 ml-2" type="submit" name="activeForm" value="active3" >Go</button>
                    </div>
                    </form>
                    @if(session('activeForm') === 'active1')
                        <form method="POST" action="{{ route('submit_polling_unit_id') }}"
                        class="flex justify-center mt-4">
                            @csrf

                            <div class="flex justify-center">
                                <label for="polling_unit_id">Polling Unit ID:</label>
                                <input type="text" id="polling_unit_id" name="polling_unit_id" required>
                            </div>

                            <button type="submit" class=" rounded bg-indigo-600 ml-8">Submit</button>

                        </form>
                        <a href="{{route('dashboard')}}" class="flex justify-center mt-2 text-red-500" >Go back</a>
                    @elseif(session('activeForm') === 'active2')
                        <form method="POST" action="{{ route('process_for_LGA') }}"
                            class=" mt-4 ">
                                @csrf

                                <div class="grid grid-cols-1 gap-4">
                                    @foreach (session('data') as $item )
                                    <label for="{{$item->unique_id}}" class="inline-flex items-center"> {{$item->lga_name}}</label>
                                        <input type="checkbox" 
                                        id="{{$item->unique_id}}" name="selected_items[]" value="{{$item}}">
                                        
                                    @endforeach
                                </div>

                                <button type="submit" class="flex items-center rounded mt-8 bg-indigo-600">Submit</button>
                            </form>
                            <a href="{{route('dashboard')}}" class="flex justify-center">Go back</a>
                    @elseif(session('activeForm') ==='active3')
                        <form method="POST" action="{{ route('save') }}"
                        class="mt-4">
                            @csrf

                            <div class="flex justify-center ">
                                <label for="polling_unit_id">Polling Unit ID:</label>
                                <input type="text" id="polling_unit_id" name="polling_unit_id" required>
                            </div>

                            <div class="flex justify-center mt-3">
                                <label for="polling_unit_id">Your Name:</label>
                                <input type="text" name="name" required>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                @foreach (session('data') as $item )
                                <label for="{{$item}}" class="inline-flex items-center"> {{$item}}</label>
                                    <input type="text"  name="req[{{$item}}][score]" placeholder="Input score"> 
                                    <input type="hidden" name='req[{{$item}}][party_abbreviation]' value='{{$item}}'/>
                                @endforeach
                            </div>
                           
                            <button type="submit" class=" mt-16 rounded flex justify-center bg-indigo-600 ml-8">Submit</button>
                        </form>
                        <a href="{{route('dashboard')}}" class="flex justify-center mt-2 text-red-500" >Go back</a>
                    @endif
                        
                  
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
