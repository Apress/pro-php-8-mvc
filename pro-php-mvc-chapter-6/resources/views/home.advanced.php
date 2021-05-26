@extends('layout')
<h1 class="text-xl font-semibold">Welcome to Whoosh!</h1>
<p>Here, you can buy {{ $number }} rockets.</p>
<pre class="text-gray-500 text-sm mt-4">{{ print_r($featured, true) }}</pre>
