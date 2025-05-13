@extends('app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="text-left">
          <h1 style="font-size: 1.25rem;">商品一覧画面</h1>
        </div>
    </div>
</div>

<table class="table table-borderd">
    <tr>
        <th>No</th>
        <th>画像</th>
        <th>名前</th>
        <th>価格</th>
        <th>在庫</th>
        <th>メーカー名</th>
        <th>
        <div class="text-center">
            <a class="btn btn-success" href="/products/create">新規登録</a>
        </div>
        </th>
        <th></th>
    </tr>
    @foreach ($products as $product)
    <tr>
    <td style="text-align: right;">{{ $product->id }}</td>
        <td>
         @if ($product->img_path)
           <img src="{{ asset('storage/' . $product->img_path) }}" alt="Product Image" style="width: auto;">
           @else
           <span>画像なし</span>
         @endif
        </td>
        <td>{{ $product->name }}</td>
        <td style="text-align: left;">{{ $product->kakaku }}円</td>
        <td style="text-align: left;">{{ $product->zaiko }}</td>
        <td style="text-align: left;">{{ $product->maker }}</td>
        <td style="text-align: center;">
           <a class="btn btn-sm btn-primary" href="{{ route('product.show', $product->id) }}">詳細</a>
           <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("削除しますか？")'>
            削除
        </button>
            </form>
        </td>

    </tr>
    @endforeach
</table>

{!! $products->links('pagination::bootstrap-5') !!}

@endsection