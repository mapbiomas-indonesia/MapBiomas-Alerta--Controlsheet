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

                <thead class="bg-gray-100 text-gray-700">

                    <!-- HEADER ROW 1 -->
                    <tr>

                        <!-- Validator -->
                        <th rowspan="2 "
                            class="sticky left-0 bg-gray-100 border-b border-gray-300 px-4 py-2 text-left z-20">
                            Validator
                        </th>

                        <!-- Loop tanggal -->
                        @foreach($report['dates'] as $date)
                            <th colspan="2"
                                class=" px-4 py-2 text-center whitespace-nowrap bg-gray-200 border-r border-gray-300 border-l">
                                {{ $date }}
                            </th>
                        @endforeach

                        <!-- Total -->
                        <th colspan="2"
                            class="sticky right-0 bg-gray-300 border-b border-gray-300 px-4 py-2 text-center z-20">
                            Total
                        </th>

                    </tr>

                    <!-- HEADER ROW 2 -->
                    <tr>

                        @foreach($report['dates'] as $date)
                            <th class="w-24 border-b bg-gray-alerta-table-full border-gray-300 px-4 py-2 text-center border-l">
                                task
                            </th>

                            <th class="w-24 border-b bg-green-alerta-table-full border-gray-300 px-4 py-2 text-center border-r">
                                approved
                            </th>
                        @endforeach

                        <th colspan="1" class="w-28  sticky right-[112px] bg-gray-300 border-b border-gray-300 px-4 py-2 text-center z-20">
                            task
                        </th>

                        <th colspan="1" class="w-28  sticky right-0 bg-[#a1ddb5] border-b border-gray-300 px-4 py-2 text-center z-20">
                            approved
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($report['data'] as $row)

                        <tbody x-data="{ open:false }">

                            <tr @click="open = !open"
                                class="hover:bg-gray-50 cursor-pointer">

                                <!-- Validator name (sticky left, collapse tetap) -->
                                <td class="sticky left-0 bg-white border-b border-gray-300 px-4 py-2 z-10 whitespace-nowrap font-medium">

                                    <div class="flex items-center gap-2">

                                        {{ $row['validatorName'] }}

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

                                    <!-- collapse content tetap -->
                                    <div x-show="open" class="mt-2 w-full bg-gray-100 px-2 py-2">

                                        Insert: {{ $row['category']['Insert'] ?? 0 }} <br>
                                        Reject: {{ $row['category']['Reject'] ?? 0 }} <br>
                                        Reclassification: {{ $row['category']['reclassification'] ?? 0 }} <br>
                                        Reexport Image: {{ $row['category']['reexportimage'] ?? 0 }} <br>
                                        Refined: {{ $row['category']['refined'] ?? 0 }} <br>
                                        Approved: {{ $row['category']['approved'] ?? 0 }}

                                    </div>

                                </td>


                                <!-- Loop tanggal -->
                                @foreach($report['dates'] as $date)

                                    <td class="border-b border-gray-300 px-4 py-2 text-center bg-gray-alerta-table-full border-l">
                                        {{ $row['dates'][$date]['task'] ?? 0 }}

                                    </td>

                                    <td class="border-b border-gray-300 px-4 py-2 text-center bg-green-alerta-table-full border-r ">
                                        {{ $row['dates'][$date]['approved'] ?? 0 }}
                                    </td>

                                @endforeach


                                <!-- total task -->
                                <td class="w-28 sticky right-[112px] bg-gray-300 border-b border-gray-300 px-4 py-2 text-center font-semibold z-10 ">
                                    {{ $row['grandTotal'] ?? 0 }}
                                </td>

                                <!-- total approved -->
                                <td class="w-28 sticky right-0  border-b border-gray-300 px-4 py-2 text-center font-semibold z-10 bg-[#a1ddb5]">
                                    {{ $row['grandApproved'] ?? 0 }}
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
