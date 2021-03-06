<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function customerLogin()
    {
        return view('customerlogin');
    }

    public function customerRegister()
    {
        return view('customersignup');
    }

    public function customerSignIn(Request $request)
    {
        // Not using Ajax call -- not working 

        // Using Ajax Call
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->passes()) {
            $customer = DB::table('customers')->where('email', $request->email)->first();
            if ($customer && Hash::check($request->password, $customer->password)) {
                Session::put('customer', $customer);
                return response()->json(['status'=>2]);
            } else {
                return response()->json(['status'=>1, 'msg'=>'Email and Password not matched or you have not sign up yet!']);
            }
        } else {
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
    }

    public function customerLogout()
    {
        Session::forget('customer');
        return redirect('/customerLogin');
    }

    public function customerSignup(Request $request)
    {
        // Using Ajax call
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:20',
            'lastname' => 'required|max:20',
            'phone' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            // email is unique and validated in $validator
            $customer = new Customer();
            $customer->first_name = $request->firstname;
            $customer->last_name = $request->lastname;
            $customer->phone = str_replace("-", "", $request->phone);
            $customer->email = $request->email;
            $customer->password = Hash::make($request->password);
            if ($customer->save()){
                return response()->json(['status'=>1, 'msg'=>'New Customer has been successfully signed up.']);
            }
        }
        
        return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);  
    }

    public function customerAdd()
    {
        $customer = null;
        return view('customer', compact('customer'));
    }

    public function createUpdateCustomer(Request $request)
    {
        // From customersignup.blade.php
        if ($request->id) {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|max:20',
                'lastname' => 'required|max:20',
                'phone' => 'required|unique:customers,phone,' .$request->id,
                'email' => 'nullable|email|unique:customers,email,' .$request->id,
            ]);

            if ($validator->passes()) {
                if ($this->saveExistingCustomer($request)) {
                    return response()->json(['status'=>1, 'msg'=>'Existing customer has been successfully updated.']);
                } else {
                    return response()->json(['status'=>2, 'msg'=>'Update failed']);
                }
            } else {
                return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|max:20',
                'lastname' => 'required|max:20',
                'phone' => 'required|unique:customers',
                'email' => 'nullable|unique:customers|email'
            ]);

            if ($validator->passes()) {
                $customer = new Customer();
                $customer->first_name = $request->firstname;
                $customer->last_name = $request->lastname;
                $customer->phone = str_replace("-", "", $request->phone);
                $customer->email = $request->email;
                $customer->address1 = $request->address1;
                $customer->address2 = $request->address2;
                $customer->city = $request->city;
                $customer->state = $request->state;
                $customer->zip = $request->zip;
                $customer->card_number = str_replace("-", "", $request->card);
                $expired = str_replace("/", "", $request->expired);
                if ($expired == "") {
                    $expired = null;
                }
                $customer->expired = $expired;
                $customer->cvv = $request->cvv;
                if ($this->saveNewCustomer($customer)){
                    return response()->json(['status'=>1, 'msg'=>'New Customer has been successfully created.']);
                } else {
                    return response()->json(['status'=>2, 'msg'=>'Create failed']);
                }
            } else {
                return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
            }
        }
    }

    public function saveNewCustomer($customer)
    {
        return $customer->save();
    }

    public function saveExistingCustomer($request)
    {
        $expired = str_replace("/", "", $request->expired);
        if ($expired == "") {
            $expired = null;
        }
        return DB::table('customers')->where('id',$request->id)
                ->update([
                    'first_name'=>$request->firstname,
                    'last_name'=>$request->lastname,
                    'phone'=>str_replace("-", "", $request->phone),
                    'email'=>$request->email,
                    'address1'=>$request->address1,
                    'address2'=>$request->address2,
                    'city'=>$request->city,
                    'state'=>$request->state,
                    'zip'=>$request->zip,
                    'card_number'=>str_replace("-", "", $request->card),
                    'expired'=>$expired,
                    'cvv'=>$request->cvv,
                ]);
    }

    public function customerDelete($id) {
        $customer = DB::table('customers')->where('id', $id);
        if ($customer->first()) {
            $firstName = $customer->first()->first_name;
            $lastName = $customer->first()->last_name;
            if ($customer->delete()) {
                //return response()->json(['status'=>1, 'msg'=>'Customer: ' .$firstName .' ' .$lastName .' has been successfully deleted.']);
                return redirect('customer/list');   // This is not using AJAX call which is different from userDelete(ajax call)
            }
        }
        return redirect('customer/list'); 
    }

    public function customerEdit($id) {
        $customer = DB::table('customers')->where('id', $id)->first();
        if ($customer) {
            return view('customer', compact('customer'));
        } else {
            return redirect('/customer/add');
        }
    }

    public function customerList() {
        return view('mycustomers');
    }

    public function listCustomers() {
        $customers = DB::table('customers')->get();
        
        $html = '';
        $html .=    '<table class="table table-striped table-hover cell-border" id="customersDatatable" style="padding: 10px;">
                        <thead>
                            <tr style="border-top: 1px solid #000;">
                                <th class="text-center">First Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>';
        $html .=        '<tbody>';
                            if (!empty($customers)):
                                foreach($customers as $customer):
                                    $phoneNumber = $customer->phone;
                                    if( preg_match('/^(\d{3})(\d{3})(\d{4})$/', $customer->phone,  $matches)) {
                                        $phoneNumber = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
                                    }
        $html .=        	        '<tr>';
        $html .=                        '<td class="align-middle">' .$customer->first_name .'</td>';
        $html .=                        '<td class="align-middle">' .$customer->last_name .'</td>';
        $html .=                        '<td class="align-middle">' .$phoneNumber .'</td>';
        $html .=                        '<td class="align-middle">' .$customer->email .'</td>';
        $html .=                        '<td>';
        $html .=                            '<div class="row justify-content-around" style="margin:auto;">';
        $html .=                                '<a href="edit/' .$customer->id .'" class="col-md-5 btn btn-primary" title="Edit"><span class="bi-pencil-fill"></span></a>';
        $html .=                                '<a href="delete/' .$customer->id .'" class="col-md-5 btn btn-danger" title="Delete" onclick="if(!confirm(' ."'Are you sure?'" .')){return false;}"><span class="bi-x-lg"></span></a>';
        $html .=                            '</div>';
        $html .=                        '</td>';
        $html .=                    '</tr>';
                                endforeach;
                            endif;

        $html .=     	'</tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </tfoot>';
        $html .=	'</table>';
        
        //scrollY: "530px", there is a bug for scrollY in DataTable: Header not align automatically when change window size. So, commented out
        $html .=    '<script>
                        $(document).ready(function(){
                            $("#customersDatatable").DataTable({
                                //scrollY: "530px",
                                scrollCollapse: true,
                                "columnDefs": [{
                                    targets: [4],
                                    orderable: false
                                }]
                            });
                        });    
                    </script>';
        
        echo $html;
    }
}
