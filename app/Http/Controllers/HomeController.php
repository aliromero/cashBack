<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.home');
    }

    public function shops(Request $request)
    {
        $paginate = 20;
        if ($request->has('city_id') && $request->has('area_id')) {
            $area = Area::findOrFail($request->get('area_id'));
            $shops = $area->shops()->published()->paginate($paginate);
            $shops_count = $area->shops()->published()->count();

        } elseif ($request->has('city_id') && !$request->has('area_id')) {
            $city = City::findOrFail($request->get('city_id'));
            $shops = $city->shops()->published()->paginate($paginate);
            $shops_count = $city->shops()->published()->count();
        } elseif (!$request->has('city_id') && $request->has('area_id')) {
            $city = City::findOrFail($request->get('city_id'))->first();
            $area = Area::find($request->get('area_id'));
            $shops = $area->shops()->published()->paginate($paginate);
            $shops_count = $area->shops()->published()->count();
        } else {

            $shops = Shop::published()->paginate($paginate);
            $shops_count = Shop::published()->count();

        }
        return view('home.shops', compact('shops', 'area', 'city', 'shops_count'));
    }


    public function tag_products($tagId)
    {
        $paginate = 15;

        $categories = Product::join('category_product', 'category_product.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'category_product.category_id')
            ->groupBy('category_product.category_id')
            ->where([
                ['products.status', 1]
            ])
            ->select(['category_product.category_id', DB::raw('count(category_product.category_id) as category_count'), 'categories.name'])
            ->get();
        $tags = Product::join('product_tag', 'product_tag.product_id', '=', 'products.id')
            ->join('tags', 'tags.id', '=', 'product_tag.tag_id')
            ->groupBy('product_tag.tag_id')
            ->where([
                ['products.status', 1]
            ])
            ->select(['product_tag.tag_id', DB::raw('count(product_tag.tag_id) as tag_count'), 'tags.name', 'tags.slug'])
            ->orderBy('tag_count', 'desc')->limit(30)->get();


        $products = Product::join('product_tag', 'product_tag.product_id', '=', 'products.id')
            ->groupBy('products.id')
            ->where([
                ['products.status', 1],
                ['product_tag.tag_id', $tagId]
            ])
            ->select(['products.*'])
            ->paginate($paginate);

        return view('home.products', compact('products', 'categories', 'tags'));

    }
    public function get_area(Request $request)
    {
        $term = $request->input('term');
        $areas = Area::join('cities', 'cities.id', '=', 'areas.city_id')
            ->where('areas.name', 'LIKE', '%' . $term . '%')->selectRaw('areas.*,cities.name as city_name')->get();
        return $areas;
    }

    public function products($shopId = null, Request $request)
    {

        $paginate = 15;
        // Has ShopID
        if ($shopId != null) {
            $shop = Shop::findOrFail($shopId);
            $categories = Product::
                join('categories', 'categories.id', '=', 'products.category_id')
                ->groupBy('products.category_id')
                ->where([
                    ['products.shop_id', $shopId],
                    ['products.status', 1]
                ])
                ->select(['products.category_id', DB::raw('count(products.category_id) as category_count'), 'categories.name'])
                ->get();

            $tags = Product::join('product_tag', 'product_tag.product_id', '=', 'products.id')
                ->join('tags', 'tags.id', '=', 'product_tag.tag_id')
                ->groupBy('product_tag.tag_id')
                ->where([
                    ['products.shop_id', $shopId],
                    ['products.status', 1]
                ])
                ->select(['product_tag.tag_id', DB::raw('count(product_tag.tag_id) as tag_count'), 'tags.name', 'tags.slug'])
                ->orderBy('tag_count', 'desc')->limit(30)->get();
        }
        // ShopID IS Null
        else {
            $categories = Product::
                 join('categories', 'categories.id', '=', 'products.category_id')
                ->groupBy('products.category_id')
                ->where([
                    ['products.status', 1]
                ])
                ->select(['products.category_id', DB::raw('count(products.category_id) as category_count'), 'categories.name'])
                ->get();
            $tags = Product::join('product_tag', 'product_tag.product_id', '=', 'products.id')
                ->join('tags', 'tags.id', '=', 'product_tag.tag_id')
                ->groupBy('product_tag.tag_id')
                ->where([
                    ['products.status', 1]
                ])
                ->select(['product_tag.tag_id', DB::raw('count(product_tag.tag_id) as tag_count'), 'tags.name', 'tags.slug'])
                ->orderBy('tag_count', 'desc')->limit(30)->get();
        }
        // Has ShopId And Tag
        if ($shopId != null && $request->has('tag_id')) {

            $products = Product::join('product_tag', 'product_tag.product_id', '=', 'products.id')
                ->groupBy('products.id')
                ->where([
                    ['products.shop_id', $shopId],
                    ['products.status', 1],
                    ['product_tag.tag_id', $request->get('tag_id')]
                ])
                ->select(['products.*'])
                ->paginate($paginate);


        }
        // Has ShopId And category
        else if ($shopId != null && $request->has('category_id')) {
            $products = Product::join('categories', 'categories.id', '=', 'products.category_id')
                ->groupBy('products.id')
                ->where([
                    ['products.shop_id', $shopId],
                    ['products.status', 1],
                    ['products.category_id', $request->get('category_id')]
                ])
                ->select(['products.*'])
                ->paginate($paginate);


        }

        // Has ShopId And Search
        else if ($shopId != null && $request->has('term')) {
            $products = Product::  join('categories', 'categories.id', '=', 'products.category_id')
                ->groupBy('products.id')
                ->where([
                    ['products.shop_id', $shopId],
                    ['products.status', 1],
                    ['products.name', 'LIKE', "%{$request->get('term')}%"]
                ])
                ->select(['products.*'])
                ->paginate($paginate);


        }

        //Shop ID & TagId Is Null CategoryId Not Null
        else if ($shopId == null && $request->has('category_id')) {

            $products = Product::  join('categories', 'categories.id', '=', 'products.category_id')
                ->groupBy('products.id')
                ->where([
                    ['products.status', 1],
                    ['products.category_id', $request->get('category_id')]
                ])
                ->select(['products.*'])
                ->paginate($paginate);

        } //Shop ID & Category Is Null TagId Not Null
        else if ($shopId == null && $request->has('tag_id')) {

            $products = Product::join('product_tag', 'product_tag.product_id', '=', 'products.id')
                ->groupBy('products.id')
                ->where([
                    ['products.status', 1],
                    ['product_tag.tag_id', $request->get('tag_id')]
                ])
                ->select(['products.*'])
                ->paginate($paginate);

        }

        // Shop Id Is Null And Search
        else if ($shopId == null && $request->has('term')) {

            $products = Product::  join('categories', 'categories.id', '=', 'products.category_id')
                ->groupBy('products.id')
                ->where([
                    ['products.status', 1],
                    ['products.name', 'LIKE', "%{$request->get('term')}%"]
                ])
                ->select(['products.*'])
                ->paginate($paginate);


        }

        // ShopId IS Null And No Filter
        else if ($shopId == null && !$request->has('category_id') && !$request->has('tag_id')) {

            $products = Product::published()->paginate($paginate);

        }

        // has shopId And No Filter
        else {
            $products = $shop->products()->published()->paginate($paginate);

        }


        return view('home.products', compact('shop', 'products', 'categories', 'tags'));
    }

    public function product($productId)
    {

        $product = Product::findOrFail($productId);
        $shop = Shop::find($product->shop_id);
        $images = $product->photos;
        return view('home.product', compact('product', 'shop', 'images'));
    }


}

