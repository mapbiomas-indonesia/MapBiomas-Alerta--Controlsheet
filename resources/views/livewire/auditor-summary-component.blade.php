<div class="py-6 px-4 border border-gray-100 z-20 relative  bg-gray-50 mt-4">
    <div class="flex sm:flex-row flex-col sm:gap-6 gap-2 mb-6">
        <div class="text-sm ">
            <a class="text-base mb-1 font-semibold">Alert by Auditor</a>
            <div class="w-full mt-1 flex gap-2" wire:ignore x-init="
            flatpickr('#rangeAuditor', {
                mode:'range',
                dateFormat: 'Y-m-d',
                {{-- locale: 'id', // ✅ Indonesian calendar labels, optional --}}
                onChange: function(selectedDates) {
                    if (selectedDates.length === 2) {
                        // Jakarta timezone formatter
                        let options = { timeZone: 'Asia/Jakarta', year: 'numeric', month: '2-digit', day: '2-digit' };

                        function formatDate(d) {
                            let parts = new Intl.DateTimeFormat('id-ID', options).formatToParts(d);
                            let y = parts.find(p => p.type === 'year').value;
                            let m = parts.find(p => p.type === 'month').value;
                            let day = parts.find(p => p.type === 'day').value;
                            return `${y}-${m}-${day}`;
                        }

                        let startDate = formatDate(selectedDates[0]);
                        let endDate   = formatDate(selectedDates[1]);

                        console.log(['Start:', startDate, 'End:', endDate]);

                        $wire.set('startDate', startDate);
                        $wire.set('endDate', endDate);
                        $wire.call('filter');

                    }
                }
            });
        "
            ">
            <input id="rangeAuditor" type="text" class="bg-white  text-gray-00   w-52 border border-gray-200  py-2 px-4 focus:outline-none  text-xs"  wire:model.defer='rangeAuditor' placeholder="Please select">

        </div>
        </div>
        <div class="flex gap-2 mb-6 ">
            <div class="flex flex-col">
                <a class="text-sm">Find who is <b>auditing</b> the alert</a>
                <input wire:keydown.enter="find"  type="text" class="bg-white  text-gray-00 mt-1  w-52 border border-gray-200  py-2 px-4 focus:outline-none  text-xs"  wire:model.defer='alertCode' placeholder="type alert ID">
            </div>

        </div>
        <div class="flex gap-2 mb-6 ">
            <div class="flex flex-col">
                <a class="text-sm">Find who is <b>validating</b> the alert</a>
                <input wire:keydown.enter="findValidator"  type="text" class="bg-white  text-gray-00 mt-1  w-52 border border-gray-200  py-2 px-4 focus:outline-none  text-xs"  wire:model.defer='alertCodeValidator' placeholder="type alert ID">
            </div>

        </div>

    </div>

    {{-- <pre>{{ json_encode($results, JSON_PRETTY_PRINT) }}</pre> --}}

    <div class="max-w-7xl mx-auto">
        <div class="">
            <div class="w-full overflow-x-auto">
                <table class="w-full min-w-max border-collapse border-b border-gray-300">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            {{-- Sticky first column --}}
                            <th class="sticky left-0 bg-gray-100 border-b border-gray-300 px-4 py-2 text-xs text-left z-10">
                                Auditor
                            </th>

                            {{-- Loop dynamic date columns --}}
                            @if (!empty($results))
                                @foreach (array_keys($results[array_key_first($results)]) as $key)
                                    @if ($key !== 'auditorName' and $key !== 'auditorId' and $key !== 'Total')
                                        <th
                                            class="border-b border-gray-300 px-4 py-2 text-xs text-center whitespace-nowrap cursor-pointer select-none"
                                            wire:click="sortBy('{{ $key }}')"
                                            title="Sort by {{ $key }}"
                                        >
                                            {{ $key }}
                                            @if ($dataField === $key)
                                            <span class="">{{ $dataOrder === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </th>
                                    @endif
                                @endforeach
                                {{-- Sticky Total column --}}
                                <th class="sticky right-0 bg-gray-100 border-b border-gray-300 px-4 py-2 text-xs text-center z-10 font-semibold cursor-pointer select-none"
                                    wire:click="sortBy('Total')">
                                Total
                                @if ($dataField === 'Total')
                                    <span class="text-xs">{{ $dataOrder === 'asc' ? '▲' : '▼' }}</span>
                                @endif


                                </th>


                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $row)
                            <tr class="hover:bg-gray-50">
                                {{-- Sticky first column --}}
                                <td class="sticky left-0 bg-gray-50 border-b border-gray-300 px-4 py-2 text-xs z-10 whitespace-nowrap">
                                    <a href="{{ url('/auditor-alert/'.$row['auditorId']) }}">{{ $row['auditorName'] }}</a>
                                </td>

                                {{-- Show counts per date (exclude Total for now) --}}
                                @foreach ($row as $key => $val)
                                    @if ($key !== 'auditorName' and $key !== 'auditorId' and $key !== 'Total')
                                        <td class="border-b border-gray-300 px-4 py-2 text-xs text-center">
                                            {{ $val }}
                                        </td>
                                    @endif
                                @endforeach

                                {{-- Sticky Total column --}}
                                <td class="sticky right-0 bg-gray-50 border-b border-gray-300 px-4 py-2 text-xs text-center z-10 font-semibold">
                                    {{ $row['Total'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
