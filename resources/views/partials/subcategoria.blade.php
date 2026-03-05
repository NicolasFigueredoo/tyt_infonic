@foreach ($subcategorias as $subcategoria)


<button
@if ($productoRoute == 1)
onclick="ajaxCategorias({{ $subcategoria->id }}, '{{ route('page.productos', ['id' => $subcategoria->id, 'productosVisible' => 1]) }}', 25)"

@else
onclick="ajaxCategorias({{ $subcategoria->id }}, '{{ route('page.productos', ['id' => $subcategoria->id, 'productosVisible' => 1]) }}', 1)"
    
@endif
    class="btn {{ (int)$subcategoria->id == (int)$categoriaSelect ? 'boldSubcategoria' : '' }}">
    {{ $subcategoria->name }}
</button>

@endforeach
