<?php

use App\Http\Controllers\ScfController;
use App\Models\Monthlysalary;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\MonthlysalaryController;

// use App\Http\Controllers\Auth\AuthController;
// use App\Http\Controllers\Masters\MastersController;
// use App\Http\Controllers\Masters\DesignationController;
// use App\Http\Controllers\Masters\SponsorshipController;
// use App\Http\Controllers\Masters\ApprovalStatusController;
// use App\Http\Controllers\Masters\MOEapprovalStatusController;
// use App\Http\Controllers\Masters\PaymentDeductionTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'Auth\AuthController@index');
Route::get('login', 'Auth\AuthController@index')->name('login');
Route::post('post-login', 'Auth\AuthController@postLogin')->name('login.post'); 
Route::get('registration', 'Auth\AuthController@registration')->name('register');
Route::post('post-registration', 'Auth\AuthController@postRegistration')->name('register.post'); 
Route::get('forgotpassword', 'Auth\AuthController@forgotpassword')->name('forgotpassword');
Route::post('post-forgotpassword', 'Auth\AuthController@postForgotpassword')->name('forgotpassword.post');
Route::get('reset-password/{token}', 'Auth\AuthController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'Auth\AuthController@submitResetPasswordForm')->name('reset.password.post');
Route::get('/leave_decision_mail/{token}', 'Employee\LeaveApproveController@leave_decision_through_mail')->name('leave_decision_mail');

Route::get('/logout-all-users','Auth\AuthController@logoutAllUsers')->name('logout.all.users');

Route::group(['middleware' => 'auth'], function () {
    Route::post('reset-admin-password', 'Auth\AuthController@resetPassword')->name('reset.admin.password');
    Route::post('reset-employee-password', 'Auth\AuthController@resetEmployeePassword')->name('reset.employee.password');

    Route::get('dashboard', 'Auth\AuthController@dashboard'); 
    Route::get('profile', 'Auth\AuthController@profile')->name('profile'); 
    Route::get('logout', 'Auth\AuthController@logout')->name('logout');

    Route::get('/custommessages', [App\Http\Controllers\CustomMessageController::class, 'index'])->name('custommessages');
    Route::post('/save-token', [App\Http\Controllers\CustomMessageController::class, 'saveToken'])->name('save-token');
    Route::post('/send-notification', [App\Http\Controllers\CustomMessageController::class, 'sendNotification'])->name('send.notification');
    /*Route::get('/alerts-to-notify', [App\Http\Controllers\Employee\EmployeesController::class, 'alertsToNotify'])->name('alerts-to-notify');*/
    Route::get('/alerts-to-notify', [App\Http\Controllers\SettingsController::class, 'notifSend'])->name('alerts-to-notify');
    Route::get('dashboard-settings', [App\Http\Controllers\SettingsController::class, 'dashbrd'])->name('dashboard-settings');
    Route::post('/updatedashcard', [App\Http\Controllers\SettingsController::class, 'updatedashcard'])->name('updatedashcard');
    Route::get('role-access', [App\Http\Controllers\SettingsController::class, 'roleaccess'])->name('role-access');
    Route::get('getLinksAndAccess/{id}', [App\Http\Controllers\SettingsController::class, 'getLinksAndAccess'])->name('getLinksAndAccess');
    Route::post('/updateroleaccess', [App\Http\Controllers\SettingsController::class, 'updateroleaccess'])->name('updateroleaccess');

    Route::middleware('can:master')->group(function () {

        // Academic Year -- Masters
        Route::get('/academicyear/{id}/edit/{status}', 'Masters\MastersController@status')->name('academicyear.status');
        Route::get('academicyear/delete/{id}', 'Masters\MastersController@destroy')->name('academicyear.delete');
        Route::resource('academicyear', 'Masters\MastersController');

        // Departments -- Masters
        Route::get('/departments/{id}/edit/{status}', 'Masters\MastersController@status')->name('departments.status');
        Route::get('departments/delete/{id}', 'Masters\MastersController@destroy')->name('departments.delete');
        Route::resource('departments', 'Masters\MastersController');

        // Designations -- Masters
        Route::get('/designations/{id}/edit/{status}', 'Masters\DesignationController@status')->name('designations.status');
        Route::get('designations/delete/{id}', 'Masters\DesignationController@destroy')->name('designations.delete');
        Route::resource('designations', 'Masters\DesignationController');

        // Approval status -- Masters
        Route::get('/approvalstatus/{id}/edit/{status}', 'Masters\MastersController@status')->name('approvalstatus.status');
        Route::get('approvalstatus/delete/{id}', 'Masters\MastersController@destroy')->name('approvalstatus.delete');
        Route::resource('approvalstatus', 'Masters\MastersController');

        // Paidstatus status -- Masters
        Route::get('/paidstatus/{id}/edit/{status}', 'Masters\MastersController@status')->name('paidstatus.status');
        Route::get('paidstatus/delete/{id}', 'Masters\MastersController@destroy')->name('paidstatus.delete');
        Route::resource('paidstatus', 'Masters\MastersController');

        // Payment deduction type -- Masters
        Route::get('/paydeductiontype/{id}/edit/{status}', 'Masters\PaymentDeductionTypeController@status')->name('paydeductiontype.status');
        Route::get('paydeductiontype/delete/{id}', 'Masters\PaymentDeductionTypeController@destroy')->name('paydeductiontype.delete');
        Route::resource('paydeductiontype', 'Masters\PaymentDeductionTypeController');

        // School shift -- Masters
        Route::get('/schoolshift/{id}/edit/{status}', 'Masters\MastersController@status')->name('schoolshift.status');
        Route::get('schoolshift/delete/{id}', 'Masters\MastersController@destroy')->name('schoolshift.delete');
        Route::resource('schoolshift', 'Masters\MastersController');
        

        // Contract type -- Masters
        Route::get('/contracttype/{id}/edit/{status}', 'Masters\MastersController@status')->name('contracttype.status');
        Route::get('contracttype/delete/{id}', 'Masters\MastersController@destroy')->name('contracttype.delete');
        Route::resource('contracttype', 'Masters\MastersController');

        // Payment deduction type -- Masters
        Route::get('/sponsstatus/{id}/edit/{status}', 'Masters\SponsorshipController@status')->name('sponsstatus.status');
        Route::get('sponsstatus/delete/{id}', 'Masters\SponsorshipController@destroy')->name('sponsstatus.delete');
        Route::resource('sponsstatus', 'Masters\SponsorshipController');

        // Relevant degree -- Masters
        Route::get('/relevantdegree/{id}/edit/{status}', 'Masters\MastersController@status')->name('relevantdegree.status');
        Route::get('relevantdegree/delete/{id}', 'Masters\MastersController@destroy')->name('relevantdegree.delete');
        Route::resource('relevantdegree', 'Masters\MastersController');

        // MOE approval status -- Masters
        Route::get('/moeapprstatus/{id}/edit/{status}', 'Masters\MOEapprovalStatusController@status')->name('moeapprstatus.status');
        Route::get('moeapprstatus/delete/{id}', 'Masters\MOEapprovalStatusController@destroy')->name('moeapprstatus.delete');
        Route::resource('moeapprstatus', 'Masters\MOEapprovalStatusController');

        // Medical ailment -- Masters
        Route::get('/medicalailment/{id}/edit/{status}', 'Masters\MastersController@status')->name('medicalailment.status');
        Route::get('medicalailment/delete/{id}', 'Masters\MastersController@destroy')->name('medicalailment.delete');
        Route::resource('medicalailment', 'Masters\MastersController');

        // Inactive status -- Masters
        Route::get('/inactivestatus/{id}/edit/{status}', 'Masters\MastersController@status')->name('inactivestatus.status');
        Route::get('inactivestatus/delete/{id}', 'Masters\MastersController@destroy')->name('inactivestatus.delete');
        Route::resource('inactivestatus', 'Masters\MastersController');

        // Inactive reason -- Masters
        Route::get('/inactivereason/{id}/edit/{status}', 'Masters\MastersController@status')->name('inactivereason.status');
        Route::get('inactivereason/delete/{id}', 'Masters\MastersController@destroy')->name('inactivereason.delete');
        Route::resource('inactivereason', 'Masters\MastersController');

        // Relationship -- Masters
        Route::get('/relationship/{id}/edit/{status}', 'Masters\MastersController@status')->name('relationship.status');
        Route::get('relationship/delete/{id}', 'Masters\MastersController@destroy')->name('relationship.delete');
        Route::resource('relationship', 'Masters\MastersController');

        // Relationship -- Masters
        Route::get('/leavetypes/{id}/edit/{status}', 'Masters\MastersController@status')->name('leavetypes.status');
        Route::get('leavetypes/delete/{id}', 'Masters\MastersController@destroy')->name('leavetypes.delete');
        Route::resource('leavetypes', 'Masters\MastersController');

        // Appraisal data -- Masters
        Route::get('/appraisaldata/{id}/edit/{status}', 'Masters\MastersController@status')->name('appraisaldata.status');
        Route::get('appraisaldata/delete/{id}', 'Masters\MastersController@destroy')->name('appraisaldata.delete');
        Route::resource('appraisaldata', 'Masters\MastersController');

        // Appraisal type -- Masters
        Route::get('/appraisaltype/{id}/edit/{status}', 'Masters\MastersController@status')->name('appraisaltype.status');
        Route::get('appraisaltype/delete/{id}', 'Masters\MastersController@destroy')->name('appraisaltype.delete');
        Route::resource('appraisaltype', 'Masters\MastersController');

        //Appraisal Applicable -- Masters
        Route::resource('appraisal_applicable', 'Masters\MastersController');
        Route::get('/appraisal_applicable/{id}/edit/{status}', 'Masters\MastersController@status')->name('appraisal_applicable.status');
        Route::get('appraisal_applicable/delete/{id}', 'Masters\MastersController@destroy')->name('appraisal_applicable.delete');

        // Budget type -- Masters
        Route::get('/budgettype/{id}/edit/{status}', 'Masters\MastersController@status')->name('budgettype.status');
        Route::get('budgettype/delete/{id}', 'Masters\MastersController@destroy')->name('budgettype.delete');
        Route::resource('budgettype', 'Masters\MastersController');

        // Notice Period -- Masters
        Route::get('/noticeperiod/{id}/edit/{status}', 'Masters\MastersController@status')->name('noticeperiod.status');
        Route::get('noticeperiod/delete/{id}', 'Masters\MastersController@destroy')->name('noticeperiod.delete');
        Route::resource('noticeperiod', 'Masters\MastersController');
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::post('fileUpload', 'Employee\EmployeesInfoController@fileUpload')->name('employees.fileUpload');

        Route::resources([
            'employees' => 'Employee\EmployeesController',
            'employees-information' => 'Employee\EmployeesInfoController',
            'payroll_information' => 'Employee\PayrollInfoController',
            'health_information' => 'Employee\HealthInfoController',
            'emergency_details' => 'Employee\EmergencyDetailsController',
            'leaveapply' => 'Employee\LeaveController',
            'leaveapproval' => 'Employee\LeaveApproveController',
            'shift-assign' => 'ShiftAssignController',
            'approval-flows'=> Masters\LeaveApprovalFlowController::class,
        ]);
        Route::any('/shift-assign/filter','ShiftAssignController@filter')->name('shift-assign.filter');
        Route::get('/get-shift-data', 'ShiftAssignController@getShiftData')->name('get-shift-data');
        Route::any('/shift-assigned', 'ShiftAssignController@getShiftassigned')->name('get-shift-assigned');
        Route::any('/shift-assigned/filter','ShiftAssignController@assignedfilter')->name('shift-assigned.filter');
        Route::any('/leaveapproval/re-assign','Employee\LeaveApproveController@re_assign')->name('re-assign');
        Route::any('/leaveapproval/add-leave','Employee\LeaveApproveController@add_leave')->name('add-leave');

        Route::get('inactive_employees', 'Employee\EmployeesController@inactive')->name('inactive_employees');

        Route::get('editEmployee/{id}', 'Employee\EmployeesController@editEmployee')->name('editEmployee');

        Route::get('get_employee_name/{id}', 'Employee\EmployeesController@getEmployeeName')->name('employees');
        
        Route::post('employee-search', 'Employee\EmployeesController@search')->name('employee.search');

        Route::post('employee-filter', 'Employee\EmployeesController@filter')->name('employee.filter');

        Route::post('import-employees', 'Employee\EmployeesController@bulkimport')->name('import.employees');
        Route::post('employeeStatusUpdate', 'Employee\EmployeesController@statusUpdate')->name('employeeStatusUpdate');
        
        Route::any('get_search', [App\Http\Controllers\SettingsController::class, 'get_search'])->name('get_search');

         //Hr Pay roll process    
        Route::resources([ 
            'earnings'=>'EarningController',
            'deduction'=>'DeductionController',
            'payroll'=>'MonthlysalaryController'
        ]);
        Route::post('payroll-search', 'MonthlysalaryController@search')->name('payroll.search');
        Route::any('payroll-payslip/{month}/{id}', 'MonthlysalaryController@payslip')->name('payroll.payslip');

        Route::get('earnings-employees', 'EarningController@employees')->name('earnings.employees');
        Route::any('/earnings/{id}', 'EarningController@show')->name('earnings.show');
        Route::any('/earnings/update/{id}', 'EarningController@update')->name('earnings.update');
        Route::get('/earnings/delete/{id}', 'EarningController@destroy')->name('earnings.destroy'); 
        Route::post('earnings-search', 'EarningController@search')->name('earnings.search');
        Route::post('earnings-employee-search', 'EarningController@emploees_filter')->name('earnings.emploees_filter');
 
        Route::get('deduction-employees', 'DeductionController@employees')->name('deduction.employees');
        Route::any('/deduction/{id}', 'DeductionController@show')->name('deduction.show');
        Route::get('/deduction/delete/{id}', 'DeductionController@destroy')->name('deduction.destroy');
        Route::any('/deduction/update/{id}', 'DeductionController@update')->name('deduction.update'); 
        Route::post('deduction-search', 'DeductionController@search')->name('deduction.search');
        Route::post('deduction-employee-search', 'DeductionController@emploees_filter')->name('deduction.emploees_filter');

        //Route::get('/payroll','MonthlysalaryController@index')->name('payroll');
        Route::any('appraisal_applicable/assign_applicable_filter', 'Masters\MastersController@assign_applicable_filter')->name('appraisal_applicable.assign_applicable_filter');
        Route::any('appraisal_applicable/assign_applicable_charcter_filter', 'Masters\MastersController@assign_applicable_charcter_filter')->name('appraisal_applicable.assign_applicable_charcter_filter');

        // Leave apply
        Route::post('leave-apply', 'Employee\LeaveController@store')->name('leave-apply');
        Route::get('leave-details/{id}', 'Employee\LeaveApproveController@showLeaveDetails')->name('leave.details');
        Route::post('leave-approve', 'Employee\LeaveApproveController@approve')->name('leave-approve');
        Route::post('leaveapproval', 'Employee\LeaveApproveController@index')->name('leave.search');
        Route::get('leaveretract', 'Employee\LeaveApproveController@leaveretract')->name('leaveretract');
        Route::post('sendretractrequest', 'Api\Leave\LeaveController@leaveCancel')->name('sendretractrequest');
        Route::post('approveretract', 'Employee\LeaveApproveController@approveLeaveCancel')->name('approveretract');
        Route::post('deleteLeave', 'Employee\LeaveApproveController@deleteLeave')->name('deleteLeave');


        //Gratuity
        Route::resources([ 
            'gratuity'=>'Gratuity\GratuityController'
        ]);
        Route::get('/gratuity', 'Gratuity\GratuityController@index')->name('gratuity');
        Route::post('employeeDetails', 'Gratuity\GratuityController@empdet')->name('employeeDetails');
        Route::post('gratuityDetails', 'Gratuity\GratuityController@gratuitydet')->name('gratuityDetails');
        Route::post('gratuity-search', 'Gratuity\GratuityController@search')->name('gratuity.search');
        Route::post('addgratuity', 'Gratuity\GratuityController@addGratuity')->name('addgratuity');
        Route::get('getGratuityForStatus/{id}', 'Gratuity\GratuityController@getGratuityForStatus')->name('getGratuityForStatus');
        Route::post('updateGratuityStatus', 'Gratuity\GratuityController@updateGratuityStatus')->name('updateGratuityStatus');

        //Appraisal Report
        Route::resources([ 
            'appraisal'=>'Appraisal\AppraisalController',
            'pip'=>'PipController',
            'scf-data'=>'ScfDataController',
            'scf'=>'ScfController',
            'performance-review'=>'PerformanceReviewController',
            'probation-period-review'=>'PprFormController',
            'probationary-appraisals'=>'ProbationaryAppraisalController',
            'pip-appraisal'=>'Appraisal\AppraisalController'
        ]);

        Route::post('appraisal/get-employee-details', 'Appraisal\AppraisalController@getEmployeeDetails')->name('getEmployeeDetails');
        Route::post('appraisal/edit-employee-details', 'Appraisal\AppraisalController@editEmployeeDetails')->name('editEmployeeDetails');
        Route::any('appraisal/update/{id}', 'Appraisal\AppraisalController@updateEmployeeDetails')->name('appraisalreport.update');
        Route::any('appraisal/hr-comment/{id}', 'Appraisal\AppraisalController@update_hr_comment')->name('appraisalreport.hr_comment');
        Route::any('appraisal/emploees_filter', 'Appraisal\AppraisalController@emploees_filter')->name('appraisalreport.emploees_filter');
        Route::post('appraisal/show', 'Appraisal\AppraisalController@show')->name('appraisalreport.show');
        Route::any('appraisal/delete/{id}', 'Appraisal\AppraisalController@delete')->name('appraisalreport.delete');
             //PIP Appraisal
        Route::post('pip-appraisal/get-employee-details', 'Appraisal\AppraisalController@pip_getEmployeeDetails')->name('pip-appraisal.getEmployeeDetails');
        Route::post('pip-appraisal/edit-employee-details', 'Appraisal\AppraisalController@pip_editEmployeeDetails')->name('pip-appraisal.editEmployeeDetails');
        Route::post('pip-appraisal/show', 'Appraisal\AppraisalController@pip_show')->name('pip-appraisal.show');
        Route::any('pip-appraisal/update/{id}', 'ProbationaryAppraisalController@updateEmployeeDetails')->name('pip-appraisal.update');


        //ppr
        Route::post('probation-period-review/get-employee-details', 'PprFormController@getEmployeeDetails')->name('ppr.getEmployeeDetails');
        Route::post('probation-period-review/edit-employee-details', 'PprFormController@editEmployeeDetails')->name('ppr.editEmployeeDetails');
        Route::post('probation-period-review/show', 'PprFormController@show')->name('ppr.show');
        Route::any('probation-period-review/delete/{id}', 'PprFormController@delete')->name('ppr.delete');
        Route::any('probation-period-review/emploees_filter', 'PprFormController@emploees_filter')->name('probation-period-review.emploees_filter');

        //scf
        Route::post('scf/get-employee-details', 'ScfController@getEmployeeDetails')->name('scf.getEmployeeDetails');
        Route::post('scf/edit-employee-details', 'ScfController@editEmployeeDetails')->name('scf.editEmployeeDetails');
        Route::post('scf/show', 'ScfController@show')->name('scf.show');
        Route::any('scf/delete/{id}', 'ScfController@delete')->name('scf.delete');

        //pip
        Route::post('pip/get-employee-details', 'PipController@getEmployeeDetails')->name('pip.getEmployeeDetails');
        Route::post('pip/edit-employee-details', 'PipController@editEmployeeDetails')->name('pip.editEmployeeDetails');
        Route::post('pip/show', 'PipController@show')->name('pip.show');
        Route::any('pip/delete/{id}', 'PipController@delete')->name('pip.delete');

        Route::get('/calendar', 'SchoolEventController@index')->name('calendar');
       // Route::get('/calendar/allEvents', 'SchoolEventController@allEvents')->name('calendar.allEvents');changeEventDate
        Route::post('/calendar/addUpdateEvent', 'SchoolEventController@addUpdateEvent')->name('calendar.addUpdateEvent');
        Route::post('/calendar/UpdateEvent', 'SchoolEventController@updateEvent')->name('calendar.UpdateEvent');
        Route::post('/calendar/deleteEvent', 'SchoolEventController@removeEvent')->name('calendar.DeleteEvent');
        Route::post('/calendar/changeEventDate', 'SchoolEventController@changeEventDate')->name('calendar.changeEventDate');
        //Attendance module
        Route::resources([ 
            'attendance'=>'Attendance\AcademicAttendanceController'
        ]);
        Route::any('attendance/getcheckin/{check_in}/{employee_id}','Attendance\AcademicAttendanceController@getcheckin')->name('attendance.getcheckin');
        Route::get('attendance/getdata/{startDate}','Attendance\AcademicAttendanceController@getdata')->name('attendance.getdata');
        Route::any('attendance/getleave/{leave}/{employee_id}','Attendance\AcademicAttendanceController@getleave')->name('attendance.getleave');
        Route::post('add_attendance','Attendance\AcademicAttendanceController@add_attendance')->name('add_attendance');


        /*Employee onboarding new*/
        Route::post('/save-employee-main-data', 'Employee\EmployeesController@saveEmployeeMainData')->name('save-employee-main-data');
        Route::post('/save-employee-other-data', 'Employee\EmployeesController@saveEmployeeOtherData')->name('save-employee-other-data');
        Route::post('/save-employee-file-data', 'Employee\EmployeesController@saveEmployeeFileData')->name('save-employee-file-data');
        Route::post('/save-employee-payroll-data', 'Employee\EmployeesController@saveEmployeePayrollData')->name('save-employee-payroll-data');
        Route::post('/deleteFile', 'Employee\EmployeesController@deleteFile')->name('deleteFile');
        Route::get('/showFiles/{id}', 'Employee\EmployeesController@showFiles')->name('showFiles');

        /*Reports */
        Route::get('/employee-report','ReportsController@employeeIndex')->name('employeereportsshow');
        Route::any('/employee-report/filter','ReportsController@employeeFilter')->name('employeereportsfilter');
        Route::any('/employee-report/reset','ReportsController@employeeReset')->name('employeereportsreset');
        Route::get('/employee-report/{format}','ReportsController@employeeExport')->name('employeereportsExport');
        Route::get('/employee-report/{format}/{id}','ReportsController@employeeExportId')->name('employeereportsExportId');
        Route::get('/payroll-report','ReportsController@payrollIndex')->name('payrollreportshow');
        Route::get('/payroll-report/{format}','ReportsController@payrollExport')->name('payrollreportExport');
        Route::get('/perfomance-report','ReportsController@perfomanceIndex')->name('perfomancereportsshow');
        Route::get('/get_performance_report','ReportsController@permanceData')->name('perfomancereportsdata');
        //perfomance report
        Route::get('/get_appraisal_report/{id}','ReportsController@appraisal_report')->name('appraisal.report');
        Route::get('/get_ppr_report/{id}','ReportsController@ppr_report')->name('ppr_related.report');
        Route::get('/get_scf_report/{id}','ReportsController@scf_report')->name('scf_related.report');
        Route::get('/get_pip_report/{id}','ReportsController@pip_report')->name('pip_related.report');

        Route::get('/timesheet-report','ReportsController@employee_timesheet_report')->name('timesheetreportshow');
        Route::post('/timesheet-report','ReportsController@employee_timesheet_report')->name('timesheet-report.post');
        //Route::get('/timesheet-report','ReportsController@timesheetIndex')->name('timesheetreportshow');
        //Route::get('/timesheet-report/{format}','ReportsController@timesheetExport')->name('timesheetExport');

        Route::get('/gratuity-report','ReportsController@gratuityreport')->name('gratuityreport');
        Route::post('/final-pay','ReportsController@final_pay')->name('final-pay');
        Route::post('/final-statement','ReportsController@final_statement')->name('final-statement');

        Route::get('/attendance-report','ReportsController@attendance_report')->name('attendance-report');
        Route::post('/attendance-report','ReportsController@attendance_report')->name('attendance-report.post');

        Route::get('/emp-presence-report','ReportsController@employee_presence_report')->name('emp-presence-report');
        Route::post('/emp-presence-report','ReportsController@employee_presence_report')->name('emp-presence-report.post');
        
        Route::get('/monthly_leave_report','ReportsController@monthly_leave_report')->name('monthly_leave_report');
        Route::post('/monthly_leave_report','ReportsController@monthly_leave_report')->name('monthly_leave_report.post');
        Route::get('/employee_leave_sheet','ReportsController@employee_leave_sheet')->name('employee_leave_sheet');
        Route::post('/employee_leave_sheet_report','ReportsController@employee_leave_sheet_report')->name('employee_leave_sheet_report');

        /*Route::get('/resultpage', 'ReportsController@showResultPage')->name('resultpage');*/

        /*Streaming*/
        /*Route::get('/sse', 'EventSourceController@index')->name('sse');*/

    });   

});