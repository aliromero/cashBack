<?php

namespace App\Http\Controllers\api\v1;

use App\Cart;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Factor;
use App\Models\Product;
use App\Models\Shop;
use Backpack\Settings\app\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Morilog\Jalali\jDate;

class ApiController extends Controller
{
    public function FirstClientRegister(Request $request)
    {
        // Get Today To Miladi
        $date = explode("-", Carbon::now()->formatLocalized('%Y-%m-%d'));
        // Get This Year To Shamsi And Calculate [Max|Min] Age
        $max_year = jDate::forge("{$date[0]}-{$date[1]}-{$date[2]}")->format('%Y') - $this->getSetting("max_age");
        $min_year = jDate::forge("{$date[0]}-{$date[1]}-{$date[2]}")->format('%Y') - $this->getSetting("min_age");


        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:255',
            'city' => 'required|numeric',
            'year' => "required|numeric|between:{$max_year},{$min_year}",
            'month' => 'required|digits_between:1,12',
            'day' => 'required|digits_between:1,31',
            'mobile' => 'required|mobile|unique:customers',
            'email' => 'required|email|unique:customers',
            'username' => 'required|min:3|max:255|unique:customers',
            'p' => 'required|min:6|max:255',
        ]);
        if ($this->getSetting("register") != 1) {
            // Register Is Off
            $data['status'] = false;
            $data['error'][0] = "ثبت نام در حال حاظر غیر فعال می باشد";
        } elseif ($validator->fails()) {
            // Validate Error
            $data['error'] = $validator->errors()->all();
            $data['status'] = false;
        } else {
            // Registering...
            $customer = new Customer();
            $customer->name_family = $request->name;
            $customer->city_id = $request->city;
            $customer->birth = "{$request->year}-{$request->month}-{$request->day}";
            $customer->mobile = $request->mobile;
            $customer->email = $request->email;
            $customer->username = $request->username;
            $customer->password = Hash::make($request->p);
            $customer->save();
            $data['status'] = true;
        }
        return $data;
    }

    public function ClientLogin(Request $request)
    {
        sleep(5);
        $data['status'] = false;
        $data['error'] = null;
        $validator = Validator::make($request->all(), [
            "username" => "required",
            "p" => "required",
        ]);
        if ($validator->fails()) {
            $data['error'] = $validator->errors()->all();
            $data['status'] = false;
        } else {
            $customer = Customer::where('username', $request->username)->first();
            if ($customer) {
                // User Exist
                if (Hash::check($request->p, $customer->password)) {
                    // User Pass It's OK
                    $data['id'] = $customer->id;
                    $data['username'] = $customer->username;
                    $data['password'] = $request->p;
                    $data['status'] = true;
                } else {
                    // Password Is Incorrect
                    $data['error'][0] = "رمز عبور وارد شده صحیح نیست";
                    $data['status'] = false;
                }
            } else {
                // User Not Found
                $data['error'][0] = "نام کاربری وارد شده صحیح نیست";
                $data['status'] = false;
            }
        }
        return $data;
    }

    public function getShops()
    {

        $data['favorite'] = Shop::limit(10)->get();
        $data['special'] = Shop::limit(10)->get();
        $data['top'] = Shop::limit(10)->get();
        $data['banners'] = Banner::limit(10)->get();
        return $data;
    }

    public function getProducts($shop_id)
    {
        $data['shop'] = Shop::find($shop_id);
        $data['categories'] = Category::where('shop_id', $shop_id)->limit(20)->get();

        $i = 0;

        foreach ($data['categories'] as $category) {
            $p = 0;
            foreach ($category->products()->with('photos', 'vote', 'video')->get() as $product) {
                $product['sale'] = ($product->discount_type == "percent") ? (($product->price * $product->discount) / 100) : $product->discount;
                $data['categories'][$i]['products'][$p] = $product;
                $p++;
            }

            $i++;

        }

        return $data;
    }

    public function addCart($product_id, Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $product = Product::find($request->product_id);
        if ($product != null) {
            if ($customer != null) {
                $cart_exist = Cart::whereRaw("`product_id` = '{$product->id}' and `customer_id` = '{$customer->id}' and (`status` = 'waiting') ")->get();
                if ($cart_exist->count() > 0) {
                    $data['status'] = false;
                    $data['error'][0] = "این محصول از قبل داخل سبد خرید شما وجود دارد";

                } else {
                    $cart = new Cart;
                    $cart->product_id = $product_id;
                    $cart->customer_id = $customer->id;
                    $cart->shop_id = $product->shop_id;
                    $cart->qty = $request->qty;
                    if ($request->vote_id != null) {
                        $cart->vote_id = $request->vote_id;
                        $cart->vote_p = $request->vote_p;
                    }
                    $sale = ($product->discount_type == "percent") ? (($product->price * $product->discount) / 100) * $request->qty : $product->discount * $request->qty;
                    $cart->sale = $sale;
                    $cart->save();
                    $data['status'] = true;
                    $data['sale'] = $sale;
                }
            } else {
                $data['status'] = false;
                $data['error'][0] = "کاربر یافت نشد";
            }
        } else {
            $data['status'] = false;
            $data['error'][0] = "محصول یافت نشد";
        }
        return $data;

    }

    public function carts($customer_id, $status)
    {

        $carts = Cart::join('products', 'products.id', '=', 'carts.product_id')->where('carts.status', strtoupper($status))->where('carts.customer_id', $customer_id)->selectRaw('products.name ,products.price * carts.qty as price , carts.*')->paginate(20);
        return $carts;
    }

    public function shopsPending($customer_id)
    {
        $data['shops'] = Cart::
        join('shops', 'carts.shop_id', '=', 'shops.id')
            ->where('carts.status', 'waiting')
            ->where('carts.customer_id', $customer_id)
            ->groupBy('carts.shop_id')
            ->selectRaw("shops.*")
            ->get();

        $i = 0;
        foreach ($data['shops'] as $shop) {
            $data['shops'][$i]['carts'] = Cart::
            join('products', 'products.id', '=', 'carts.product_id')
                ->where('carts.shop_id', $shop->id)
                ->where('carts.status', 'waiting')
                ->where('carts.customer_id', $customer_id)
                ->selectRaw('products.name as name,carts.*')
                ->get();
            $i++;
        }

        return $data['shops'];
    }

    public function saveFactor(Request $request)
    {
        $factor = new Factor;
        $factor->customer_id = $request->customer_id;
        $factor->save();
        foreach ($request->carts as $cart) {
            $my_cart = Cart::find($cart);
            $my_cart->update(['status' => 'POSTED']);
            $factor->carts()->save($my_cart);
        }
        foreach ($request->pic as $pic) {
            $image = $this->uploadPic($pic);
            $factor->images()->save($image);
        }
        $data['status'] = true;
        return $data;
    }

    private function uploadPic($value)
    {
        $disk = "uploads";
        $destination_path = "factors";
        $path = \Storage::disk($disk)->putFile($destination_path, $value);
        $image = new \App\Models\Image();
        $image->src = $path;
        $image->save();
        return $image;


    }


    public function setFavorite(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $shop = Shop::find($request->shop_id);
        $customer->fav_shops()->save($shop);
        $data['status'] = true;
        return $data;
    }

    public function test($customer_id)
    {
        $customer = Customer::find($customer_id);
        return $customer->fav_shops;
    }

    public function getImage($w_h, $url)
    {
//        dd($url);
        $width_height = explode('x', $w_h);
        $width = $width_height[0];
        $height = $width_height[1];
        $img = Image::make($url);

        // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
        $img->fit($width, $height);
        return $img->response();
    }


    private function getSetting($key)
    {
        return Setting::where('key', $key)->first()->value;
    }

}
