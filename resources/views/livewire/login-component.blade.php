<div class="mx-auto  rounded border-slate-700 border w-96 bg-white dark:bg-slate-800  z-20 relative">
    <form wire:submit.prevent="login">
        @csrf
        <div class="flex w-full justify-center">
            <img src="{{ asset('assets/logo-alerta.png') }}" alt="" class="w-40 h-full py-12">
        </div>
        <div class="px-6  mb-4">
            <label for="formName" class="block text-gray-700 text-sm font-semibold mb-2 dark:text-gray-400">Email:</label>
            <input type="text" autofocus class=" text-sm appearance-none border-gray-300 border rounded w-full py-2 px-5 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-400" autofocus wire:model.defer="email" wire:keydown.enter='login'>
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="px-6  mb-4">
            <label for="formName" class="block text-gray-700 text-sm font-semibold mb-2 dark:text-gray-400">Password:</label>
            <input type="password" class=" dark:text-gray-400 text-sm  appearance-none border-gray-300 border rounded w-full py-2 px-5 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model.defer="password" wire:keydown.enter='login'>
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="px-6 mb-4 text-right">
            <button wire:loading.remove wire:click="login" type="button" class="cursor-pointer inline-flex justify-center  sm:w-1/4 w-full rounded-md  border border-gray-300 border-transparent dark:hover:bg-slate-700 px-4 py-2 bg-gray-900 text-base leading-6 font-medium text-white dark:hover:text-gray-400  hover:bg-white hover:text-black hover:border-gray-300 border-black transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Login
            </button>
            {{-- loading --}}
            <button wire:loading wire:target='login' type="button" class=" inline-flex justify-center  sm:w-1/4 w-full rounded-md border-gray-300 border  border-transparent px-4 py-2 bg-gray-900 text-base leading-6 font-medium text-white  transition ease-in-out duration-150 sm:text-sm sm:leading-5 cursor-not-allowed ">
                <svg class="animate-spin mx-auto h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>

            {{-- <p class="text-xs text-center mt-4 "><a data-turbolinks="false"  href="{{ url('/') }}" >Continue to site. . </a></p> --}}
        </div>


    </form>

</div>
