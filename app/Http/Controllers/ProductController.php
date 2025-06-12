<?php

namespace App\Http\Controllers;

use App\Models\Maker;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $sort = $request->input('sort', 'b.id');
    $direction = $request->input('direction', 'desc');

    $query = Product::select([
        'b.id',
        'b.img_path',
        'b.name',
        'b.kakaku',
        'b.zaiko',
        'b.syousai',
        'r.str as maker',
    ])
    ->from('products as b')
    ->join('makers as r', 'b.maker', '=', 'r.id');

    // フィルター（検索）条件もあればここで処理
    if (!empty($request->keyword)) {
        $query->where('b.name', 'like', '%' . $request->keyword . '%');
    }
    if (!empty($request->maker)) {
        $query->where('b.maker', $request->maker);
    }
    if (!empty($request->kakaku_min)) {
        $query->where('b.kakaku', '>=', $request->kakaku_min);
    }
    if (!empty($request->kakaku_max)) {
        $query->where('b.kakaku', '<=', $request->kakaku_max);
    }
    if (!empty($request->zaiko_min)) {
        $query->where('b.zaiko', '>=', $request->zaiko_min);
    }
    if (!empty($request->zaiko_max)) {
        $query->where('b.zaiko', '<=', $request->zaiko_max);
    }

    // 並び替え
    $products = $query->orderBy($sort, $direction)->paginate(5);

    $makers = Maker::all();

    return view('index', compact('products', 'makers', 'sort', 'direction'))
        ->with('page_id', $request->page)
        ->with('i', ($request->input('page', 1) - 1) * 5);
}

    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $makers = Maker::all();
        return view('create', compact('makers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'img_path' => 'required|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|max:20',
            'kakaku' => 'required|integer',
            'zaiko' => 'required|integer',
            'maker' => 'required|integer',
            'syousai' => 'required|max:140',
        ]);

        $product = new Product;
        if ($request->hasFile('img_path') && $request->file('img_path')->isValid()) {
            $imagePath = $request->file('img_path')->store('images', 'public');
            $product->img_path = $imagePath;
        }        
        $product->name = $request->input(['name']);
        $product->kakaku = $request->input(['kakaku']);
        $product->zaiko = $request->input(['zaiko']);
        $product->maker = $request->input(['maker']);
        $product->syousai = $request->input(['syousai']);
        $product->save();

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $makers = Maker::all();
        return view('show', compact('product'))
        ->with('page_id', request()->page_id)
        ->with('makers', $makers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $makers = Maker::all();
        return view('edit', compact('product', 'makers'))
        ->with('makers', $makers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'img_path' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|max:20',
            'kakaku' => 'required|integer',
            'zaiko' => 'required|integer',
            'maker' => 'required|integer',
            'syousai' => 'required|max:140',
        ]);
    
        // 画像アップロード
        if ($request->hasFile('img_path') && $request->file('img_path')->isValid()) {
            $imagePath = $request->file('img_path')->store('images', 'public');
            $product->img_path = $imagePath;
        }
    
        // データの更新
        $product->name = $request->input('name');
        $product->kakaku = $request->input('kakaku');
        $product->zaiko = $request->input('zaiko');
        $product->maker = $request->input('maker');
        $product->syousai = $request->input('syousai');
        $product->save();
    
        // リダイレクト
        return redirect()->route('products.index')->with('success', '商品が更新されました！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['success' => true]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('name', 'LIKE', "%$keyword%")->paginate(5);

        $view = view('partials.product-list', compact('products'))->render();

        return response()->json(['html' => $view]);

    }
}
