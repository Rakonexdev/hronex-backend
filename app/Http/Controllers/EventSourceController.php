<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EventSourceController extends Controller
{
    public function index()
    {
        $response = new StreamedResponse(function () {
            while (true) {
                // Your logic to fetch data from the server
                $data = "ABC";// Fetch data from your data source
                
                // Send data to the client
                echo "data: " . json_encode($data) . "\n\n";
                ob_flush();
                flush();
                
                // Delay between sending events (optional)
                sleep(1);
            }
        });
        
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        
        return $response;
    }
}
