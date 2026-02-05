<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Employee\Employees;
Use DB;
use App\Notifications\AllNotification;
use Illuminate\Support\Facades\Notification;

class SettingsController extends HrmController
{
    /**
     * 
    **/
    public function index()
    { }

    public function dashbrd()
    {
        $curacc = [];
        $roles = Role::whereIn('id', [1,3,5,6,7,8])->get();
        $cards = ['AE'=>'Active Employees',
                  'IE'=>'Inactive Employees',
                  'LA'=>'Leave Approval', 
                  "AL"=>'Academic Leaves', 
                  "QE"=>'QID Expiry', 
                  "PE"=>'Passport Expiry',
                  "VE"=>'Visa Expiry'
                ];
        $access = DB::table('dashboard_settings')->select('role_id', 'card')->get();

        if($access->isNotEmpty()){
            foreach($access as $eacacc){
                $curacc[$eacacc->role_id] =  json_decode($eacacc->card);
            }
        }

        //dd($curacc);
        
        return view('settings.dashbrd', compact('roles', 'cards', 'curacc'));
    }

    public function updatedashcard(Request $request)
    {
        $data = $request->all();        
        
        if(!isset($data['card']) || 0>= count($data['card'])){
            return redirect()->back()->with('error', trans('messages.warn_data_null'));
        }

        try{

            DB::table('dashboard_settings')->truncate();

            foreach($data['card'] as $key => $eachcard) {

                DB::table('dashboard_settings')->insert([
                    'role_id' => $key,
                    'card' => json_encode($eachcard)
                ]);
            }

            return redirect('dashboard-settings')->with('success', trans('messages.successO'));
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function get_search(Request $request)
    {
        $query = $request->input('query');
        
        $employeeId = Employees::where(function ($queryBuilder) use ($query) {
            $queryBuilder
                ->where('employee_no', $query)
                ->orWhere('qidno', $query)
                ->orWhere(function ($nameQuery) use ($query) {
                    $nameQuery
                        ->where('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('lname', 'LIKE', '%' . $query . '%');
                });
        })->pluck('user_id')->first();
        
        if ($employeeId) {
            return redirect()->route('employees.show', ['employee' => $employeeId]);
        }else{
            return back();
        }
    }

    public function roleaccess()
    {      
        //$roles = Role::whereIn('id', [3,5,6,7,8])->get();
        $roles = Role::whereIn('id', [2,3,4])->get();
        return view('settings.roleaccess', compact('roles'));
    }

    public function getLinksAndAccess($role_id)
    {
        $rights = $this->getRolesCapableLinks($role_id);
        return view('settings.partials.linkaccess', compact('rights'));
    }

    public function updateroleaccess(Request $request)
    {
        $data = $request->all();

        if( !isset($data['link_id']) || 
            0>= count($data['link_id']) ||
            0>= $data['role_id'] ){
            return redirect()->back()->with('error', trans('messages.warn_data_null'));
        }

        try{

            $del_acc = DB::table('role_has_links')->where('role_id', $data['role_id'])
                                                  ->delete();
            
            foreach($data['link_id'] as $eachlinkid) {

                DB::table('role_has_links')->insert([
                    'role_id' => $data['role_id'],
                    'link_id' => $eachlinkid
                ]);
            }           

            return redirect('role-access')->with('success', trans('messages.successO'));
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function notifSend()
    {
        /*Push notification */
        $notif_data = new \stdClass();
        $notif = new AllNotification();
        $notif_data->title = trans('messages.leave_rqst_notif');
        $notif_data->body = trans('messages.leave_rqst_pndng');
                       
        $send_notif = $notif->sendPushNotifications($notif_data, 1);
        /*$send_notif = $notif->sendWebNotifications($notif_data, 1);*/

        return redirect('dashboard');
    }

}
