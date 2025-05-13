@extends('app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
           <h1 style="font-size: 1.25rem;">詳細画面</h1>
        </div>
    </div>
</div>

<div style="text-align: left;">
        <div class="row">
            <div class="col-12 mb-2 mt-2">
               <div class="form-group">
                   {{ $product->img_path }}
               </div>
            </div>
            <div class="col-12 mb-2 mt-2">
                <div class="form-group">
                    {{ $product->name }}
                </div>
            </div>
            <div class="col-12 mb-2 mt-2">
                <div class="form-group">
                    {{ $product->kakaku }}
                </div>
            </div>
            <div class="col-12 mb-2 mt-2">
                <div class="form-group">
                    {{ $product->zaiko }}
                </div>
            </div>
            <div class="col-12 mb-2 mt-2">
                <div class="form-group">
                    @foreach($makers as $maker)
                     @if($maker->id==$product->maker) {{ $maker->str }} @endif
                    @endforeach
                </div>
            </div>
            <div class="col-12 mb-2 mt-2">
                <div class="form-group">
                    {{ $product->syousai }}
                </div>
            </div>
            <div class="col-12 mb-12 mt-2">
                <a class="btn btn-secondary" href="{{ url('/products') }}?page={{ $page_id }}">戻る</a>
                <a class="btn btn-primary" href="{{ route('product.edit', $product->id) }}">編集</a>
            </div>
        </div>
    </form>
</div>

@endsection