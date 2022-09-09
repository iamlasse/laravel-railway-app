<x-guest-layout>
    
    <div
        class="relative flex justify-center min-h-screen py-4 items-top bg-telekom-darkblue dark:bg-gray-900 sm:items-center sm:pt-0">
        @if (Route::has('login'))
            <div class="fixed top-0 right-0 hidden px-6 py-4 sm:block">
                @auth
                    @role('company-admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-sm underline text-telekom-100 dark:text-gray-500">Admin</a>
                    @endrole
                    @role('company-user')
                        <a href="{{ route('company.dashboard') }}"
                            class="text-sm underline text-telekom-100 dark:text-gray-500">Dashboard</a>
                    @endrole
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline dark:text-gray-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 text-sm text-gray-700 underline dark:text-gray-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="flex flex-col items-center w-full space-y-6">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <x-application-logo class="h-10 text-center text-white w-46" />
            </div>

            <div class="flex items-center justify-center w-full">
                <div class="w-full px-5 py-5 text-gray-500 bg-gray-800 rounded shadow-md sm:w-2/3 md:w-1/2 lg:w-1/3"
                    x-data="{cardOpen:false,cardData:cardData()}"
                    x-init="$watch('cardOpen', value => value?(cardData.countUp($refs.total,0,11608,null,0.8),cardData.sessions.forEach((el,i) => cardData.countUp(document.getElementById(`device${i}`),0,cardData.sessions[i].size,null,1.6))):null);setTimeout(()=>{cardOpen=true},100)">
                    <div class="flex w-full">
                        <h3 class="flex-1 text-lg font-semibold leading-tight">TOTAL SESSIONS</h3>
                        <div class="relative h-5 leading-none">
                            <button class="h-6 text-xl text-gray-500 hover:text-gray-300 focus:outline-none"
                                @click.prevent="cardOpen=!cardOpen">
                                <i class="mdi" :class="'mdi-chevron-'+(cardOpen?'up':'down')"></i>
                                <x-heroicon-s-chevron-up class="w-4 h-4" x-show="cardOpen" />
                                <x-heroicon-s-chevron-down class="w-4 h-4" x-show="!cardOpen" />
                            </button>
                        </div>
                    </div>
                    <div class="relative overflow-hidden transition-all duration-500" x-ref="card"
                        x-bind:style="`max-height:${cardOpen?$refs.card.scrollHeight:0}px; opacity:${cardOpen?1:0}`">
                        <div>
                            <div class="pb-4 lg:pb-6">
                                <h4 class="inline-block text-2xl font-semibold leading-tight text-white lg:text-3xl"
                                    x-ref="total">0</h4>
                            </div>
                            <div class="pb-4 lg:pb-6">
                                <div class="flex h-3 overflow-hidden transition-all duration-500 bg-gray-800 rounded-full"
                                    :class="cardOpen?'w-full':'w-0'">
                                    <template x-for="(item,index) in cardData.sessions">
                                        <div class="h-full" :class="`bg-${item.color}`"
                                            :style="`width:${item.size}%`"></div>
                                    </template>
                                </div>
                            </div>
                            <div class="flex -mx-4">
                                <template x-for="(item,index) in cardData.sessions">
                                    <div class="w-1/3 px-4" :class="{'border-l border-gray-700':index!==0}">
                                        <div class="text-sm">
                                            <span class="inline-block w-2 h-2 mr-1 align-middle rounded-full"
                                                :class="`bg-${item.color}`">&nbsp;</span>
                                            <span class="align-middle" x-text="item.label">&nbsp;</span>
                                        </div>
                                        <div class="text-lg font-medium text-white">
                                            <span :id="`device${index}`">0</span>%
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                let cardData = function() {
                    return {
                        countUp: function(target, startVal, endVal, decimals, duration) {
                            const countUp = new CountUp(target, startVal || 0, endVal, decimals || 0, duration || 2);
                            countUp.start();
                        },
                        sessions: [{
                                "label": "Phone",
                                "size": 60,
                                "color": "tkteal-800"
                            },
                            {
                                "label": "Tablet",
                                "size": 30,
                                "color": "tkteal-400"
                            },
                            {
                                "label": "Desktop",
                                "size": 10,
                                "color": "tkteal-200"
                            }
                        ]
                    }
                }
            </script>
        </div>
    </div>
    @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/countup@1.8.2/dist/countUp.min.js"></script>
@endpush
</x-guest-layout>

