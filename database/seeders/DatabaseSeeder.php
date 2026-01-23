<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Employee\Employees;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\RoleAndPermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('employees')->truncate();
        DB::table('menu_links')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create( [
            'name'=>'Arif Hussain',
            'role'=>0,
            'email'=>'admin@admin.com',
            'email_verified_at'=>'2023-01-09 18:30:00',
            'password'=>Hash::make('123456'),
            'is_admin'=>1,
            'remember_token'=>'1',
            'avatar'=>'avatar.png',
            'created_at'=>NULL,
            'updated_at'=>NULL
        ] );

        \App\Models\Employee\Employees::create( [
            'user_id'=>1,
            'employee_id'=>1,
            'name'=>'Arif',
            'lname'=>'Hussain',
            'gender'=> 'Male',
            'dob'=>'2023-03-20',
            'age'=>30,
            'email'=>'admin@admin.com',
            'nationality'=>11,
            'marital_status'=>'Married',
            'mobile1_code'=>'91',
            'mobile1'=>'9876543210',
            'qidno'=>152,
            'qidexpiry'=>'2023-03-20',
            'passportno'=>8565656566585465,
            'passportexpiry'=>'2023-03-20',
            'joiningdate'=>'2023-03-20',
            'department'=>1,
            'designation'=>1,
            'school_shift'=>1,
            'end_probation'=>'2023-03-20',
            'contract_type'=>1,
            'contract_length'=>2,
            'end_contract'=>'2023-03-20',
            'service_years'=>2,
            'sponsorship_status'=>1,
            'relevant_degree'=>1,
            'degree_attaches'=>'',
            'degree_attest_status'=>1,
            'moe_approval_status'=>1
        ] );


        DB::table('menu_links')->insert( [
            'id'=>1,
            'position'=>1,
            'name'=>'Dashboard',
            'path'=>'dashboard',
            'parentid'=>0,
            'menutype'=>'SB',
            'status'=>1
        ] );

        DB::table('menu_links')->insert( [
            'id'=>2,
            'position'=>2,
            'name'=>'Employees',
            'path'=>'employees',
            'parentid'=>0,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>3,
            'position'=>3,
            'name'=>'Leaves',
            'path'=>'#',
            'parentid'=>0,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>4,
            'position'=>4,
            'name'=>'Leave Applications',
            'path'=>'leaveapply',
            'parentid'=>3,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>5,
            'position'=>5,
            'name'=>'Leave Approval',
            'path'=>'leaveapproval',
            'parentid'=>3,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>6,
            'position'=>6,
            'name'=>'Masters',
            'path'=>'#',
            'parentid'=>0,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>7,
            'position'=>7,
            'name'=>'Academic Year',
            'path'=>'academicyear',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>8,
            'position'=>8,
            'name'=>'Departments',
            'path'=>'departments',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>9,
            'position'=>9,
            'name'=>'Designations',
            'path'=>'designations',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>10,
            'position'=>10,
            'name'=>'Leave Types',
            'path'=>'leavetypes',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>11,
            'position'=>11,
            'name'=>'Approval Status',
            'path'=>'approvalstatus',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>12,
            'position'=>12,
            'name'=>'Paid Status',
            'path'=>'paidstatus',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>13,
            'position'=>13,
            'name'=>'Payment Deduction Type',
            'path'=>'paydeductiontype',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>14,
            'position'=>14,
            'name'=>'School Shift',
            'path'=>'schoolshift',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>15,
            'position'=>15,
            'name'=>'Contract Type',
            'path'=>'contracttype',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>16,
            'position'=>16,
            'name'=>'Sponsorship Status',
            'path'=>'sponsstatus',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>17,
            'position'=>17,
            'name'=>'Relevant Degree',
            'path'=>'relevantdegree',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>18,
            'position'=>18,
            'name'=>'MOE approval status',
            'path'=>'moeapprstatus',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>19,
            'position'=>19,
            'name'=>'Medical Ailment',
            'path'=>'medicalailment',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>20,
            'position'=>20,
            'name'=>'Appraisal Data',
            'path'=>'appraisaldata',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>21,
            'position'=>21,
            'name'=>'Inactive Status',
            'path'=>'inactivestatus',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>22,
            'position'=>22,
            'name'=>'Inactive Reason',
            'path'=>'inactivereason',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

                    
        DB::table('menu_links')->insert( [
            'id'=>23,
            'position'=>23,
            'name'=>'Relationship',
            'path'=>'relationship',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

        DB::table('menu_links')->insert( [
            'id'=>24,
            'position'=>24,
            'name'=>'Budget Type',
            'path'=>'budgettype',
            'parentid'=>6,
            'menutype'=>'SB',
            'status'=>1
        ] );

        $this->call([
            RoleAndPermissionSeeder::class,
        ]);
    }
}
