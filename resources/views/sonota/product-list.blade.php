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

<table class="table table-borderd">
    <tr>
        <th>{!! sortLink('No', 'b.id') !!}</th>
        <th>画像</th>
        <th>{!! sortLink('名前', 'b.name') !!}</th>
        <th>{!! sortLink('価格', 'b.kakaku') !!}</th>
        <th>{!! sortLink('在庫', 'b.zaiko') !!}</th>
        <th>{!! sortLink('メーカー名', 'b.str') !!}</th>
        <th>
        <div class="text-left mb-3">
            <a class="btn btn-success" href="/products/create">新規登録</a>
        </div>
        </th>
    </tr>
    @foreach ($products as $product)
    <tr>
        <td style="text-align: left;">{{ $product->id }}</td>
        <td>
            @if ($product->img_path)
            <img src="{{ asset('storage/' . $product->img_path) }}" alt="Product Image" style="width: 50px;">
            @else
                <span>画像なし</span>
            @endif
        </td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->kakaku }}円</td>
        <td>{{ $product->zaiko }}</td>
        <td>{{ $product->maker }}</td>
        <td style="text-align: left;">
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
</table>

<script>
function deleteProduct(button) {
    const productId = button.getAttribute('data-id');

    fetch(`/products/${productId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
    })
    .then(response => {
        if (response.ok) {
            // 削除成功したらその行を非表示
            const row = button.closest('tr');
            row.remove();
        } else {
            alert('削除に失敗しました');
        }
    })
    .catch(error => {
        console.error('削除エラー:', error);
        alert('エラーが発生しました');
    });
}
</script>


{!! $products->links('pagination::bootstrap-5') !!}
