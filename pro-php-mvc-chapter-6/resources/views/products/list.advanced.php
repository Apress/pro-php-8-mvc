@extends('layout')
<h1>All Products</h1>
<p>Show all products...</p>
@includes('includes/product-details', ['name' => 'acme'])
@if($next)
    <a href="{!! $next !!}">next</a>
@endif
