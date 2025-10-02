<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $products = Product::with(['category', 'shop'])
                ->latest()
                ->paginate(8);
            return view('pages.shop_owner.product.index', compact('products'));
        }

        $shop = $user->shop;

        if (!$shop) {
            return redirect()->route('shop.index')->with('error', 'You need to create a shop first before managing products.');
        }

        $products = $shop->products()
            ->with(['category'])
            ->latest()
            ->paginate(8);

        return view('pages.shop_owner.product.index', compact('products'));
    }


    public function create()
    {
        $categories = Category::all();
        $shops = \App\Models\Shop::all();

        // Pass a new empty product instance so the form works the same as edit
        return view('pages.shop_owner.product.create', [
            'product' => new Product(),
            'categories' => $categories,
            'shops' => $shops,
        ]);
    }

    public function store(ProductStoreRequest $request)
    {
        $user = Auth::user();

        // Admin users need to specify shop_id in the request
        if ($user->hasRole('admin')) {
            $data = $request->validated();
            if ($request->hasFile('pics')) {
                $file = $request->file('pics');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/product_pics'), $filename);
                $data['pics'] = 'product_pics/' . $filename;
            }
            $product = Product::create($data);
        } else {
            // Shop owner creates products for their shop
            $shop = $user->shop;

            if (!$shop) {
                return redirect()->route('shop.index')->with('error', 'You need to create a shop first before adding products.');
            }

            $data = $request->validated();

            if ($request->hasFile('pics')) {
                $file = $request->file('pics');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/product_pics'), $filename);
                $data['pics'] = 'product_pics/' . $filename;
            }

            $product = $shop->products()->create($data);
        }

        if (!$product) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return redirect()->route('product.index')->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        return view('pages.shop_owner.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $shops = \App\Models\Shop::all();
        return view('pages.shop_owner.product.edit', compact('product', 'categories', 'shops'));
    }

    public function update(ProductStoreRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('pics')) {
            $file = $request->file('pics');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/product_pics'), $filename);
            $data['pics'] = 'product_pics/' . $filename;
        }

        $isUpdated = $product->update($data);

        if (!$isUpdated) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        if (!$product->delete()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->back()->with('success', 'Product deleted successfully');
    }
}
