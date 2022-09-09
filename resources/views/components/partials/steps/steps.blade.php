@props(['current' => 1])

@php
    $activeClass = 'text-tkblue-500';
    $activeBgClass = 'bg-tkblue-500';
@endphp



<section>
<!-- mobile -->
<div {{ $attributes->merge(['class' => 'flex space-y-1 sm:hidden flex-col sm:flex-row overflow-x-auto justify-items-start steps ']) }}>
    <div class="flex items-center justify-center p-4 space-x-4 shadow-sm  rounded-md step {{ $current == 1 ? $activeBgClass : 'bg-white' }}">
        
        <h4 class="font-bold text-sm {{ $current == 1 ? 'text-white' : 'text-tkblue-500'}}">{{stepLabels()[1]}}</h4>
    </div>
    <div class="divider"></div>
    <div class="flex items-center justify-center p-4 space-x-4  shadow-sm rounded-md step {{ $current == 2 ? $activeBgClass : 'bg-white' }}">
        
        <h4 class="font-bold text-sm {{ $current == 2 ? 'text-white' : 'text-tkblue-500'}}">{{stepLabels()[2]}}</h4>
    </div>
    <div class="divider"></div>
    <div class="flex items-center justify-center p-4 space-x-4  shadow-sm rounded-md step {{ $current == 3 ? $activeBgClass : 'bg-white' }}">
        
        <h4 class="font-bold text-sm {{ $current == 3 ? 'text-white' : 'text-tkblue-500'}}">{{stepLabels()[3]}}</h4>
    </div>
    <div class="divider"></div>
    <div class="flex items-center justify-center p-4 space-x-4  shadow-sm rounded-md step {{ $current == 4 ? $activeBgClass : 'bg-white' }}">
        
        <h4 class="font-bold text-sm {{ $current == 4 ? 'text-white' : 'text-tkblue-500'}}">{{stepLabels()[4]}}</h4>
    </div>
    <div class="divider"></div>
    <div class="flex items-center justify-center p-4 space-x-4  shadow-sm rounded-md step {{ $current == 5 ? $activeBgClass : 'bg-white' }}">
        
        <h4 class="font-bold text-sm {{ $current == 5 ? 'text-white' : 'text-tkblue-500'}}">{{stepLabels()[5]}}</h4>
    </div>
    
