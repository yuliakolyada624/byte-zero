<?php

namespace App\Modules\Orders\Models;

use CodeIgniter\Model;

class OrderExhibitsModel extends Model
{
    protected $table = 'order_exhibits';
    protected $primaryKey = 'id';
    
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $returnType     = OrderExhibitsModel::class;

    protected $allowedFields = [
        'order_id',
        'origin',
        'hash',
        'page_count',
    ];

    /**
     * Fetch exhibits by order ID.
     *
     * @param int $orderId
     * @return array
     */
    public function getExhibitsByOrderId(int $orderId): array
    {
        return $this->where('order_id', $orderId)
                    ->findAll();
    }
}
