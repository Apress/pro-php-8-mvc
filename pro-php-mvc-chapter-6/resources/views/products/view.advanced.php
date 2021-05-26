@extends('layout')
<h1>Product</h1>
@includes('includes/product-details', ['name' => $product])
