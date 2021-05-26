<div class="bg-gray-900 z-20">
    <div class="container mx-auto px-8 py-4 flex flex-col md:flex-row items-center text-center md:text-left">
        <div class="flex flex-shrink items-center pr-0 md:pr-4 h-32">
            @includes('rocket')
        </div>
        <div class="flex flex-col justify-center flex-grow">
            <a href="/" class="text-4xl text-white">
                Whoosh!
            </a>
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
