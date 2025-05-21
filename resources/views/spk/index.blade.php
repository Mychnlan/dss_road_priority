<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Decision Support System') }}
        </h2>
    </x-slot>
    @if (session('success'))
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => show = false, 3000)" 
        class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition ease-in-out"
    >
        {{ session('success') }}
    </div>
    @endif

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-4">Add Session</h3>
                    <form action="{{ route('dss-sessions.store') }}" method="POST">
                        @csrf
                        <input type="text" name="name_session" id="altName" class="border border-gray-300 p-2 rounded-md mb-4 w-full" placeholder="Name of Session" autofocus required>
                        <button type="submit" class="bg-green-500 text-white p-2 rounded-md mt-2 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Tambah
                        </button>
                    </form>          
                </div> 
            </div>
        </div>  
    </div>
    <div class="py-1 mb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">                                    
                    <table id="selection-table">
                        <thead>
                            <tr>
                                <th>
                                    <span class="flex items-center">
                                        Name
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                        </svg>
                                    </span>
                                </th>
                                <th data-type="date" data-format="YYYY/DD/MM">
                                    <span class="flex items-center">
                                        Created Date
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                        </svg>
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Last Update
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                        </svg>
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        action
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sessions as $session)
                                <tr>
                                    <td class="px-4 py-2">{{ $session->name_session }}</td>
                                    <td class="px-4 py-2">{{ $session->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-2">{{ $session->updated_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @php
                                            $hasWeights = DB::table('criteria_weights')
                                                ->where('session_id', $session->id)
                                                ->where('user_id', Auth::id())
                                                ->exists();
                                        @endphp
                                        <a href="{{ route('weight.form', $session->id) }}" class="hover:text-blue-500">
                                            {{ $hasWeights ? 'Edit Weight' : 'Add Weight' }}
                                        </a>
                                        <a href="{{ route('alternative', $session->id)}}" class="hover:text-blue-500">Eval</a>
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada sesi.</td>
                                </tr>  
                            @endforelse
                        </tbody>
                    </table>   
                </div>
            </div>
        </div>     
    </div>

    

</x-app-layout>
