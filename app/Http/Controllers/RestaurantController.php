<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RestaurantController extends Controller
{
    public function restaurantInformation() {
        $restaurant = DB::table('restaurants')->first();
        return view('restaurant', compact('restaurant'));
    }

    public function restaurantSubmit(Request $request) {
        if ($request->id) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:20',
                'taxrate' => 'required',
            ]);

            if ($validator->passes()) {
                if ($this->saveExistingRestaurant($request)) {
                    return response()->json(['status'=>1, 'msg'=>'Restaurant has been successfully updated.']);
                } else {
                    return response()->json(['status'=>2, 'msg'=>'Update failed']);
                }
            } else {
                return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:20',
                'taxrate' => 'required',
            ]);

            if ($validator->passes()) {
                $restaurant = new Restaurant();
                $restaurant->name = $request->name;
                $restaurant->year_founded = $request->yearfounded;
                $restaurant->tax_rate = $request->taxrate;
                $restaurant->phone = str_replace("-", "", $request->phone);
                $restaurant->email = $request->email;
                $restaurant->address1 = $request->address1;
                $restaurant->address2 = $request->address2;
                $restaurant->city = $request->city;
                $restaurant->state = $request->state;
                $restaurant->zip = $request->zip;
                if ($this->saveNewRestaurant($restaurant)){    
                    return response()->json(['status'=>1, 'msg'=>'Restaurant Information has been successfully created.']);
                } else {
                    return response()->json(['status'=>2, 'msg'=>'Create failed']);
                }
            } else {
                return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
            }
        }
    }

    public function saveNewRestaurant($restaurant)
    {
        return $restaurant->save();
    }

    public function saveExistingRestaurant($request)
    {
        $expired = str_replace("/", "", $request->expired);
        if ($expired == "") {
            $expired = null;
        }
        return DB::table('restaurants')->where('id',$request->id)
                ->update([
                    'name'=>$request->name,
                    'year_founded'=>$request->yearfounded,
                    'tax_rate'=>$request->taxrate,
                    'phone'=>str_replace("-", "", $request->phone),
                    'email'=>$request->email,
                    'address1'=>$request->address1,
                    'address2'=>$request->address2,
                    'city'=>$request->city,
                    'state'=>$request->state,
                    'zip'=>$request->zip,
                ]);
    }
}
