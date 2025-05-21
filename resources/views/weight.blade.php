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
                    <h3 class="text-xl font-semibold mb-4"></h3>
                    <form action="{{ route('ahp.calculate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{ $sessionId }}">
                        
                        <table class="table-auto w-full mb-4 border">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">Kriteria 1</th>
                                    <th class="border px-4 py-2">Kriteria 2</th>
                                    <th class="border px-4 py-2">Nilai Perbandingan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pairwiseComparisons as $pair)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $pair['kriteria1']->name_criteria }}</td>
                                        <td class="border px-4 py-2">{{ $pair['kriteria2']->name_criteria }}</td>
                                        <td class="border px-4 py-2">
                                            <input type="number" 
                                            name="comparisons[{{ $pair['kriteria1']->id }}][{{ $pair['kriteria2']->id }}]" 
                                            min="1" max="9" step="0.01" required 
                                            value="{{ old('comparisons.' . $pair['kriteria1']->id . '.' . $pair['kriteria2']->id, $pair['value']) }}"
                                            class="border p-1 w-full">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            {{ isset($weights) && $weights->isNotEmpty() ? 'Update AHP Weights' : 'Calculate AHP Weights' }}
                        </button>     
                        @if (isset($weights) && $weights->isNotEmpty())
                            <a href="{{ route('alternative', $sessionId) }}" 
                            class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mt-4">
                                Proceed to Calculation
                            </a>
                        @endif
                                       
                    </form>
                          
                </div> 
            </div>
        </div>  
    </div>

</x-app-layout>
