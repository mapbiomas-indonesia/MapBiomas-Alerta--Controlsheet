<div class="py-6 px-4 border border-gray-100 z-20 relative  bg-gray-50 mt-4">
    <div class="text-sm mb-6">
        <a class="text-base mb-1 font-semibold">Alert status by validator</a>
        <div class="mt-2">
            <input class="sm:w-52 w-full py-1 border-gray-500 border px-2 focus:outline-none text-xs" wire:model.live='searchName' placeholder="validator name">
        </div>
    </div>

    <div class="overflow-y-auto w-full">
        <table class="w-full border-collapse border-b border-gray-300">
          <thead class="text-xs font-semibold">
            <tr class="bg-gray-50 text-left">
              <th wire:click='sortingField("name")' class=" cursor-pointer border-b border-gray-300 px-2 py-2 capitalize">Validator</th>
              <th wire:click='sortingField("approved")' class="cursor-pointer border-b border-gray-300 px-2 py-2 capitalize ">Aprroved</th>
              <th wire:click='sortingField("reexportimage")' class="cursor-pointer border-b border-gray-300 px-2 py-2 capitalize">reexportimage</th>
              <th wire:click='sortingField("reclassification")' class="cursor-pointer border-b border-gray-300 px-2 py-2 capitalize">reclassification</th>
              <th wire:click='sortingField("rejected")' class="cursor-pointer border-b border-gray-300 px-2 py-2 capitalize">Rejected</th>
              <th wire:click='sortingField("duplicate")' class="cursor-pointer border-b border-gray-300 px-2 py-2 capitalize">Duplicate</th>
              <th wire:click='sortingField("preapproved")' class="cursor-pointer border-b border-gray-300 px-2 py-2 capitalize">pre-approved</th>
              <th wire:click='sortingField("refined")' class="cursor-pointer border-b border-gray-300 px-2 py-2 capitalize">refined</th>
              <th class="cursor-pointer border-b border-gray-300 px-2 py-2 capitalize">Sccon</th>
              <th class="cursor-pointer border-b border-gray-300 px-2 py-2 capitalize">Workspace</th>
              <th wire:click='sortingField("total")' class="cursor-pointer border-b border-gray-300 px-2 py-2 capitalize">TOTAL</th>
            </tr>
          </thead>
          <tbody class="text-xs">
            @forelse ($alerts as $item )
                <tr class="border-t hover:bg-gray-50">
                    <td class=" border-b border-gray-300 px-4 py-2 "><a href="{{ url('/alertanalis/'.$item->userId) }}" class="hover:underline">{{$item->name}}</a></td>
                    <td class=" border-b border-gray-300 px-4 py-2 bg-green-alerta-table-full">{{$item->approved}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2 bg-yellow-alerta-table-full">{{$item->reexportimage}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2 bg-yellow-alerta-table-full">{{$item->reclassification}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2 bg-merah-alerta-table-full">{{$item->rejected}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2 bg-merah-alerta-table-full">{{$item->duplicate}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2 bg-refined-alerta-table-full">{{$item->preapproved}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2 bg-refined-alerta-table-full">{{$item->refined}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2 bg-gray-alerta-table-full">{{$item->sccon}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2 bg-gray-alerta-table-full">{{$item->workspace}}</td>
                    <td class=" border-b border-gray-300 px-4 py-2 bg-gray-alerta-table-full">{{$item->total}}</td>
                </tr>
                @empty
                <tr>
                    <td class=" border-b border-gray-300 px-4 py-2">No data found</td>
                </tr>
            @endforelse


          </tbody>
        </table>
      </div>

      {{-- @if ($alerts)
      {{ $alerts->links('livewire.pagination') }}
      @endif --}}

</div>
