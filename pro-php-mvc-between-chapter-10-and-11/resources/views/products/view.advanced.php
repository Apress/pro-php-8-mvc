@extends('layout')
@includes('includes/large-feature')
<div class="container mx-auto px-8 py-8 md:py-16">
    <h1 class="text-3xl font-bold">
        {{ $product->name }}
    </h1>
    <p class="text-xl my-4">
        {!! $product->description !!}
    </p>
    <h2 class="text-2xl font-bold">
        Order
    </h2>
    <form
        method="post"
        action="{{ $orderAction }}"
        class="flex flex-col w-full space-y-4 max-w-xl"
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
        <input type="hidden" name="csrf" value="{{ $csrf }}" />
        <label for="quantity" class="flex flex-col w-full">
            <span class="flex">Quantity:</span>
            <input
                id="quantity"
                name="quantity"
                type="number"
                class="bg-gray-50 rounded-lg p-2 text-gray-900"
                placeholder="1"
            />
        </label>
        <button
            type="submit"
            class="bg-indigo-500 rounded-lg p-2 text-white"
        >
            Order
        </button>
    </form>
</div>
