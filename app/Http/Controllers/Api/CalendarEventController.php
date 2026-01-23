<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Carbon\Carbon;
use App\Models\User;
use App\Models\SchoolEvent;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\SchoolEventController;

class CalendarEventController extends BaseController
{

	public function allEvents()
	{
		$school_events = new SchoolEventController();
		$data = $school_events->allEvents();

		$success['success'] = $data;
        $msg = '';
        return $this->sendResponse($success, $msg);
	}

	public function singleEvent($event_id)
    {
    	$school_events = new SchoolEventController();
        $data = $school_events->singleEvent($event_id);

        $success['success'] = $data;
        $msg = '';
        return $this->sendResponse($success, $msg);
    }
    public function dateEvent($date)
    {
       
        $events = SchoolEvent::whereDate('event_from', '<=', $date)
            ->whereDate('event_to', '>=', $date)
            ->get();
        //dd($events);
        $data = $events;
        $success['success'] = $data;
        $msg = '';
        return $this->sendResponse($success, $msg);
    }
}