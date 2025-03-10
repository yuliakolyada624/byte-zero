<?php namespace App\Modules\Notifications\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class NotificationsModel extends Model
{
    protected $table  = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields  = [
        'title',
        'message',
        'user_id',
        'status',
		'read_at',
        'from_user_id',
        'link',
        'type'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $returnType     = NotificationsModel::class;

    protected $afterFind = ['afterFind_GetTimeAgo'];


    protected function afterFind_GetTimeAgo(array $data): array
    {
        $db = \Config\Database::connect();
        if($data['singleton']){
            
            $current = Time::now();
            $to_diff    = Time::parse($data['data']->created_at);
            $diff = $current->difference($to_diff);

            $data['data']->time_ago = $diff->humanize();

            if($data['data']->link==''){
                $data['data']->link = '#';
            }

        } else {
            foreach ($data['data'] as $i=>$row) {
                $current = Time::now();
                $to_diff    = Time::parse($data['data'][$i]->created_at, );
                $diff = $current->difference($to_diff);
                $data['data'][$i]->time_ago = $diff->humanize();

                if($data['data'][$i]->link==''){
                    $data['data'][$i]->link = '#';
                }
            }
        }
        
        return $data;
    }


    public function sendNonification($user_id, $message, $type="System Message", $from_user_id=0, $title='')
    {
        if(!$user_id || !$message){
            return false;
        }

        // type :  'System Message','Rewards Update','Pending Booking','Confirmed Booking','Cancelled Booking'

        $res = $this->save([
            'title'         => $title,
            'message'       => $message,
            'user_id'       => $user_id,
            'from_user_id'  => $from_user_id,
            'type'          => $type,
            'status'        => 0
        ]);

        return $res;
    }


}