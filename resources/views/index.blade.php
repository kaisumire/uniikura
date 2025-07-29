@extends('app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="text-left">
            <h1 style="font-size: 1.25rem;">商品一覧画面</h1>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
<script src="{{ asset('js/product.js') }}"></script>

<div class="d-flex mb-3" style="gap: 10px;">
    <form method="GET" action="{{ route('products.index') }}" class="d-flex gap-2">
    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="検索キーワード">
        <select name="maker" class="form-select">
            <option value="">メーカー名</option>
            @foreach ($makers as $maker)
                <option value="{{ $maker->id }}">{{ $maker->str }}</option>
            @endforeach
        </select>

        <input type="number" name="kakaku_min" class="form-control" placeholder="価格(下限)" style="width: 120px;">
        <input type="number" name="kakaku_max" class="form-control" placeholder="価格(上限)" style="width: 120px;">
        <input type="number" name="zaiko_min" class="form-control" placeholder="在庫(下限)" style="width: 120px;">
        <input type="number" name="zaiko_max" class="form-control" placeholder="在庫(上限)" style="width: 120px;">

        <button id="search-button" type="submit" class="btn btn-outline-secondary">検索</button>
    </form>
</div>

<<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>画像</th>
            <th>名前</th>
            <th>価格</th>
            <th>在庫</th>
            <th>メーカー名</th>
            <th>
                <div class="text-left mb-3">
                    <a class="btn btn-success" href="/products/create">新規登録</a>
                </div>
            </th>
        </tr>
    </thead>
    <tbody id="product-list">
        @include('sonota.product-list', ['products' => $products])
    </tbody>
</table>

{!! $products->links('pagination::bootstrap-5') !!}

@endsection