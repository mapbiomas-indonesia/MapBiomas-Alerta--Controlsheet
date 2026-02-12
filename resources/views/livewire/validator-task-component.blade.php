<div class="py-6 px-4 border border-gray-100 z-20 relative  bg-gray-50 mt-4">
    <div class="text-sm mb-6">
        <a class="text-base mb-1 font-semibold">Alert by Validator</a>
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
                }
            }
        });
     "
        ">
            <input id="rangeAuditor" type="text" class="bg-white  text-gray-00   w-52 border border-gray-200  py-2 px-4 focus:outline-none  text-xs"  wire:model.defer='rangeAuditor' placeholder="Please select">

        </div>
    </div>

    <div>


    <div class="bg-white shadow overflow-hidden">
        <div class="w-full overflow-x-auto">

            <table class="w-full min-w-max border-collapse border-b border-gray-300 text-xs">

                <!-- HEADER -->
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <!-- Sticky first column -->
                        <th class="sticky left-0 bg-gray-100 border-b border-gray-300 px-4 py-2 text-left z-20">
                            Validator
                        </th>

                        <!-- Dynamic Dates -->
                        @foreach($report['dates'] as $date)
                            <th class="border-b border-gray-300 px-4 py-2 text-center whitespace-nowrap">
                                {{ $date }}
                            </th>
                        @endforeach

                        <!-- Total -->
                        <th class="border-b border-gray-300 px-4 py-2 text-center whitespace-nowrap">
                            Total
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($report['data'] as $row)

                        <!-- Wrap each validator -->
                        <tbody x-data="{ open:false }">

                            <!-- MAIN ROW -->
                            <tr @click="open = !open"
                                class="hover:bg-gray-50 cursor-pointer">

                                <!-- Sticky Name + Expand -->
                                <td class="sticky left-0 bg-white border-b border-gray-300 px-4 py-2 z-10 whitespace-nowrap font-medium">

                                    <div class="">

                                        <div class="flex items-center gap-2">
                                            {{ $row['validatorName'] }}

                                            <!-- Arrow -->
                                            <svg class="w-3 h-3 text-gray-400 transition-transform duration-200"
                                                :class="{ 'rotate-90': open }"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                        <div x-show="open" class="mt-2 w-full bg-gray-100 px-2 py-2">
                                            <div class="w-4/12 flex justify-between items-center">
                                                <div class="w-full flex items-start justify-between">
                                                    <a class="text-gray-600"> Add new: </a>
                                                    <a class="text-gray-600"> {{ $row['category']['Insert'] ?? 0 }}</a>
                                                </div>
                                            </div>
                                            <div class="w-4/12 flex justify-between items-center">
                                                <div class="w-full flex items-start justify-between">
                                                    <a class="text-gray-600"> Reject: </a>
                                                    <a class="text-gray-600"> {{ $row['category']['Reject'] ?? 0 }}</a>
                                                </div>
                                            </div>
                                            <div class="w-4/12 flex justify-between items-center">
                                                <div class="w-full flex items-start justify-between">
                                                    <a class="text-gray-600"> Reclassification: </a>
                                                    <a class="text-gray-600"> {{ $row['category']['reclassification'] ?? 0 }}</a>
                                                </div>
                                            </div>
                                            <div class="w-4/12 flex justify-between items-center">
                                                <div class="w-full flex items-start justify-between">
                                                    <a class="text-gray-600"> Reexport Image: </a>
                                                    <a class="text-gray-600"> {{ $row['category']['reexportimage'] ?? 0 }}</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                <!-- Date Values -->
                                @foreach($report['dates'] as $date)
                                    <td class="border-b border-gray-300 px-4 py-2 text-center">
                                        {{ $row['dates'][$date] ?? 0 }}
                                    </td>
                                @endforeach

                                <!-- Grand Total -->
                                <td class="border-b border-gray-300 px-4 py-2 text-center font-semibold">
                                    {{ $row['grandTotal'] }}
                                </td>
                            </tr>



                        </tbody>

                    @endforeach

                </tbody>
            </table>

        </div>
    </div>


</div>



</div>
