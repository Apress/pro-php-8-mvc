<div class="bg-gray-900 z-20">
    <div class="container mx-auto px-8 py-8 md:py-16 flex flex-col md:flex-row items-center text-center md:text-left">
        <div class="flex flex-shrink justify-end mb-8 md:-mb-20 pr-0 md:pr-16">
            @includes('rocket')
        </div>
        <div class="flex flex-col justify-center flex-grow">
            <a href="/" class="text-4xl text-white">
                Whoosh!
            </a>
            <div class="text-2xl text-gray-300">
                A place to buy rocket things
            </div>
            <ol class="text-white flex flex-row space-x-2">
                <li><a class="underline" href="/">Home</a></li>
                @if(isset($_SESSION['user_id']))
                    <li><a class="underline" href="/log-out">Log out</a></li>
                @endif
                @if(!isset($_SESSION['user_id']))
                    <li><a class="underline" href="/register">Register</a></li>
                @endif
            </ol>
        </div>
    </div>
</div>
