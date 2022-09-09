<div class="w-full h-screen min-h-screen grid-cols-12 overflow-hidden md:grid sm:overflow-auto ">
    <div class="sm:col-span-6 md:col-span-4">
        <div class="flex items-center justify-center h-screen">
            <main class="flex flex-col items-center flex-1 px-4 pt-6 sm:justify-center">
                <div class="flex items-center justify-center">
                    <a href="/">
                        <x-application-logo class="h-10 text-center text-white w-46" />
                    </a>
                </div>

                <div class="w-full px-6 py-4 my-6 overflow-hidden rounded-md sm:max-w-md dark:bg-dark-eval-1">
                    {{ $slot }}
                </div>

                {{ $footer ?? '' }}
            </main>
        </div>
    </div>
    <div class="hidden sm:block sm:col-span-6 md:col-span-8" style="background-size: cover ;background-image: url({{asset('images/loginimage.jpg')}});">
        <div class="empty">&nbsp;</div>
    </div>
</div>
