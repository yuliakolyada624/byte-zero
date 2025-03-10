<?php 
namespace App\Listeners;

use CodeIgniter\Events\Events;
use CodeIgniter\I18n\Time;
use App\Modules\User\Models\UserModel;

class UpdateLastLogin
{
    public function handle($event)
    {
        // Get the authenticated user ID from the event data
        $user = auth()->user();
        
        if ($user) {
            // Create an instance of the user model
            $userModel = new UserModel();

            // Update the user's last_login field
            $userModel->update($user->id, [
                'last_login' => Time::now('UTC')->toDateTimeString(),
            ]);
        }
    }
}
