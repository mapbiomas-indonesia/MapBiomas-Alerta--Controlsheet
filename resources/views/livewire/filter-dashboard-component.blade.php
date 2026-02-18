<div>
<div class="px-4 py-4 border-gray-100  border  bg-gray-50 dark:bg-slate-800 dark:border-slate-800">
    <a class=" text-base mb-1 font-semibold dark:text-slate-400">Filter</a>
    <div class="flex gap-4 mt-2">
        <div class="sm:w-36 w-full relative flex  flex-col  text-neutral-600 dark:text-neutral-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-2 size-5">
                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
            <select wire:ignore id='date-dropdown' wire:model.live="yearAlert" class=" w-full appearance-none text-black  border border-neutral-300 bg-white dark:bg-slate-700 dark:border-slate-700 dark:text-slate-400 px-4 py-2 text-sm focus:outline-none">
                <option value="all">All</option>
            </select>
        </div>
        <button wire:click='filter' class="bg-black dark:bg-slate-400 dark:text-slate-700 py-2 px-4 text-white sm:w-32 w-full cursor-pointer h-10 ">
            Submit
        </button>
    </div>

    <script>
        let dateDropdown = document.getElementById('date-dropdown');

        let currentYear = new Date().getFullYear();
        let earliestYear = 2020;
        while (currentYear >= earliestYear) {
            let dateOption = document.createElement('option');
            dateOption.text = currentYear;
            dateOption.value = currentYear;
            dateDropdown.add(dateOption);
            currentYear -= 1;
        }

    </script>
</div>
{{-- <div wire:loading class="flex w-full justify-center text-center bg-red-300 py-1 animate-pulse text-xs px-4 text-white mb-4" >loading. . .</div> --}}

</div>

