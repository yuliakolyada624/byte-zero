<?php namespace App\Modules\Orders\Models;

use App\Libraries\Filters;
use App\Modules\Transactions\Models\TransactionsModel;
use CodeIgniter\Model;

class OrdersModel extends Model
{
    protected $table  = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields  = [
        'creater_user_id',
		'order_status',
		'checkout_session_id',
		'billed_amount', 
		'billed_currency',
		'order_number',
		'claim_type',		
		'claim_number',
		'report_type',
		'case_name',
		'plaintiff_first_name',
		'plaintiff_last_name',
		'plaintiff_dob',
		'plaintiff_gender',
		'defendant_first_name',
		'defendant_last_name',
		'defendant_company_name',
		'date_of_incident',
		'location_of_accident',
		'injury_areas',
		'exhibit_count',
		'page_count',
		'time_created',
		'time_paid',
		'time_ml_processed',
		'reviewer_user_id',	
		'time_fully_reviewed',
		'fully_reviewed',
		'reviewed',
		'approver_user_id',
		'time_approval',
		'approved',
		'approval_notice_for_reviewer',
		'time_due',
		'number_of_downloads',
		'time_last_download',
		'progress',
    ];

	protected $afterFind = ['afterFind_getProgress'];


	// Add a flag to include payment transactions
	protected $includePaymentTransaction = false;

	
	/**
	 * Sets the flag to include payment transaction data
	 *
	 * @return $this
	 */
	public function withPaymentTransaction()
	{
		$this->includePaymentTransaction = true;
		return $this;
	}



	/**
     * Overrides the find method to include payment transactions if needed
     *
     * @param mixed $id
     * @return mixed
     */
    public function find($id = null)
    {
        $result = parent::find($id);

        if ($this->includePaymentTransaction) {
            $result = $this->includePaymentTransactionData($result);
            // Reset the flag after use
            $this->includePaymentTransaction = false;
        }

        return $result;
    }

    /**
     * Overrides the findAll method to include payment transactions if needed
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findAll($limit = 0, $offset = 0)
    {
        $results = parent::findAll($limit, $offset);

        if ($this->includePaymentTransaction) {
            foreach ($results as &$result) {
                $result = $this->includePaymentTransactionData($result);
            }
            // Reset the flag after use
            $this->includePaymentTransaction = false;
        }

        return $results;
    }

	/**
	 * Overrides the paginate method to include payment transactions if needed
	 *
	 * @param int $perPage
	 * @param string $group
	 * @param int $page
	 * @param int $segment
	 * @return mixed
	 */
	public function paginate($perPage = null, $group = 'default', $page = null, $segment = 0)
	{
		$pager = \Config\Services::pager();

		$perPage = $perPage ?? $this->perPage;
		$page = $page ?? $pager->getCurrentPage($group, $segment);

		$total = $this->countAllResults(false);

		$this->pager = $pager->store($group, $page, $perPage, $total, $segment);

		$offset = ($page - 1) * $perPage;

		$results = $this->findAll($perPage, $offset);

		// Include payment transaction data if the flag is set
		if ($this->includePaymentTransaction) {
			foreach ($results as &$result) {
				$result = $this->includePaymentTransactionData($result);
			}
			// Reset the flag after use
			$this->includePaymentTransaction = false;
		}

		return $results;
	}


	/**
	 * Includes payment transaction data into the result
	 *
	 * @param array|object $data
	 * @return array|object
	 */
	protected function includePaymentTransactionData($data)
	{
		/*$paymentModel = new TransactionsModel();
		$paymentTransaction = $paymentModel->where('order_id', $data['id'])->first();

		if (is_array($data)) {
			$data['payment_transaction'] = $paymentTransaction;
		} else {
			$data->payment_transaction = $paymentTransaction;
		}*/
		
        if (is_array($data)) {
			$data['payment_transaction'] = null;
		} else {
			$data->payment_transaction = null;
		}

		return $data;
	}



	public function getOrdersList():array
	{
		return [];
	}


	// Method to get orders by claim type
	public function getOrdersByClaimType($claimType, $creater_user_id)
	{
		return $this->where('claim_type', $claimType)
					->where('creater_user_id', $creater_user_id)
					->findAll();
	}

	public function getOrdersCountByClaimType($claimType, $creater_user_id)
{
    return $this->where('claim_type', $claimType)
                ->where('creater_user_id', $creater_user_id)
                ->countAllResults();
}

	public function searchPlaintiffDefendantNames(string $query, int $companyId): array
	{
		return $this->select('plaintiff_first_name, plaintiff_last_name, defendant_first_name, defendant_last_name')
		->where('creater_user_id IN (SELECT id FROM users WHERE company_id = ' . $companyId . ')') // Assuming a `users` table with `company_id`
		->groupStart()
			->like('plaintiff_first_name', $query)
			->orLike('plaintiff_last_name', $query)
			->orLike('defendant_first_name', $query)
			->orLike('defendant_last_name', $query)
		->groupEnd()
		->findAll();
	}


	public function updateOrderProgressAndStatus($order)
    {
        // Initialize the progress and status
        $order['progress'] = 0;
        $order['status'] = 'In Progress';
        $order['status_color'] = '';  // Default color if no progress
		$order['badge_status'] = 'in-progress';

        // Check the completion of each stage and update the progress and status accordingly
        if (!empty($order['time_approval'])) {
            $order['progress'] = 100;  // Order has been approved
            $order['status'] = 'Ready';
            $order['status_color'] = 'success';
			$order['badge_status'] = 'ready';
        } elseif (!empty($order['time_fully_reviewed'])) {
            $order['progress'] = 66;   // Order has been fully reviewed
            $order['status_color'] = 'warning';
        } elseif (!empty($order['time_ml_processed'])) {
            $order['progress'] = 33;   // Order has been processed by AI
            $order['status_color'] = 'yellow';
        }

        // Return the updated order
        return $order;
    }


	  // Method that is called after data is retrieved
	protected function afterFind_getProgress(array $data): array
	{
		if (empty($data['data'])) {
			return $data;
		}

		if ($data['singleton']) {
			// If it's a single record
			$new_data = $this->updateOrderProgressAndStatus($data['data']);
			$data['data']['progress'] = $new_data['progress'];
			$data['data']['status'] = $new_data['status'];
			$data['data']['status_color'] = $new_data['status_color'];
			$data['data']['badge_status'] = $new_data['badge_status'];
			//   $data['data']->progress = $new_data['progress'];
			//   $data['data']->status = $new_data['status'];
			//   $data['data']->status_color = $new_data['status_color'];
		} else {
			// If it's multiple records
			foreach ($data['data'] as $i => $row) {
				$new_data = $this->updateOrderProgressAndStatus($row);
				$data['data'][$i]['progress'] = $new_data['progress'];
				$data['data'][$i]['status'] = $new_data['status'];
				$data['data'][$i]['status_color'] = $new_data['status_color'];
				$data['data'][$i]['badge_status'] = $new_data['badge_status'];
			}
		}

		return $data;
	}

	

	
}
