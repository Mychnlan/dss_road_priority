<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-gray-900">             
                    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <!-- Road icon -->
                        <i class="fa-4x fa-solid fa-road"></i>

                        <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">Your Calculation Sessions</h5>
                        <p class="mb-3 font-normal text-gray-500">
                            You currently have <span class="font-semibold text-gray-800">{{ $sessionCount }}</span> road repair priority sessions.
                        </p>
                        <a href="{{ route('spk') }}" class="inline-flex items-center font-medium text-blue-600 hover:underline">
                            View all sessions 
                            <i class="pl-1 fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
