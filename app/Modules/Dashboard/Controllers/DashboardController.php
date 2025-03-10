<?php 

namespace App\Modules\Dashboard\Controllers;


use App\Controllers\BaseController;
use App\Modules\Orders\Models\OrderExhibitsModel;
use App\Modules\Orders\Models\OrdersModel;
use CodeIgniter\API\ResponseTrait;

class DashboardController extends BaseController
{
    use ResponseTrait;

    private $pager;

    /**
     * Constructor.
     */
    public function __construct()
    {
       
    }



    public function index()
    {
        $model = new OrdersModel();
        $limit = 5;
        # TODO functionality of New Cases
        $new_order = [];

        $query = $this->applyFilters($model);
        $body_injury_orders = $query->where('claim_type', 'bodily_injury')->orderBy('time_created', 'DESC')->findAll($limit);
        $query = $this->applyFilters($model);
        $disability_claim_orders = $query->where('claim_type', 'disability_claim')->orderBy('time_created', 'DESC')->findAll($limit);
        $query = $this->applyFilters($model);
        $medical_malpractice_orders = $query->where('claim_type', 'nursing_home_negligence')->orderBy('time_created', 'DESC')->findAll($limit);
        $query = $this->applyFilters($model);
        $workers_compensation_orders = $query->where('claim_type', 'workers_compensation')->orderBy('time_created', 'DESC')->findAll($limit);

        $widgets_data = $this->getWidgetsData();

        $data = [ 
            'title' => 'Dashboard',
            'bodyClass' => 'dashboard-page minimize_sidenav',

            'widgets_data' => $widgets_data,
            'new_order' => $new_order,

            'bodyInjuryOrders' => $body_injury_orders,
            'disabilityClaimOrders' => $disability_claim_orders,
            'medicalMalpracticeOrders' => $medical_malpractice_orders,
            'workersCompensationOrders' => $workers_compensation_orders,
        ];

        

        return view('Dashboard/dashboard', $data);
    }

    public function widgets()
    {
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        $widgets_data = $this->getWidgetsData($start_date, $end_date);

        $data = [
            "widgets" => view('Dashboard/_widgets', ['widgets_data' => $widgets_data])
        ];

        return $this->response->setJSON($data);
    } 


    
    public function sampleJsonResponse()
    {
        $data['foo'] = 'bar';
        return $this->respond(['success' => true, 'data' => $data], 200);
    }

    private function applyFilters($query, $limit = 5) {
        $query = $query->limit($limit); 

        return $query;
    }
    
    private function getWidgetsData($start_date = '', $end_date = '') {
        $currentDate = new \DateTime();
        if (empty($end_date)) {
            $end_date = $currentDate->format('Y-m-d 00:00:00');
        }
        if (empty($start_date)) {
            $thirty_days_ago = (clone $currentDate)->modify('-30 days');
            $start_date = $thirty_days_ago->format('Y-m-d 00:00:00');
        }

        $data = [];
        $orderModel = new OrdersModel();
        $orderExhibitsModel = new OrderExhibitsModel();

        
        // $data['all_reports'] = $orderModel->where('user_id', $userId)->countAllResults();
        $data['reports_requested'] = $orderModel->where('time_created >=', $start_date)
                                                ->where('time_created <=', $end_date)
                                                ->countAllResults();

        $data['exhibits_uploaded'] = $orderExhibitsModel->where('created_at >=', $start_date)
                                                        ->where('created_at <=', $end_date)
                                                        ->countAllResults();

        $data['pages_uploaded'] = $orderExhibitsModel->selectSum('page_count')
                                                    ->where('created_at >=', $start_date)
                                                    ->where('created_at <=', $end_date)
                                                    ->get()
                                                    ->getRow()
                                                    ->page_count;

        $data['reports_generated'] = $this->countOrdersWithReports($start_date, $end_date);

        $data['avg_report_generation_time'] = $this->getAverageTimeDifference($start_date, $end_date);

        return $data;
    }

    private function getAverageTimeDifference($start_date, $end_date)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('orders');
        $builder->select("SEC_TO_TIME(AVG(TIMESTAMPDIFF(SECOND, time_created, time_paid))) AS average_time");
        $builder->where('time_created >=', $start_date);
        $builder->where('time_created <=', $end_date);
        $builder->where('time_created IS NOT NULL');
        $builder->where('time_paid IS NOT NULL');

        $query = $builder->get();
        $result = $query->getRow();

        if ($result && isset($result->average_time)) {
            $timeParts = explode(':', $result->average_time);
            $hours = $timeParts[0];
            $minutes = $timeParts[1];

            return [
                'hours' => $hours,
                'minutes' => $minutes
            ];
        }

        return [
            'hours' => 0,
            'minutes' => 0
        ];
    }

    private function countOrdersWithReports($start_date, $end_date): int
    {
        $db = \Config\Database::connect();

        $builder = $db->table('orders');
        $builder->select('orders.id')
        ->join('order_reports_assignees', 'order_reports_assignees.order_id = orders.id', 'inner')
        ->join('order_reports', 'order_reports.report_id = order_reports_assignees.report_id', 'inner')
        ->where('time_created >=', $start_date)
        ->where('time_created <=', $end_date)
        ->distinct();

        return $builder->countAllResults();
    }
}