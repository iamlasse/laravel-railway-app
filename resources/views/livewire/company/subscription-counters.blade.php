

<ul class="grid items-stretch grid-cols-2 px-6 py-6 md:grid-cols-3 lg:grid-cols-5">
    <li class="flex-1">
      <div class="block h-full overflow-hidden border-2 bg-telekom-darkblue rounded-xl">
        <div class="p-4">
            <x-counter label="Mobilabonnemang" :count="$company->m_count" />
        </div>
      </div>
    </li>
    
    <li class="flex-1">
      <div class="block h-full overflow-hidden border-2 bg-telekom-darkblue rounded-xl">
        <div class="p-4">
            <x-counter label="Mobilt bredband" :count="$company->mb_count" />
        </div>
      </div>
    </li>
    
    <li class="flex-1">
      <div class="block h-full overflow-hidden border-2 bg-telekom-darkblue rounded-xl">
        <div class="p-4">
            <x-counter label="Datakort" :count="$company->dk_count" />
        </div>
      </div>
    </li>
    
    <li class="flex-1">
      <div class="block h-full overflow-hidden border-2 bg-telekom-darkblue rounded-xl">
        <div class="p-4">
            <x-counter label="Växelanvändare" :count="$company->uses_vaxel_count" />
        </div>
      </div>
    </li>
    
    <li class="flex-1">
      <div class="block h-full overflow-hidden border-2 bg-telekom-darkblue rounded-xl">
        <div class="p-4">
            <x-counter label="Tjänster att avsluta" :count="$company->to_be_cancelled_count" />
        </div>
      </div>
    </li>
    
   
  </ul>