<div x-data="{ open: @entangle('isReason') }">

    <div class="fixed z-50 inset-0 overflow-y-auto ease-out duration-400"  x-show="open" x-transition x-cloak style="display: none !important">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-100 dark:bg-gray-900 opacity-50"></div>
            </div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​

            <div class="px-4 py-6 inline-block align-bottom min-h-[450px] overflow-y-auto rounded-sm bg-white dark:bg-slate-700 text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div>
                    <div class="flex">
                        <div class="sm:w-8/12 w-full">
                            <h2 class="text-xl font-semibold dark:text-slate-400">{{ $alertId }} - {{ $alertStatus }}</h2>
                        </div>
                    </div>

                    <div class="flex flex-col mt-4 prose prose-sm break-words dark:text-slate-400">
                        <p class="text-sm text-left dark:text-slate-400"><strong class="dark:text-slate-400">Reason</strong>: {!! $alertReason !!}</p>
                    </div>
                </div>




                <div class=" px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-6 mb-6 bottom-0 right-0 absolute">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:loading.remove wire:click="fixAlert({{ $alertId }})" type="button" class=" cursor-pointer inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-black text-base leading-6 font-medium text-gray-200 dark shadow-sm  focus:outline-none  transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Fix Alert
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                        <button wire:loading.remove wire:click='closeReason' type="button" class=" cursor-pointer inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Close
                        </button>

                    </span>
                </div>
            </div>
        </div>
    </div>

</div>
