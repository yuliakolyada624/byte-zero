<?php namespace App\Modules\Notifications\Controllers;

use App\Modules\Notifications\Models\NotificationsModel;
use CodeIgniter\Controller;

class StreamerController extends Controller {

    public function index() {
        header("Content-Type: text/event-stream");
        header("Cache-Control: no-cache");
        
        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        $request = \Config\Services::request();
        $client_id = $request->getVar('client_id');
        $last_id = $request->getHeaderLine('Last-Event-ID');

        // var_dump($last_id); die;
        // Here will be data sourcing from DB and processing by external API

        $notificationsModel = new NotificationsModel();
        if($last_id){
            $notificationsModel->Where('id>'.$last_id);
        }

        $messages = $notificationsModel->Where('user_id', $client_id)->Where('status<3')->findAll(200);

            if(isset($messages)){
                foreach($messages as $i=>$message){
                    echo "data:", json_encode($message)."\n", "id: ".($message->id)."\n\n", "retry: 15000\n\n";    
                    flush();
                    if($message->status==0){
                        $notificationsModel->update($message->id, ['status' => '1']);
                    }
                }
            }
        flush();
        exit; // without it was throwing "Headers already sent" warning
    }
} 

/*

use CodeIgniter\I18n\Time;

/*for ($i=0; $i < 6 ; $i++) {
            echo "data:", "Server time is ".date(DATE_ISO8601)." client_id =  ".$client_id."\n", "id: $i\n\n", "retry: 15000\n\n";
            
            // cloce server
            /*if($i==5){
                echo "data:", "done"."\n\n", " retry: 15000\n\n";
            }*/ 
            /*
            flush();
            sleep(1);
        }*/ /*
        //  echo "data: done\n\n"; // Gives browser a signal to close connection
*/
