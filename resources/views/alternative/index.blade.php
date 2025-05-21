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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delay agar flash message sempat tampil, lalu scroll
            setTimeout(() => {
                const resultSection = document.getElementById('result');
                if (resultSection) {
                    resultSection.scrollIntoView({ behavior: 'smooth' });
                }
            }, 500); // Delay 0.5 detik
        });
    </script>
    @endif




    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-4">Add Alternative</h3>
                    <form id="altForm" method="POST" action="{{ route('alternative.store', $session_id) }}" class="space-y-4 mx-auto">
                        @csrf
                        <div>
                            <label for="altName" class="block text-sm font-medium text-gray-700">Nama Jalan</label>
                            <input type="text" id="altName" name="name" placeholder="Nama Jalan"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                    
                        <!-- Input Kriteria Dinamis -->
                        <div id="inputFields" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Akan diisi JS -->
                        </div>
                    
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">Simpan Alternatif</button>
                    </form>
                    
                </div> 
            </div>
        </div>  
    </div>
    <div class="py-1 mb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">    
                    <h3 class="text-xl font-semibold mb-4">Alternative</h3>  
                    <form action="{{ route('ranking.calculate', ['sessionId' => $session_id]) }}" method="POST" class="mb-4 mt-4">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg">
                            Hitung Ranking SAW
                        </button>
                    </form>                              
                    <table id="selection-table" class="min-w-full table-auto text-sm text-left text-gray-500">
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
                                @foreach ($criteria as $c)
                                    <th class="px-4 py-2">{{ $c->name_criteria }}</th>
                                @endforeach
                                <th>
                                    <span class="flex items-center">
                                        action
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alternatives as $alt)
                                <tr class="bg-white border-b hover:bg-gray-200">
                                    <td class="px-4 py-2 font-semibold">{{ $alt->name_alternative }}</td>
                                    @foreach ($criteria as $c)
                                        @php
                                            $grade = $alt->grades->firstWhere('id_criteria', $c->id);
                                        @endphp
                                        <td class="px-4 py-2">{{ $grade ? $grade->grade : '-' }}</td>
                                    @endforeach
                                    <td><a href="#" class="hover:text-blue-500">Eval</a></td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="{{ count($criteria) + 2 }}" class="px-4 py-2 text-center text-gray-500">Tidak ada alternatif.</td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>

                </div>
            </div>
        </div>     
    </div>

    <section id="result">
        @if ($rankings->count())
            <div class="py-1 mb-2">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">          
                            <h2 class="text-lg font-bold mb-2">Hasil Ranking SAW</h2>                          
                            <table id="ranking-table" class="min-w-full table-auto text-sm text-left text-gray-500">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="flex items-center">
                                                Rank
                                                <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                                </svg>
                                            </span>
                                        </th>
                                        <th>
                                            <span class="flex items-center">
                                                Alternative
                                                <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                                </svg>
                                            </span>
                                        </th>
                                        <th>
                                            <span class="flex items-center">
                                                Score
                                                <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                                </svg>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rankings as $rank)
                                        <tr class="bg-white border-b hover:bg-gray-200">
                                            <td class="px-4 py-2">{{ $rank->rank }}</td>
                                            <td class="px-4 py-2">{{ $rank->alternative->name_alternative }}</td>
                                            <td class="px-4 py-2">{{ number_format($rank->score, 4) }}</td>
                                        </tr>
                                    @endforeach                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>     
            </div>
        @endif
    </section>
        
    <script>
        let criteria = [], criteriaType = [], weights = [];
    
        async function loadCriteriaFromDB() {
            try {
                let response = await fetch("/api/criteria"); // sesuaikan route API Laravel kamu
                let data = await response.json();
    
                criteria = [];
                criteriaType = [];
                weights = [];
    
                data.forEach(k => {
                    criteria.push(k.nama);
                    criteriaType.push(k.jenis);
                    weights.push(parseFloat(k.bobot));
                });
    
                generateInputFields();
            } catch (error) {
                console.error("Gagal memuat kriteria dari database", error);
            }
        }
    
        function generateInputFields() {
            const container = document.getElementById("inputFields");
            container.innerHTML = "";
    
            criteria.forEach((label, i) => {
                let placeholder = label;
                if (label === "Volume Lalu Lintas") {
                    placeholder += " (/jam)";
                } else if (label === "Tingkat Kecelakaan") {
                    placeholder += " (/tahun)";
                } else if (label === "Kondisi Jalan" || label === "Aksesibilitas") {
                    placeholder += " (skala 1-10)";
                }
    
                container.innerHTML += `
                    <div>
                        <label for="criteria${i}" class="block text-sm font-medium text-gray-700 mb-1">${label}</label>
                        <input type="number" name="grades[${i}]" data-criteria-id="${i}" placeholder="${placeholder}"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                `;
            });
        }
    
        // Panggil saat halaman ready
        document.addEventListener("DOMContentLoaded", loadCriteriaFromDB);

                   
        if (document.getElementById("ranking-table") && typeof simpleDatatables.DataTable !== 'undefined') {

        let multiSelect = true;
        let rowNavigation = false;
        let table = null;

        const resetTable = function() {
            if (table) {
                table.destroy();
            }

            const options = {
                rowRender: (row, tr, _index) => {
                    if (!tr.attributes) {
                        tr.attributes = {};
                    }
                    if (!tr.attributes.class) {
                        tr.attributes.class = "";
                    }
                    if (row.selected) {
                        tr.attributes.class += " selected";
                    } else {
                        tr.attributes.class = tr.attributes.class.replace(" selected", "");
                    }
                    return tr;
                }
            };
            if (rowNavigation) {
                options.rowNavigation = true;
                options.tabIndex = 1;
            }

            table = new simpleDatatables.DataTable("#ranking-table", options);

            // Mark all rows as unselected
            table.data.data.forEach(data => {
                data.selected = false;
            });

            table.on("datatable.selectrow", (rowIndex, event) => {
                event.preventDefault();
                const row = table.data.data[rowIndex];
                if (row.selected) {
                    row.selected = false;
                } else {
                    if (!multiSelect) {
                        table.data.data.forEach(data => {
                            data.selected = false;
                        });
                    }
                    row.selected = true;
                }
                table.update();
            });
        };

        // Row navigation makes no sense on mobile, so we deactivate it and hide the checkbox.
        const isMobile = window.matchMedia("(any-pointer:coarse)").matches;
        if (isMobile) {
            rowNavigation = false;
        }

        resetTable();
        }

    </script>
    
</x-app-layout>
