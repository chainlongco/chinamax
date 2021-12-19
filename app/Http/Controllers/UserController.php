<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Not using Ajax call -- not working 
        // Using Ajax Call
        $validator = Validator::make($request->all(), 
        //$request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'    
            ],
            [
                'email.required' => 'This field is required',
                'password.required' => 'This field is required',
            ]
        );
        if ($validator->passes()) {
            $user = DB::table('users')->where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                Session::put('user', $user);
                //return view('/products');
                return response()->json(['status'=>2]);
            } else {
                return response()->json(['status'=>1, 'msg'=>'Email and Password not matched!']);
            }
        } else {
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login');
    }

    public function register(Request $request)
    {
        // Using Ajax call
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:254',
            'email' => 'required|unique:users|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if ($user->save()){
                return response()->json(['status'=>1, 'msg'=>'New User has been successfully registered']);
                //return view('login');
            }
        } else {
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }   
    }

    public function userEdit(Request $request)
    {
        $adminRole = DB::table('roles')->select('id')->where('name', 'Admin')->first();
        $ownerRole = DB::table('roles')->select('id')->where('name', 'Owner')->first();
        $managerRole = DB::table('roles')->select('id')->where('name', 'Manager')->first();
        $employeeRole = DB::table('roles')->select('id')->where('name', 'Employee')->first();
        $user = User::find($request->id);
        $user->roles()->detach();
        if ($request->admin == 'true') {
            $user->roles()->attach($adminRole);
        }
        if ($request->owner == 'true') {
            $user->roles()->attach($ownerRole);
        }
        if ($request->manager == 'true') {
            $user->roles()->attach($managerRole);
        }
        if ($request->employee == 'true') {
            $user->roles()->attach($employeeRole);
        }
        return response()->json(['msg'=>'The roles of ' .$user->name .' have been updated successfully.']);
    }

    public function userDelete(Request $request)
    {
        $user = User::find($request->id);
        $user->roles()->detach();
        if ($user->delete()){
            return $this->listUsers();
        }
        return response()->json(['msg'=>$user->name ." cannot be deleted."]);
    }

    public function listUsers() {
        $users = DB::table('users')
                    ->select('id', 'name', 'email')
                    ->get();
        
        $html = '';
        $html .=    '<table class="table table-striped table-hover cell-border" id="usersDatatable" style="padding: 10px;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle text-center">Name</th>
                                <th rowspan="2" class="align-middle text-center">Email</th>
                                <th colspan="4" class="text-center">Roles</th>
                                <th rowspan="2" class="align-middle text-center">Actions</th>
                            </tr>
                            <tr>        
                                <th class="text-center">Admin</th>
                                <th class="text-center">Owner</th>
                                <th class="text-center">Manager</th>
                                <th class="text-center">Employee</th>                  
                            </tr>
                        </thead>';
        $html .=        '<tbody>';
                            if (!empty($users)):
                                foreach($users as $user):
                                    $roles = DB::table('roles')
                                        ->select('name')
                                        ->join('role_users', 'role_id', '=', 'roles.id')
                                        ->where('role_users.user_id', $user->id)
                                        ->get();
                                    $admin = false;
                                    $owner = false;
                                    $manager = false;
                                    $employee = false;
                                    foreach ($roles as $role):
                                        if ($role->name == "Admin") {
                                            $admin = true;
                                        } else if ($role->name == "Owner") {
                                            $owner = true;
                                        } else if ($role->name == "Manager") {
                                            $manager = true;
                                        } else if ($role->name == "Employee") {
                                            $employee = true;
                                        }
                                    endforeach;    
        $html .=        	        '<tr>';
        $html .=                        '<td class="align-middle">' .$user->name .'</td>';
        $html .=                        '<td class="align-middle">' .$user->email .'</td>';
        $html .=                        '<td class="align-middle text-center"><input type="checkbox" class="roleadmin" id="roleadmin' .$user->id .'" style="height:20px; width:20px;" ' .($admin?"checked":"") .'>'  .'</td>';
        $html .=                        '<td class="align-middle text-center"><input type="checkbox" class="roleowner" id="roleowner' .$user->id .'" style="height:20px; width:20px;" ' .($owner?"checked":"") .'>'  .'</td>';
        $html .=                        '<td class="align-middle text-center"><input type="checkbox" class="rolemanager" id="rolemanager' .$user->id .'" style="height:20px; width:20px;" ' .($manager?"checked":"") .'>'  .'</td>';
        $html .=                        '<td class="align-middle text-center"><input type="checkbox" class="roleemployee" id="roleemployee' .$user->id .'" style="height:20px; width:20px;" ' .($employee?"checked":"") .'>'  .'</td>';
        $html .=                        '<td>';
        $html .=                            '<div class="row justify-content-around" style="margin:auto;">';
        $html .=                                '<a href="" id="usersave' .$user->id .'" class="col-md-5 btn btn-primary usersave" title="Save"><span class="bi bi-save"></span></a>';
        $html .=                                '<a href="" id="userdelete' .$user->id .'" class="col-md-5 btn btn-danger userdelete" title="Delete" onclick="if(!confirm(' ."'Are you sure?'" .')){return false;}"><span class="bi-x-lg"></span></a>';
        $html .=                            '</div>';
        $html .=                        '</td>';
        $html .=                    '</tr>';
                                endforeach;
                            endif;

        $html .=     	'</tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Admin</th>
                                <th class="text-center">Owner</th>
                                <th class="text-center">Manager</th>
                                <th class="text-center">Employee</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </tfoot>';
        $html .=	'</table>';
        
        //scrollY: "530px", there is a bug for scrollY in DataTable: Header not align automatically when change window size. So, commented out
        $html .=    '<script>
                        $(document).ready(function(){
                            $("#usersDatatable").DataTable({
                                //scrollY: "530px",
                                scrollCollapse: true,
                                "columnDefs": [{
                                    targets: [6],
                                    orderable: false
                                }]
                            });
                        });    
                    </script>';
        
        echo $html;
    }
}
