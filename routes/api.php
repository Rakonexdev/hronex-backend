<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:api'])->group(function () {
    Route::get('/employees/{id}', 'Api\Employee\EmployeeController@show');
    Route::get('/employee-document/{id}', 'Api\Employee\EmployeeController@employeeDocument');
    Route::get('/employee-doc-expiries/{id}', 'Api\Employee\EmployeeController@employeeDocExpiries');
    Route::get('/employeelist', 'Api\Employee\EmployeeController@list');

    // Leave
    Route::get('/leave-types', 'Api\Leave\LeaveController@leaveTypes');
    Route::get('/leave-history/{id}', 'Api\Leave\LeaveController@showLeaveDetails');
    Route::get('/leave-track/{id}', 'Api\Leave\LeaveController@trackLeaveDetails');
    Route::get('/leave-total/{id}', 'Api\Leave\LeaveController@totalLeaves');
    Route::post('/apply-leave', 'Api\Leave\LeaveController@applyLeave');
    Route::post('/approve-leave', 'Api\Leave\LeaveController@approveLeave');
    Route::post('/approve-leave2', 'Api\Leave\LeaveController@approve');
    Route::post('/attach-leave-doc', 'Api\Leave\LeaveController@attachLeaveDoc');
    Route::post('/leave-cancel', 'Api\Leave\LeaveController@leaveCancel');

    // Health informations
    Route::resource('/health-information', 'Api\Employee\HealthInfoController');

    // Emergency informations
    Route::resource('/emergency-information', 'Api\Employee\EmergencyController');

    // Masters
    Route::get('/relationships', 'Api\Masters\RelationshipController@relationships');
    Route::get('/designations', 'Api\Masters\MasterDataController@designations');
    Route::get('/masters/{table}', 'Api\Masters\MasterDataController@allMasters')->name('masters');

    // Payroll
    Route::resource('/payroll-create', 'Api\Payroll\PayrollController');

    // Attendance
    Route::post('/attendance-mark', 'Api\Attendance\AttendanceController@markAttendance');
    Route::get('/attendance-history/{id}', 'Api\Attendance\AttendanceController@attendanceHistory');
    Route::get('/attendance-numbers', 'Api\Attendance\AttendanceController@generateRandomNumbers');
    Route::post('/attendance-status','Api\Attendance\AttendanceController@getstatus');
    Route::post('/attendance-track','Api\Attendance\AttendanceController@attendancetrack');
    Route::post('/allattendance-mark', 'Api\Attendance\AttendanceController@markAttendanceAll');

    //Salary 
    Route::post('/salary-payslip','Api\Salary\MonthlysalarieController@getpayslip');

    //Appraisal
    Route::get('/appraisal-review/{id}','Api\Appraisal\AppraisalController@getappraisalreview');
    Route::post('/appraisal-employee-comment','Api\Appraisal\AppraisalController@empolyeecomment');

    //pip
    Route::get('/pip/{id}','Api\Appraisal\AppraisalController@get_pip_review');
    Route::post('/pip','Api\Appraisal\AppraisalController@pip_empolyeecomment');

    //prf
    Route::get('/prf/{id}','Api\Appraisal\AppraisalController@get_prf_review');
    Route::post('/prf','Api\Appraisal\AppraisalController@prf_empolyeecomment');
    
    //Notification
    Route::get('/notification/{id}','Api\Employee\EmployeeController@notification');

    Route::post('logout', 'Api\Auth\AuthController@logout')->name('logout');

    Route::post('changePassword', 'Api\Auth\AuthController@updateYourPassword')->name('changePassword');
    Route::post('/change_avatar', 'Api\Employee\EmployeeController@update_avatar');

    //Calendar events
    Route::get('/calendar-data','Api\CalendarEventController@allEvents');
    Route::get('/single-event/{id}','Api\CalendarEventController@singleEvent');
    Route::get('/date-event/{date}','Api\CalendarEventController@dateEvent');

    Route::get('current-updates', 'Api\Employee\EmployeeController@currentUpdates');
    Route::post('notif-mark-read', 'Api\Employee\EmployeeController@updateNotifRead');
});

Route::post('/login', 'Api\Auth\AuthController@login');
Route::post('/forgot-password', 'Api\Auth\AuthController@sendResetLinkEmail');
Route::post('/contact-us', 'Api\Auth\AuthController@reachOut');
Route::get('/terms', 'Api\Auth\AuthController@terms');
Route::get('/privacy', 'Api\Auth\AuthController@privacy');