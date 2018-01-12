<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Customer;
use Backpack\Settings\app\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
            $customer = Customer::where('username',$request->username)->first();
            if ($customer) {
                // User Exist
                if (Hash::check($request->p, $customer->password)) {
                    // User Pass It's OK
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

    private function getSetting($key)
    {
        return Setting::where('key', $key)->first()->value;
    }

}
