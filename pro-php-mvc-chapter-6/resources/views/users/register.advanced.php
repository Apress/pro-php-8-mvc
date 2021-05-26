@extends('layout')
<h1 class="text-xl font-semibold mb-4">Register</h1>
<form
    method="post"
    action="{{ $router->route('register-user') }}"
    class="flex flex-col w-full space-y-4"
>
    @if(isset($_SESSION['errors']))
        <ol class="list-disc text-red-500">
            @foreach($_SESSION['errors'] as $field => $errors)
                @foreach($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endforeach
        </ol>
    @endif
    <input type="hidden" name="csrf" value="{{ csrf() }}" />
    <label for="name" class="flex flex-col w-full">
        <span class="flex">Name:</span>
        <input
            id="name"
            name="name"
            type="text"
            class="focus:outline-none focus:border-blue-300 border-b-2 border-gray-300"
            placeholder="Alex"
        />
    </label>
    <label for="email" class="flex flex-col w-full">
        <span class="flex">Email:</span>
        <input
            id="email"
            name="email"
            type="text"
            class="focus:outline-none focus:border-blue-300 border-b-2 border-gray-300"
            placeholder="alex.42@gmail.com"
        />
    </label>
    <label for="password" class="flex flex-col w-full">
        <span class="flex">Password:</span>
        <input
            id="password"
            name="password"
            type="password"
            class="focus:outline-none focus:border-blue-300 border-b-2 border-gray-300"
        />
    </label>
    <button
        type="submit"
        class="focus:outline-none focus:border-blue-500 focus:bg-blue-400 border-b-2 border-blue-400 bg-blue-300 p-2"
    >
        Register
    </button>
</form>
