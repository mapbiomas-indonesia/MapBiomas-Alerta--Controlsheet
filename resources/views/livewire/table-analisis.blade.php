<div class="mt-2  py-6 px-4 border border-gray-100 z-20 relative  bg-gray-50 dark:bg-slate-800 dark:border-slate-800 dark:text-slate-400">
    <a class="text-base mb-1 font-semibold">Alert Need to Fix</a>
    <div x-data="{ open: @entangle('isReason') }">
        @include('partials.auditorReason')
    </div>
    <input class="sm:w-52 w-full py-1 bg-white border-gray-500 border px-2 focus:outline-none mt-2 text-xs dark:bg-slate-700 dark:border-slate-600 dark:text-slate-300" wire:model.live='search' placeholder="alert ID">
    <div class="mt-4">
        <table class="w-full divide-y divide-gray-200  rounded-sm  border border-gray-100 dark:border-slate-700">
            <thead class=" text-xs">
                <tr class="">
                    <th wire:click='sortingField("alertId")'  class="bg-gray-50 dark:bg-slate-700 dark:text-slate-400 px-6 py-4  cursor-pointer   text-left  text-gray-700 uppercase tracking-wider  sm:w-2/12 w-4/12">
                        <div class=" space-x-1 flex" >
                            <a class="text-xs">Alert ID</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                </svg>
                         </div>
                     </th>
                    <th wire:click='sortingField("created_at")' class="bg-gray-50 dark:bg-slate-700 dark:text-slate-400 px-6 py-4    text-left   text-gray-700 uppercase tracking-wider cursor-pointer sm:w-3/12 w-4/12 hidden sm:table-cell ">
                       <div class="flex space-x-1">
                           <a>Input date</a>
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </th>
                    <th  class="bg-gray-50 dark:bg-slate-700 dark:text-slate-400 px-6 py-4    text-left   text-gray-700 uppercase tracking-wider  sm:w-2/12 w-4/12 hidden sm:table-cell">
                        <div class="flex space-x-1">
                            <a>Region/Island</a>
                         </div>
                     </th>
                     <th  class="bg-gray-50 dark:bg-slate-700 dark:text-slate-400 px-6 py-4   text-left   text-gray-700 uppercase tracking-wider  sm:w-3/12 w-11/12 hidden sm:table-cell">
                        <div class=" space-x-1 " >
                            <a >Province</a>

                         </div>
                     </th>
                     <th wire:click='sortingField("auditorStatus")' class="bg-gray-50 dark:bg-slate-700 dark:text-slate-400 px-6 py-4   text-left   text-gray-700 uppercase tracking-wider cursor-pointer sm:w-4/12 w-4/12">
                        <div class="flex space-x-1">
                            <a>Auditor Status</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                             </svg>
                         </div>
                     </th>






                    <th class=" text-right bg-gray-50 dark:bg-slate-700 dark:text-slate-400   text-gray-700 uppercase tracking-wider w-1/12 hidden sm:table-cell">

                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700 dark:border-slate-700">
                @forelse ($databases as $item)
                <tr>
                    <td class="px-6 py-4 break-words text-xs  text-gray-700 dark:text-slate-400 ">
                        <a>{{$item->alertId}}</a>
                    </td>
                    <td class="px-6 py-4 break-words text-xs  text-gray-700 dark:text-slate-400 hidden sm:table-cell">
                        @php
                            $date = \Carbon\Carbon::parse($item->created_at)->locale(App::getLocale());
                            $date->settings(['formatFunction' => 'translatedFormat']);
                        @endphp</h1>
                        <a>{{ $date->format('d-m-Y')  }}</a>
                    </td>

                    <td class="px-6 py-4 break-words text-xs  text-gray-700 dark:text-slate-400 hidden sm:table-cell">
                        <a >{{$item->region}}</a>
                    </td>
                    <td class="px-6 py-4 break-words text-xs  text-gray-700 dark:text-slate-400 hidden sm:table-cell">
                        <a >{{$item->province}}</a>
                    </td>
                    <td class="px-6 py-4 break-words text-xs  text-gray-700 dark:text-slate-400">
                        @if (!$item->auditorStatus)
                            <a class="rounded-xs  bg-gray-300 px-2 py-1">Pending</a>
                        @elseif ($item->auditorStatus == 'approved')
                            <a  class="rounded-xs  bg-green-alerta px-2 py-1 text-gray-100">{{$item->auditorStatus}}</a>
                        @elseif ($item->auditorStatus == 'duplicate' or $item->auditorStatus == 'rejected')
                            <a  class="rounded-xs  bg-merah-alerta px-2 py-1 text-gray-100">{{$item->auditorStatus}}</a>
                        @else
                            <a  onclick="window.dispatchEvent(
                                new CustomEvent('open-reason-modal', {
                                    detail: { id: {{ $item->alertId}} }
                                })
                            )" @click.away="open = false" class="rounded-xs cursor-pointer  bg-yellow-alerta px-2 py-1 text-gray-100">{{$item->auditorStatus}}</a>
                        @endif
                    </td>

                    <td class="text-xs px-4">
                        <div class="relative flex justify-end" x-data="{ open: false }">

                            <a href="{{ url('/editalert/'.$item->alertId) }}" class=" focus:outline-none cursor-pointer" @click="open = true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                  </svg>
                            </a>


                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="whitespace-nowrap text-xs text-gray-700 px-6 py-3">
                        No data found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($databases)
    {{ $databases->links('livewire.pagination') }}
    @endif
</div>
