<?php 

namespace App\Modules\Transactions\Models;

use App\Modules\Transactions\Models\TransactionsModel;
use CodeIgniter\Model;


class TransactionModel extends Model
{   
    protected $returnType = Transaction::class;

    protected function initialize(): void
    {
        parent::initialize();

        // Merge properties with parent
        $this->allowedFields = array_merge($this->allowedFields, [
            'transaction_number',
            'user_id',
            'order_id',
            'checkout_session_id',
            'gateway_name',
            'authorization_amount',
            'authorization_currency',
            'card_ends_in',
            'card_type',
            'authorization_transaction_token',
            'capture_transaction_token',
            'capture_gateway_transaction_id', 
            'log', 
            'payment_card_data',
            'is_refund',
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
    }

    public function getTransactions($page = 1, $perPage = 10)
    {
        $offset = ($page-1)*$perPage;

        $transactions = $this->db->table('payments_transactions')
                            ->select('payments_transactions.*, orders.order_number, orders.case_name, orders.claim_type as claim_type_text, orders.report_type as report_type_text')
                            ->join('orders', 'payments_transactions.order_id = orders.id', 'left')->limit($perPage,$offset)->get()->getResultArray();

        
        return $transactions;
    }

    public function transactionsPages($perPage = 10)
    {

        $transactions = $this->db->table('payments_transactions')->get()->getResult();
        $result['pages'] = 1;
        if(is_countable($transactions)){
            $result['pages'] = count($transactions)/$perPage ;
        }
        $result['transactions'] = count($transactions) ?? 0;
        return $result;
    }
}