<?php namespace App\Modules\Notifications\Controllers;

use App\Modules\Notifications\Models\NotificationsModel;
use CodeIgniter\Controller;


class NotificationController extends Controller {

    private $notificationsModel;

    public function __construct()
    {
        $this->notificationsModel =  new NotificationsModel();
    }

    
    public function update()
    {
        $id = $this->request->getVar('id');
        $status = $this->request->getVar('status');
        $user = auth()->user();

        $resp = [
            'success' => false
        ];
        
        if ($user && $id) {
            $message = $this->notificationsModel->find($id);

            if($message->user_id ==$user->id){
                $this->notificationsModel->save([
                    'id' => $id,
                    'user_id' => $user->id,
                    'status'   => $status
                ]);

                $resp = [
                    'success' => true
                ];
            }
        }
        
        return $this->response->setJSON($resp);
    }


    public function delete()
    {
        $id = $this->request->getVar('id');
        $user = auth()->user();

        $resp = [
            'success' => false
        ];
        
        if ($user && $id) {
            $message = $this->notificationsModel->find($id);

            if($message->user_id ==$user->id){
                $this->notificationsModel->save([
                    'id' => $id,
                    'status'   => '3'
                ]);
                

                $resp = [
                    'success' => true
                ];
            }
        }
        
        return $this->response->setJSON($resp);
    }

    public function deleteForever()
    {
        $id = $this->request->getVar('id');
        $user = auth()->user();

        $resp = [
            'success' => false
        ];
        
        if ($user && $id) {
            $message = $this->notificationsModel->find($id);

            if($message->user_id ==$user->id){
                $this->notificationsModel->save([
                    'id' => $id,
                    'status'   => '3'
                ]);
                //soft delete!
                $this->notificationsModel->delete($id);

                $resp = [
                    'success' => true
                ];
            }
        }
        
        return $this->response->setJSON($resp);
    }


    
} 
