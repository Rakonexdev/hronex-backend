<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Traits\Common;

class HrmController extends Controller
{
  use Common;

  public function __construct()
  {
    //global data here.

    //Company
    $this->company = 'KAHRAMAA';

    //Company Area
    $this->comparea = 'DOHA';

    //Links & menus 
    $this->menulinks = $this->menulinks();

    //Conuntries
    $this->countries = \DB::table('countries')->select('*')->orderBy('ord', 'ASC')->get();

    //Languages
    $this->languages = array('English', 'Arabic', 'French', 'Hindi');  

    //Currencies 
    $this->currency = array('QAR', 'AED', 'OMR', 'SAR', 'INR');

    //Gratuity Status
    $this->gratuity_status = array('Initiated', 'Assigned To Review', 'Reviewed & Send To Approve', 'Approved');

    //Leave approval actions
    $this->leave_approval_action = ['approve' => 'success', 'reject' => 'danger', 'hold' => 'warning'];

    //Leave approval status
    $this->leave_approval_status = ['applied'=>1, 'hold'=>2, 'verified'=>3, 'rejected'=>4, 'return'=>5, 'approved'=>6, 'cancelled'=>7, 'partially cancelled'=>8, 'Deleted'=>9];

    $this->employee_file_order = [['QID File','qid', 'S', '*'], 
                                  ['Passport File', 'passport', 'S', '*'], 
                                  ['Degree Files', 'degree[]', 'M', '*'], 
                                  ['Other Qualification Files', 'other_quali[]', 'M', ''], 
                                  ['Offer Letter', 'offer', 'S', ''], 
                                  ['NOC File', 'noc', 'S', ''],
                                  ['CV File', 'cv', 'S', ''], 
                                  ['Disclaimer(MOE) File', 'disclaimer_moe', 'S', ''], 
                                  ['Declaration(MOE) File', 'declaration_moe', 'S', ''],
                                  ['Other Files', 'other[]', 'M', ''],
                                  ['Inactive','inactive', 'S', '']
                                ];

    $this->notification_list = ['Attendance', 'Leave Approval', 'Leave Flow', 'Event', 'Profile', 'Passport', 'Qid', 'Passport & Qid', 'Probationary Review'];

    $this->academic_year = (date('Y')-2023)+1;

    $this->systemsignature = 'This is computer generated document and requires no signature';
    

    View::share('thiscompany', $this->company);
    View::share('thiscomparea', $this->comparea);
    View::share('menulinks', $this->menulinks);
    View::share('countries', $this->countries);
    View::share('thislanguages', $this->languages);
    View::share('thiscurrency', $this->currency);
    View::share('gratuity_status', $this->gratuity_status);
    View::share('leave_approval_action', $this->leave_approval_action);
    View::share('leave_approval_status', $this->leave_approval_status);
    View::share('employee_file_order', $this->employee_file_order);
    View::share('notification_list', $this->notification_list);
    View::share('academic_year', $this->academic_year);
    View::share('systemsignature', $this->systemsignature);
    
  }
}
