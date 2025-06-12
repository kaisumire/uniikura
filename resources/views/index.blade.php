@extends('app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="text-left">
          <h1 style="font-size: 1.25rem;">商品一覧画面</h1>
</div>
    </div>
</div>

<div class="d-flex mb-3" style="gap: 10px;">
    <form method="GET" action="{{ route('products.index') }}" class="d-flex gap-2">
        <input type="text" name="keyword" class="form-control" placeholder="検索キーワード">
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

        <button type="submit" class="btn btn-outline-secondary">検索</button>
    </form>
</div>


<div id="product-list">
     @include('sonota.product-list', ['products' => $products])
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('#search-input').on('input', function() {
        const keyword = $(this).val();
        $.ajax({
            url: "{{ route('products.search') }}",
            method: 'GET',
            data: { keyword: keyword },
            success: function(response) {
                $('#product-list').html(response.html);
            }
        });
    });
});
</script>

@endsection