<?php

/*
    helper('App\Modules\Notifications\Helpers\notifications');
    sendNotification(2, 'Test notification', 'Rewards Update');
*/

// type = 'System Message','Rewards Update','Pending Booking','Confirmed Booking','Cancelled Booking'

function sendNotification($to_id, $message, $type = "System Message", $from_user_id = 0, $title = '')
{

    $notificationsModel = new App\Modules\Notifications\Models\NotificationsModel();

    $notificationsModel->sendNonification(
        $to_id,
        $message,
        $type,
        $from_user_id,
        $title
    );
}



function getUnreadNotification(){
    $notificationsModel = new App\Modules\Notifications\Models\NotificationsModel();
    $user = auth()->user();
        if (is_null($user)) {
            return 0;
        }

    $NewNotifications = $notificationsModel->Where('user_id', $user->id)->Where('status<2')->findAll();
    return (isset($NewNotifications) ? sizeof($NewNotifications) : '0');
}
