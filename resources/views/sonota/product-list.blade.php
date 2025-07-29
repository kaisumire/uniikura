@php
$currentSort = request()->input('sort', 'b.id');
$currentDirection = request()->input('direction', 'desc');

function sortLink($label, $column) {
    $currentSort = request()->input('sort', 'b.id');
    $currentDirection = request()->input('direction', 'desc');
    $direction = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';

    $query = request()->except('sort', 'direction', 'page');
    $query['sort'] = $column;
    $query['direction'] = $direction;

    $url = url()->current() . '?' . http_build_query($query);
    $arrow = ($currentSort === $column) ? ($currentDirection === 'asc' ? '▲' : '▼') : '';
    return '<a href="' . $url . '">' . $label . ' ' . $arrow . '</a>';
}
@endphp

@foreach ($products as $product)
<tr>
    <td>{{ $product->id }}</td>
    <td>
        @if ($product->img_path)
            <img src="{{ asset('storage/' . $product->img_path) }}" alt="画像" style="width: 50px;">
        @else
            <span>画像なし</span>
        @endif
    </td>
    <td>{{ $product->name }}</td>
    <td>{{ $product->kakaku }}円</td>
    <td>{{ $product->zaiko }}</td>
    <td>{{ $product->maker }}</td>
    <td>
        <a class="btn btn-sm btn-primary" href="{{ route('product.show', $product->id) }}">詳細</a>
        <button type="button"
                class="btn btn-sm btn-danger delete-btn"
                data-id="{{ $product->id }}"
                onclick="if(confirm('削除しますか？')) deleteProduct(this);">
            削除
        </button>
    </td>
</tr>
@endforeach