</div>
<!-- desktop -->
<div {{ $attributes->merge(['class' => 'hidden sm:flex flex-col sm:flex-row overflow-x-auto justify-items-start steps ']) }}>
    <div class="relative flex {{ $current == 1 ? $activeClass : 'text-white' }} step">
        <svg width="230" height="60" viewBox="0 0 230 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_724_3819)">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M2 5C2 2.79086 3.79086 1 6 1H209.679C211.114 1 212.44 1.76914 213.152 3.01544L226.866 27.0154C227.569 28.2452 227.569 29.7548 226.866 30.9846L213.152 54.9846C212.44 56.2309 211.114 57 209.679 57H6C3.79086 57 2 55.2091 2 53V5Z"
                    fill="currentColor" />
            </g>
            <defs>
                <filter id="filter0_d_724_3819" x="0" y="0" width="229.393" height="60"
                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                    <feColorMatrix in="SourceAlpha" type="matrix"
                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                    <feOffset dy="1" />
                    <feGaussianBlur stdDeviation="1" />
                    <feColorMatrix type="matrix"
                        values="0 0 0 0 0.215686 0 0 0 0 0.254902 0 0 0 0 0.317647 0 0 0 0.08 0" />
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_724_3819" />
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_724_3819"
                        result="shape" />
                </filter>
            </defs>
        </svg>
        <div class="absolute top-5 left-4 step-label">
            <h4 class="font-bold text-sm {{ $current == 1 ? 'text-white' : 'text-tkblue-600'}}">{{stepLabels()[1]}}</h4>
        </div>
    </div>
    <div class="relative flex {{ $current == 2 ? $activeClass : 'text-white' }} step">
        <svg class="" width="227" height="60" viewBox="0 0 227 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_724_4235)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M210.152 3.01544C209.44 1.76914 208.114 1 206.679 1H6.89275C3.82146 1 1.89599 4.31793 3.41978 6.98456L14.866 27.0154C15.5687 28.2452 15.5687 29.7548 14.866 30.9846L3.41978 51.0154C1.89599 53.6821 3.82146 57 6.89275 57H206.679C208.114 57 209.44 56.2309 210.152 54.9846L223.866 30.9846C224.569 29.7548 224.569 28.2452 223.866 27.0154L210.152 3.01544Z" fill="currentColor" />
            </g>
            <defs>
            <filter id="filter0_d_724_4235" x="0.886841" y="0" width="225.506" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
            <feOffset dy="1"/>
            <feGaussianBlur stdDeviation="1"/>
            <feColorMatrix type="matrix" values="0 0 0 0 0.215686 0 0 0 0 0.254902 0 0 0 0 0.317647 0 0 0 0.08 0"/>
            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_724_4235"/>
            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_724_4235" result="shape"/>
            </filter>
            </defs>
            </svg>
            <div class="absolute top-5 left-8 step-label">
                <h4 class="font-bold text-sm {{ $current == 2 ? 'text-white' : 'text-tkblue-600'}}">{{stepLabels()[2]}}</h4>
            </div>
    </div>
    
    <div class="relative flex {{ $current == 3 ? $activeClass : 'text-white' }} step">
        <svg class="" width="227" height="60" viewBox="0 0 227 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_724_4235)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M210.152 3.01544C209.44 1.76914 208.114 1 206.679 1H6.89275C3.82146 1 1.89599 4.31793 3.41978 6.98456L14.866 27.0154C15.5687 28.2452 15.5687 29.7548 14.866 30.9846L3.41978 51.0154C1.89599 53.6821 3.82146 57 6.89275 57H206.679C208.114 57 209.44 56.2309 210.152 54.9846L223.866 30.9846C224.569 29.7548 224.569 28.2452 223.866 27.0154L210.152 3.01544Z" fill="currentColor" />
            </g>
            <defs>
            <filter id="filter0_d_724_4235" x="0.886841" y="0" width="225.506" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
            <feOffset dy="1"/>
            <feGaussianBlur stdDeviation="1"/>
            <feColorMatrix type="matrix" values="0 0 0 0 0.215686 0 0 0 0 0.254902 0 0 0 0 0.317647 0 0 0 0.08 0"/>
            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_724_4235"/>
            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_724_4235" result="shape"/>
            </filter>
            </defs>
            </svg>
            <div class="absolute top-5 left-8 step-label">
                <h4 class="font-bold text-sm {{ $current == 3 ? 'text-white' : 'text-tkblue-600'}}">{{ stepLabels()[3]}}</h4>
            </div>
    </div>
    
    <div class="relative flex {{ $current == 4 ? $activeClass : 'text-white' }} step">
        <svg class="" width="227" height="60" viewBox="0 0 227 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_724_4235)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M210.152 3.01544C209.44 1.76914 208.114 1 206.679 1H6.89275C3.82146 1 1.89599 4.31793 3.41978 6.98456L14.866 27.0154C15.5687 28.2452 15.5687 29.7548 14.866 30.9846L3.41978 51.0154C1.89599 53.6821 3.82146 57 6.89275 57H206.679C208.114 57 209.44 56.2309 210.152 54.9846L223.866 30.9846C224.569 29.7548 224.569 28.2452 223.866 27.0154L210.152 3.01544Z" fill="currentColor" />
            </g>
            <defs>
            <filter id="filter0_d_724_4235" x="0.886841" y="0" width="225.506" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
            <feOffset dy="1"/>
            <feGaussianBlur stdDeviation="1"/>
            <feColorMatrix type="matrix" values="0 0 0 0 0.215686 0 0 0 0 0.254902 0 0 0 0 0.317647 0 0 0 0.08 0"/>
            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_724_4235"/>
            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_724_4235" result="shape"/>
            </filter>
            </defs>
            </svg>
            <div class="absolute top-5 left-8 step-label">
                <h4 class="font-bold text-sm {{ $current == 4 ? 'text-white' : 'text-tkblue-600'}}">{{stepLabels()[4]}}</h4>
            </div>
    </div>
    
    <div class="relative flex {{ $current == 5 ? $activeClass : 'text-white'}} step">
        <svg width="212" height="60" viewBox="0 0 212 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_724_3927)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.41972 6.98456C1.89593 4.31793 3.82139 1 6.89268 1H206C208.209 1 210 2.79086 210 5V53C210 55.2091 208.209 57 206 57H6.89269C3.8214 57 1.89593 53.6821 3.41972 51.0154L14.8659 30.9846C15.5686 29.7548 15.5686 28.2452 14.8659 27.0154L3.41972 6.98456Z" fill="currentColor"/>
            </g>
            <defs>
            <filter id="filter0_d_724_3927" x="0.88678" y="0" width="211.113" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
            <feOffset dy="1"/>
            <feGaussianBlur stdDeviation="1"/>
            <feColorMatrix type="matrix" values="0 0 0 0 0.215686 0 0 0 0 0.254902 0 0 0 0 0.317647 0 0 0 0.08 0"/>
            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_724_3927"/>
            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_724_3927" result="shape"/>
            </filter>
            </defs>
            </svg>
            
            <div class="absolute top-5 left-8 step-label">
                <h4 class="text-sm font-bold {{ $current == 5 ? 'text-white' : 'text-tkblue-600'}}">{{stepLabels()[5]}}</h4>
            </div>
    </div>
  
</div>
</section>