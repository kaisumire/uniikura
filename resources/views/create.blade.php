@extends('app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h1 style="font-size: 1.25rem;">新規登録画面</h1>
        </div>
    </div>
</div>

<div style="text-align: left;">
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-12 mb-2 mt-2">
               <div class="form-group">
                   <label for="image">画像を選択</label>
                   <input type="file" name="img_path" class="form-control" id="image" accept="image/*">
               </div>
            </div>
            <div class="col-12 mb-2 mt-2">
                <div class="form-group">
                    <input type="text" name="name" class="form-controll" placeholder="名前">
                </div>
                @error('name')
                <span style="color: red;">名前を入力して下さい</span>
                @enderror
            </div>
            <div class="col-12 mb-2 mt-2">
                <div class="form-group">
                    <input type="text" name="kakaku" class="form-controll" placeholder="価格">
                </div>
                @error('kakaku')
                <span style="color: red;">価格を入力して下さい</span>
                @enderror
            </div>
            <div class="col-12 mb-2 mt-2">
                <div class="form-group">
                    <input type="text" name="zaiko" class="form-controll" placeholder="在庫">
                </div>
                @error('zaiko')
                <span style="color: red;">在庫を入力して下さい</span>
                @enderror
            </div>
            <div class="col-12 mb-2 mt-2">
                <div class="form-group">
                    <select name="maker" class="form-select">
                        <option>メーカー名を選択してください</option>
                        @foreach ($makers as $maker)
                        <option value="{{ $maker->id }}">{{ $maker->str }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 mb-2 mt-2">
                <div class="form-group">
                    <textarea class="form-control" style="height: 100px;" name="syousai" placeholder="詳細"></textarea>
                </div>
            </div>
            <div class="col-12 mb-12 mt-2">
                <a class="btn btn-success" href="{{ url('/products') }}">戻る</a>
                <button type="submit" class="btn btn-primary">登録</button>
            </div>
        </div>
    </form>
</div>

@endsection