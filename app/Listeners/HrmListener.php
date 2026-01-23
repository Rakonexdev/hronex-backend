<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kreait\Firebase\Database;
use Illuminate\Support\Facades\DB;

class HrmListener
{

    protected $firebase;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Database $firebase)
    {
        $this->firebase = $firebase;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }
}
