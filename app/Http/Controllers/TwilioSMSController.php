<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Exception;
use Twilio\Rest\Client;
  
class TwilioSMSController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
{
    // $users = UsersPhoneNumber::all(); //query db with model
    return view('sms-template'); //return view with data
}

    public function send()
    {
        $receiverNumber = "+923240533559";
        $message = "This is testing from interactiveTechSolutions.com";
  
        try {
  
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");
  
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
  
            dd('SMS Sent Successfully.');
  
        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }
    }
    public function sendCustomMessage(Request $request)
    {
        
        $validatedData = $request->validate([
            'body' => 'required',
        ]);
        // dd($validatedData["body"]);
        // $recipients = $validatedData["users"];
        // iterate over the array of recipients and send a twilio request for each
        $this->sendMessage($validatedData["body"], '+923240533559');
        // foreach ($recipients as $recipient) {
        // }
        return back()->with(['success' => "Messages on their way!"]);
    }


    private function sendMessage($message, $recipient)
    {
        $account_sid = getenv("TWILIO_SID");
        // dd($account_sid);
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipient, 
                ['from' => $twilio_number, 'body' => $message] );
    }


}
