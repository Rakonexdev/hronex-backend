<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\SchoolEvent;
use App\Notifications\AllNotification;
use DB;

class SchoolEventController extends HrmController
{
    /**
     * 
    **/
    public function index()
    {   
        $all_events = $this->allEvents();
        return view('calendar_events.view', compact('all_events') );
    }

    public function allEvents()
    {
        $all_events = SchoolEvent::where('active', 1)->get();
        return $all_events;
    }

    public function singleEvent($event_id)
    {
        $event = SchoolEvent::where('id', $event_id)
                                ->where('active', 1)->first();
        return $event;
    }

    public function addUpdateEvent(Request $request)
    {
        $data = $request->validate([
            'Event_name' => 'required',
            'Event_from' => 'required',
            'Event_end' => 'required',
            'Event_type' => 'required',
            'Event_details' => 'required'
        ]);

        /*$academic_year = DB::table('academic_year')->where('active', 1)->select('id')->first();
        $id = $academic_year->id;*/
        $id = $this->academic_year;
        
        /*dd($request);*/
        $userId = Auth::id();
        $dateAndTime_from = $request->input('Event_from');
        $carbonDateTime_from = Carbon::parse($dateAndTime_from);
        $date_from = $carbonDateTime_from->toDateString();
        $date_from_time = $carbonDateTime_from->format('Y-m-d H:i:s');

        $dateAndTime_to = $request->input('Event_end');
        $carbonDateTime_to = Carbon::parse($dateAndTime_to);
        $date_to = $carbonDateTime_to->toDateString();
        $date_to_time = $carbonDateTime_from->format('Y-m-d H:i:s');
        //dd($date_to);
        try {
            $event_title = $request->input('Event_name');
            $event_type = $request->input('Event_type');

            if (!empty($event_title) && !empty($event_type)) {
                //dd($event_title);
                $schoolEvent = SchoolEvent::create([
                    'academic_year' => $id,
                    'event_title' => $event_title,
                    'event_details' => $request->input('Event_details'),
                    'event_from' => $date_from,
                    'event_to' => $date_to,
                    'event_type' => $event_type,
                    'event_time_from' => $date_from_time,
                    'event_time_to' => $date_to_time,
                    'applicable_to'=>$request->input('Event_for'),
                    'bg_color' => $request->input('bg_colour'),
                    'created_by'=>$userId ,
                    'updated_by' => $userId,
                    'active'=>1,
                ]);
                //dd($schoolEvent);
                $schoolEvent->save();

                /*Notification area*/                            
                $notif = new AllNotification();

                /*Store notifications: Add notification data to table*/
                $notifdata['type'] = $this->notification_list[3]; /*trans('messages.clndr_evnt_notif');*/ 
                $notifdata['notifiable_type'] = 'App\Models\SchoolEvent';
                $notifdata['notifiable_id'] = 0;
                $notifdata['title'] = $event_title; /*trans('messages.clndr_evnt_notif');*/
                $notifdata['title_date'] = $date_from;
                $notifdata['data'] = trans('messages.clndr_evnt_notif_add');
                $notifdata['link'] = 'calendar';
                $notifs = $notif->addnotifications($notifdata); 

                /*Handle the push notification */   
                if(1==$notifs){
                    $notif->passNotification();                    
                }

                return redirect()->back()->with('success', trans('messages.successO'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', trans('messages.errorCom'));
        }
    }

    public function updateEvent(Request $request){
        
        try{
            $id = $request->input('id');
            $title = $request->input('event_title');
            $school_event = SchoolEvent::find($id);
            $school_event->event_title = $title;
            $school_event->event_details = $request->input('Event_details');
            $school_event->event_type = $request->input('Event_type');
            $school_event->applicable_to = $request->input('Event_for');
            $school_event->bg_color = $request->input('bg_colour');
            $school_event->save();

            /*Notification area*/                            
            $notif = new AllNotification();

            /*Store notifications: Add notification data to table*/
            $notifdata['type'] = $this->notification_list[3]; 
            $notifdata['notifiable_type'] = 'App\Models\SchoolEvent';
            $notifdata['notifiable_id'] = 0;
            $notifdata['title'] = $title; /*trans('messages.clndr_evnt_notif');*/
            $notifdata['title_date'] = $school_event->event_from;
            $notifdata['data'] = trans('messages.clndr_evnt_notif_upd');
            $notifdata['link'] = 'calendar';
            $notifs = $notif->addnotifications($notifdata); 

            /*Handle the push notification */   
            if(1==$notifs){
                $notif->passNotification();                    
            }

            return response()->Json(['message' => 'Event updated successfully']);
        }catch(\Exception $e){
            return response()->Json(['message' => 'Event updated Failed']);
        }
        
    }

    public function changeEventDate(Request $request)
    {
       // dd($request);
        try{
            $id = $request->input('id');
            $title = $request->input('title');
            $start_date = $request->input('start');
            $carbonDateTime_from = Carbon::parse($start_date);
            $date_from = $carbonDateTime_from->format('Y-m-d');
            $time_from = $carbonDateTime_from->format('H:i:s');
            
            $end_date = $request->input('end');
            if ($end_date === null) {
                $end_date = $start_date;
            }
            $carbonDateTime_to = Carbon::parse($end_date);
            $date_to = $carbonDateTime_to->format('Y-m-d');
            $time_to = $carbonDateTime_to->format('H:i:s');
            
            $school_event = SchoolEvent::find($id);
            $school_event->event_title = $title;
            $school_event->event_from = $date_from . ' ' . $time_from;
            $school_event->event_to = $date_to . ' ' . $time_to;
            
            $existing_time_from = Carbon::parse($school_event->event_time_from);
            $existing_time_to = Carbon::parse($school_event->event_time_to);
            $school_event->event_time_from = $date_from . ' ' . $existing_time_from->format('H:i:s');
            $school_event->event_time_to = $date_to . ' ' . $existing_time_to->format('H:i:s');
            
            $school_event->save();

            /*Notification area*/                            
            $notif = new AllNotification();

            /*Store notifications: Add notification data to table*/
            $notifdata['type'] = $this->notification_list[3]; 
            $notifdata['notifiable_type'] = 'App\Models\SchoolEvent';
            $notifdata['notifiable_id'] = 0;
            $notifdata['title'] = $title; /*trans('messages.clndr_evnt_notif');*/
            $notifdata['title_date'] = $date_from;
            $notifdata['data'] = trans('messages.clndr_evnt_notif_chg');
            $notifdata['link'] = 'calendar';
            $notifs = $notif->addnotifications($notifdata); 

            /*Handle the push notification */   
            if(1==$notifs){
                $notif->passNotification();                    
            }

            return response()->Json(['message' => 'Event updated successfully']);
        }catch(\Exception $e){
            return response()->Json(['message' => 'Event updated Failed']);
        }
    }

    public function removeEvent(Request $request)
    {
        try {
            $id = $request->input('id');
            $school_event = SchoolEvent::find($id);
            if (!$school_event) {
                return redirect()->back()->with('error', trans('messages.eventNotFound'));
            }
    
            $school_event->delete();
    
            //return redirect()->back()->with('success', trans('messages.eventDeleted'));
            return response()->Json(['message' => trans('messages.successD')]);
        } catch (\Exception $e) {
            //return redirect()->back()->with('error', trans('messages.errorCom'));
            return response()->Json(['message' => trans('messages.errorCom')]);
        } 
    }

}
