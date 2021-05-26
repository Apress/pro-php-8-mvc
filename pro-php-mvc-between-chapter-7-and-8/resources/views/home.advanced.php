@extends('layout')
@includes('includes/large-feature')
@foreach($products as $i => $product)
    <div class="
        z-10
        @if($i % 2 === 0)
            bg-gray-50
        @endif
    ">
        <div class="container mx-auto px-8 py-8 md:py-16">
            <h2 class="text-3xl font-bold">
                {{ $product->name }}
            </h2>
            <p class="text-xl my-4">
                {!! $product->description !!}
            </p>
            <a href="{{ $product->route }}" class="bg-indigo-500 rounded-lg p-2 text-white">
                Order
            </a>
        </div>
    </div>
@endforeach
