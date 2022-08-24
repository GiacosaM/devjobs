@php 
    $classes = "text-sm text-gray-600 hover:text-gray-900"
@endphp

<a {{ $attributes->merge(['class'=>$classes]) }}>
    {{$slot}}

</a> 

{{-- 
 <a class="underline text-sm text-gray-600 hover:text-gray-900" >
    {{ $slot }}
</a> --}}
