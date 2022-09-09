@props(['plans' => [], 'total' => 0])

<div class="mt-6 text-tkblue-500">
    <x-table>
        <x-slot name="head">
            <x-table.row>
                <x-table.cell class="font-semibold text-tkblue-500">Tjänst</x-table.cell>
                <x-table.cell class="font-semibold text-center text-tkblue-500">Antal</x-table.cell>
                <x-table.cell class="font-semibold text-center text-tkblue-500">Ord. Pris</x-table.cell>
                <x-table.cell class="font-semibold text-center text-tkblue-500">Förhandlat Pris</x-table.cell>
                <x-table.cell class="font-semibold text-right text-tkblue-500">Totalt</x-table.cell>
            </x-table.row>
        </x-slot>
        <x-slot name="body">
    @forelse ($plans as $group)
        @if($group)
           
        @forelse ($group as $row)
        <x-table.row>
            <x-table.cell>{{ $row->name }}</x-table.cell>
            <x-table.cell class="text-center text-tkblue-500">{{ $row->plan_count }}</x-table.cell>
            <x-table.cell class="text-center text-tkblue-500">{{ $row->price }} Kr</x-table.cell>
            <x-table.cell class="text-center text-tkblue-500">{{ $row->price_new }} Kr</x-table.cell>
            <x-table.cell class="text-right text-tkblue-500">{{ number_format(($row->price_new ?? $row->price) * $row->plan_count, 0) }} Kr</x-table.cell>
        </x-table.row>
        @empty
            
        @endforelse
        @endif
        @empty
        
    @endforelse
        <x-slot name="footer">
            <x-table.row>
                <x-table.cell class="font-bold text-tkblue-500">Summa</x-table.cell>
                <x-table.cell class="font-bold text-center text-tkblue-500">{{ optional($plans->flatten())->sum('plan_count') }}</x-table.cell>
                <x-table.cell class="font-bold text-tkblue-500"></x-table.cell>
                <x-table.cell class="font-bold text-tkblue-500"></x-table.cell>
                <x-table.cell class="font-bold text-right text-tkblue-500">{{ number_format($total, 0) }} Kr</x-table.cell>
            </x-table.row>
        </x-slot>
</x-slot>   
</x-table>    
</div>
