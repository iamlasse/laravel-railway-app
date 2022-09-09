@props(['companyData' => null])

<ul class="grid items-stretch grid-cols-2 px-6 py-6 md:grid-cols-3 lg:grid-cols-5">
    <li class="flex-1">
      <div class="block h-full overflow-hidden border-2 bg-telekom-darkblue rounded-xl">
        <div class="p-4">
            <x-counter label="Mobilabonnemang" :count="$companyData->m_count" />
        </div>
      </div>
    </li>
    
    <li class="flex-1">
      <div class="block h-full overflow-hidden border-2 bg-telekom-darkblue rounded-xl">
        <div class="p-4">
            <x-counter label="Mobila Bredband" :count="$companyData->mb_count" />
        </div>
      </div>
    </li>
    
    <li class="flex-1">
      <div class="block h-full overflow-hidden border-2 bg-telekom-darkblue rounded-xl">
        <div class="p-4">
            <x-counter label="Datakort" :count="$companyData->dk_count" />
        </div>
      </div>
    </li>
    
    <li class="flex-1">
      <div class="block h-full overflow-hidden border-2 bg-telekom-darkblue rounded-xl">
        <div class="p-4">
            <x-counter label="Växelanvändare" :count="$companyData->uses_vaxel_count" />
        </div>
      </div>
    </li>
    
    <li class="flex-1">
      <div class="block h-full overflow-hidden border-2 bg-telekom-darkblue rounded-xl">
        <div class="p-4">
            <x-counter label="Tjänster att avsluta" :count="$companyData->to_be_cancelled_count" />
        </div>
      </div>
    </li>
    
   
  </ul>