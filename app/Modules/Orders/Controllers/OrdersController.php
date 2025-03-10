<?php
namespace App\Modules\Orders\Controllers;

use App\Libraries\Filters;
use App\Modules\Orders\Models\OrderExhibitsModel;
use App\Modules\Orders\Models\OrdersModel;
use App\Modules\Orders\Models\ReviewersModel;
use App\Controllers\BaseController;
use App\Modules\User\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Exceptions\PageNotFoundException;
use Aws\S3\Exception\S3Exception;

class OrdersController extends BaseController
{
    use ResponseTrait;

    private $ordersModel;
    private $currentUserData = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->ordersModel = new OrdersModel();

        $user = auth()->user();
        if ($user) {
            $this->currentUserData = $user;
        }
    }

    // shows user's Cases ( orders ) 
    public function cases()
    {
        $model = new OrdersModel();

        // Number of records per page
        $perPage = 10;

        $query = $this->applyFilters($model);

        // Get the current page for each claim type from the request, default to 1
        $currentPageBodyInjury = $this->request->getVar('page_bodyInjury') ?? 1;
        $currentPageDisabilityClaim = $this->request->getVar('page_disabilityClaim') ?? 1;
        $currentPageMedicalMalpractice = $this->request->getVar('page_medicalMalpractice') ?? 1;
        $currentPageWorkersCompensation = $this->request->getVar('page_workersCompensation') ?? 1;

        // Initialize query
        $query = $this->applyFilters($model);

        // Fetch paginated data for each claim type
        $bodyInjuryOrders = $query->withPaymentTransaction()->where('claim_type', 'bodily_injury')->paginate($perPage, 'bodyInjury', $currentPageBodyInjury);
        //var_dump($query->getLastQuery());
        $query = $this->applyFilters($model);
        $disabilityClaimOrders = $query->withPaymentTransaction()->where('claim_type', 'disability_claim')->paginate($perPage, 'disabilityClaim', $currentPageDisabilityClaim);
        $query = $this->applyFilters($model);
        $medicalMalpracticeOrders = $query->withPaymentTransaction()->where('claim_type', 'nursing_home_negligence')->paginate($perPage, 'medicalMalpractice', $currentPageMedicalMalpractice);
        $query = $this->applyFilters($model);
        $workersCompensationOrders = $query->withPaymentTransaction()->where('claim_type', 'workers_compensation')->paginate($perPage, 'workersCompensation', $currentPageWorkersCompensation);

        // Generate pagination links for each tab
        //$pager = \Config\Services::front_pager();
        $pager = \Config\Services::pager();

        $filter_data = $this->getFilterData();

        //dd($pager);

        // Pass data to the view
        return view('Cases/cases', [
            'bodyInjuryOrders' => $bodyInjuryOrders,
            'disabilityClaimOrders' => $disabilityClaimOrders,
            'medicalMalpracticeOrders' => $medicalMalpracticeOrders,
            'workersCompensationOrders' => $workersCompensationOrders,
            'filter_data' => $filter_data,
            'pager' => $pager,
            'tabName' =>  !empty($filter_data['current_tab']) ? $filter_data['current_tab'] : 'bodyInjury',
        ]);

    }


    public function getPlaintiffDefendantNames()
    {
        $query = $this->request->getVar('search');

        if (!$query) {
            return $this->fail('Search query is required', 400);
        }

        $currentUser = auth()->user();
        $companyId = $currentUser->company_id;

        if (!$companyId) {
            return $this->fail('Company ID is required', 400);
        }

        $model = new OrdersModel();
        $results = $model->searchPlaintiffDefendantNames($query, $companyId);

        $names = [];
        foreach ($results as $row) {
            if (!empty($row['plaintiff_first_name']) && !empty($row['plaintiff_last_name'])) {
                $names[] = $row['plaintiff_first_name'] . ' ' . $row['plaintiff_last_name'];
            }
            if (!empty($row['defendant_first_name']) && !empty($row['defendant_last_name'])) {
                $names[] = $row['defendant_first_name'] . ' ' . $row['defendant_last_name'];
            }
        }

        $names = array_unique($names);

        return $this->respond($names);
    }



    public function casesFilter()
    {
        $model = new OrdersModel();

        // Number of records per page
        $perPage = 10;

        $tabName = $this->request->getVar('tabName') ?? 'bodyInjury';

        // Get the current page for each claim type from the request, default to 1
        $currentPageBodyInjury = $this->request->getVar('page_bodyInjury') ?? 1;
        $currentPageDisabilityClaim = $this->request->getVar('page_disabilityClaim') ?? 1;
        $currentPageMedicalMalpractice = $this->request->getVar('page_medicalMalpractice') ?? 1;
        $currentPageWorkersCompensation = $this->request->getVar('page_workersCompensation') ?? 1;

        // Initialize query
        $query = $this->applyFilters($model);

        // Fetch paginated data for each claim type
        $bodyInjuryOrders = $query->withPaymentTransaction()->where('claim_type', 'bodily_injury')->paginate($perPage, 'bodyInjury', $currentPageBodyInjury);

        //var_dump($query->getLastQuery());
        $query = $this->applyFilters($model);
        $disabilityClaimOrders = $query->withPaymentTransaction()->where('claim_type', 'disability_claim')->paginate($perPage, 'disabilityClaim', $currentPageDisabilityClaim);
        $query = $this->applyFilters($model);
        $medicalMalpracticeOrders = $query->withPaymentTransaction()->where('claim_type', 'nursing_home_negligence')->paginate($perPage, 'medicalMalpractice', $currentPageMedicalMalpractice);
        $query = $this->applyFilters($model);
        $workersCompensationOrders = $query->withPaymentTransaction()->where('claim_type', 'workers_compensation')->paginate($perPage, 'workersCompensation', $currentPageWorkersCompensation);


        $filter_data = $this->getFilterData(true);

        // Generate pagination links for each tab
        $pager = \Config\Services::pager();

        $TabContent = view('Cases/cases_tabs', [
            'bodyInjuryOrders' => $bodyInjuryOrders,
            'disabilityClaimOrders' => $disabilityClaimOrders,
            'medicalMalpracticeOrders' => $medicalMalpracticeOrders,
            'workersCompensationOrders' => $workersCompensationOrders,
            'tabName' => $tabName,
            'pager' => $pager,
        ]);

        $SectionOffcanvas = view('Cases/section_offcanvas', [
            'bodyInjuryOrders' => $bodyInjuryOrders,
            'disabilityClaimOrders' => $disabilityClaimOrders,
            'medicalMalpracticeOrders' => $medicalMalpracticeOrders,
            'workersCompensationOrders' => $workersCompensationOrders,
            'tabName' => $tabName,
        ]);

        $FilterContent = view('Cases/filters', [
            'filter_data' => $filter_data
        ]);

        // Pass data to the view
        $data = [
            'TabContent' => $TabContent,
            'SectionOffcanvas' => $SectionOffcanvas,
            'FilterContent' => $FilterContent
        ];

        return $this->response->setJSON($data);
    }

    private function applyFilters($query)
    {

        // Get filter parameters from the request
        $progress_status = $this->request->getVar('progress_status');
        $ordered_by = $this->request->getVar('ordered_by');
        $report_type = $this->request->getVar('report_type');
        $assignee = $this->request->getVar('assignee');
        $only_my = $this->request->getVar('only_my') && ($this->request->getVar('only_my') != "false");
        $order_id = $this->request->getVar('order_id');
        $search_by_pdnames = $this->request->getVar('search_by_pdnames');
        $start_date = $this->request->getVar('start_date');
        $end_date = $this->request->getVar('end_date');


        // Apply filters if set
        // TODO
        if ($progress_status) {
            switch ($progress_status) {
                case 'received':
                    // Check if none of the relevant fields are set
                    $query = $query->where('time_approval IS NULL')
                        ->where('time_fully_reviewed IS NULL')
                        ->where('time_ml_processed IS NULL');
                    break;

                case 'ready':
                    // Check if 'time_approval' is set (indicating the order is ready)
                    $query = $query->where('time_approval IS NOT NULL');

                    break;

                case 'reviewed':
                    // Check if 'time_fully_reviewed' is set (indicating full review)
                    $query = $query->where('time_approval IS NULL')
                        ->where('time_fully_reviewed IS NOT NULL')
                        ->where('time_ml_processed IS NOT NULL');
                    break;

                case 'ml_processed':
                    // Check if 'time_ml_processed' is set (indicating processing by AI)
                    $query = $query->where('time_approval IS NULL')
                        ->where('time_ml_processed IS NOT NULL')
                        ->where('time_fully_reviewed IS NULL');
                    break;

                default:
                    // Handle any other cases or ignore
                    break;
            }
        }
        if ($ordered_by && !$only_my) {
            $query = $query->where('creater_user_id', (int)$ordered_by);
        }

        if ($report_type) {
            switch ($report_type) {
                case 'medical_chronology':
                    $query = $query->where('report_type', 'medical_chronology');
                    break;

                case 'billing_summary':
                    $query = $query->where('report_type', 'billing_summary');
                    break;

                case 'both':
                    $query = $query->where('report_type', 'medical_chronology_and_billing_summary');
                    break;

                default:
                    break;
            }
        }
        if ($assignee) {
            $query = $query->join('order_reports_assignees', 'order_reports_assignees.order_id = orders.id')
                ->where('order_reports_assignees', (int)$assignee);
        }
        if ($only_my && $only_my == "true") {
            $currentUser = auth()->user();
            $query = $query->where('creater_user_id', (int)$currentUser->id);
        }
        if ($order_id) {
            $query = $query->like('order_number', $order_id);
        }
        if ($search_by_pdnames) {
            $query = $query
                        ->like('plaintiff_first_name', $search_by_pdnames)
                        ->orLike('plaintiff_last_name', $search_by_pdnames)
                        ->orLike('defendant_first_name', $search_by_pdnames)
                        ->orLike('defendant_last_name', $search_by_pdnames);
        }
        if ($start_date && $end_date) {
            $query = $query->where('time_created >=', $start_date)->where('time_created <=', $end_date);
        }

        return $query;

    }

    private function getFilterData($checkFilter = false)
    {
        $filter_data['has_filter'] = false;
        $progress_status = $this->request->getVar('progress_status');
        $ordered_by = $this->request->getVar('ordered_by');
        $report_type = $this->request->getVar('report_type');
        $assignee = $this->request->getVar('assignee');
        $filter_data['current_tab'] = $this->request->getVar('current_tab');
        
        if (!empty($progress_status) || !empty($ordered_by) || !empty($report_type) || !empty($assignee)) {
            $filter_data['has_filter'] = true;
        } 

        if ($checkFilter) {
            $orderModel = new OrdersModel();
            // Initialize query builder and compile subquery
            $queryBuilder = $orderModel->builder();
            $sub_query = $this->applyFilters($queryBuilder)->select('id')->getCompiledSelect();

            $userModel = new UserModel();

            $filter_data['assignee_list'] = $userModel->select('users.id, users.first_name, users.last_name')
                ->join('order_reports_assignees', 'order_reports_assignees.user_id = users.id')
                ->join('orders', 'order_reports_assignees.order_id = orders.id', 'inner')
                ->where("order_reports_assignees.order_id IN ($sub_query)", null, false)
                ->groupBy('users.id')
                ->get()
                ->getResult();

            $filter_data['ordered_by_list'] = $userModel->select('users.id, users.first_name, users.last_name')
                ->join('orders', 'orders.creater_user_id = users.id')
                ->where("orders.id IN ($sub_query)", null, false)
                ->groupBy('users.id')
                ->get()
                ->getResult();

        } else {
            $userModel = new UserModel();

            $filter_data['assignee_list'] = $userModel->select('users.id, users.first_name, users.last_name')
                ->join('order_reports_assignees', 'order_reports_assignees.user_id = users.id')
                ->join('orders', 'order_reports_assignees.order_id = orders.id', 'inner')
                ->groupBy('users.id')
                ->get()
                ->getResult();

            $filter_data['ordered_by_list'] = $userModel->select('users.id, users.first_name, users.last_name')
                ->join('orders', 'orders.creater_user_id = users.id', 'inner')
                ->groupBy('users.id')
                ->get()
                ->getResult();
        }
        if ($progress_status) {
            $filter_data['progress_status'] = $progress_status;
        }
        if ($ordered_by) {
            $filter_data['ordered_by'] = (int)$ordered_by;
        }
        if ($report_type) {
            $filter_data['report_type'] = $report_type;
        }
        if ($assignee) {
            $filter_data['assignee'] = (int)$assignee;
        }

        return $filter_data;
    } 



    public function medicalChronologyRequest()
    {
        $report_type = $this->request->getVar('reportType') ?? 'medical_chronology'; 
        $order_number = $this->generateUniqueOrderId();
        
        return view('Cases/medical-chronology-request', [
            'order_number' => $order_number,
            'report_type' => $report_type,
        ]);
    }


    private function generateUniqueOrderId()
    {
        $model = new OrdersModel();
    
        do {
            $orderId = 'ORD' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5));
        } while ($model->where('order_number', $orderId)->countAllResults() > 0); 
    
        return $orderId;
    }


    public function uploadExhibits()
    {
        // Retrieve or generate the order number
        $orderNumber = $this->request->getVar('order_number');

        // if first load - generate new id
        if (empty($orderNumber)) {
            $orderNumber = $this->generateUniqueOrderId();
        }
        $report_type = $this->request->getVar('report_type');

        // Define the upload path for this order number
        $uploadPath = WRITEPATH . 'uploads/exhibits/' . $orderNumber;

        // Create the directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Initialize total pages
        $totalPages = 0;
        $totalExhibit = 0;

        $exist_order = $this->ordersModel->where('order_number', $orderNumber)->countAllResults();
        $user = auth()->user();

        //var_dump($user->id); die;

        //report_type
        if(!$exist_order){
            $order = $this->ordersModel->insert([
                                                        'creater_user_id' => $user->id,
                                                        'order_number'=> $orderNumber, 
                                                        'report_type'=> $report_type
                                                    ]);
        }

        $order = $this->ordersModel->where('order_number', $orderNumber)->first();

        //var_dump($order); die;

        $orderExhibitsModel = new OrderExhibitsModel();

        $aws = service('aws')->createClient('S3',['version' => 'latest']);
        //$aws->upload($bucketName, $uploadFileName, $file);


        // Check if files are included in the request
        if ($this->request->getFiles()) {
            $files = $this->request->getFiles();

            foreach ($files['files'] as $file) {
                // Validate each file type and size
                if (!$file->isValid() || $file->getMimeType() !== 'application/pdf' || $file->getSize() > 50 * 1024 * 1024) {
                    return $this->fail("Invalid file format or size exceeded (maximum 50 MB per file).", 400);
                }

                $originalFileName = $file->getClientName();

                // Generate a unique file name within the order directory
                $newFileName = uniqid('', true);

                // Move the file to the order's directory
                if (!$file->move($uploadPath, $newFileName.'.'.$file->getClientExtension())) {
                    return $this->fail("Failed to upload file.", 500);
                }

                // Calculate cost for this file and add to total
                $filePath = $uploadPath . '/' . $newFileName.'.'.$file->getClientExtension();
                try {
                    $filePages = $this->calculatePages($filePath);
                } catch (\setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException $e) {
                    // Handle specific FPDI parser error and fall back to alternative calculation
                    $filePages = $this->calculatePagesReserve($filePath);
                } catch (Exception $e) {
                    // Handle general exceptions
                    // TODO - install pdfinfo 
                    $filePages = $this->calculatePagesReserve($filePath);
                }

                try {
                    $aws->putObject([
                        'Bucket' => env('aws.bucket'),
                        'Key'    => $newFileName,
                        'Body'   => fopen($filePath, 'r'),
                        'ACL'    => 'private',
                    ]);
                } catch (S3Exception $e) {
                    //var_dump($e->getMessage());
                    //die;
                    return $this->fail("Failed to upload file. " . $e->getMessage(), 500);
                }

                // delete the local file
                unlink(filename: $filePath);
                
                $totalPages += $filePages;
                $totalExhibit++;

                // Insert file metadata into the order_exhibits table
                $orderExhibitsModel->insert([
                    'order_id' => $order['id'],
                    'origin' => $originalFileName,
                    'hash' => $newFileName,
                    'page_count' => $filePages,
                ]);
            }

            $order_total_pages = $totalPages +$order['page_count'];
            $total_cost = $this->calculateCost($order_total_pages);

            $this->ordersModel->update($order['id'], 
                                    [
                                        'exhibit_count' => $totalExhibit +$order['exhibit_count'],
                                        'page_count' => $order_total_pages,
                                        'billed_amount'=> $total_cost,
                                        'billed_currency'=> 'USD',
                                    ]
                                    );


            return $this->respond(['status' => 'success', 
                                        'order_number' => $orderNumber,
                                        'exhibit_count' => $totalExhibit +$order['exhibit_count'],
                                        'total_pages' => $order_total_pages,
                                        'fileHash' => $newFileName,
                                        'total_cost' => '$'.number_format($total_cost, 2),
                                    ], 201);
        }

        return $this->fail("No files uploaded.", 400);
    }


    private function calculatePages($filePath)
    {
        $pageCount = 0;

        // Initialize FPDI to count pages in the PDF
        $pdf = new \setasign\Fpdi\Fpdi();
        $pdf->setSourceFile($filePath);
        $pageCount = $pdf->setSourceFile($filePath);
    
        return $pageCount;
    }


    private function calculatePagesReserve($filePath)
    {
        $command = escapeshellcmd("pdfinfo " . escapeshellarg($filePath));
        $output = shell_exec($command);
    
        if ($output && preg_match('/Pages:\s+(\d+)/', $output, $matches)) {
            return (int)$matches[1];
        }
        return null;
    }

    // TODO
    private function calculateCost($pages){
        $cost = 10;
        return $pages*$cost;
    }

    public function deleteExhibit()
    {
        // Ensure the request is an AJAX request and that the user is authenticated
        if (!$this->request->isAJAX()) {
            return $this->failForbidden("Invalid request.");
        }

        // Get file ID from the request
        $fileId = $this->request->getJSON()->file_id;
        if (!$fileId) {
            return $this->fail("File ID is required.", 400);
        }

        // Load the model and find the file record
        $exhibitsModel = new OrderExhibitsModel();
        $fileRecord = $exhibitsModel->where(['hash'=>$fileId])->first();

        //var_dump($fileRecord); die;

        if (!$fileRecord) {
            return $this->failNotFound("File not found.");
        }

        $aws = service('aws')->createClient('S3',['version' => 'latest']);

        // Check if the authenticated user has permission to delete
        $order = $this->ordersModel->find($fileRecord->order_id);
        $userId = auth()->user()->id; // Assuming a user authentication service
        if (!$order || (int)$order['creater_user_id'] !== (int)$userId) {
            return $this->failForbidden("You do not have permission to delete this file.");
        }

        try {
            $aws->deleteObject(['Bucket' => env('aws.bucket'), 'Key' => $fileRecord->hash]);
        } catch (S3Exception $e) {            
            return $this->fail("Failed to delete $fileRecord->origin with error: {$e->getMessage()}", 500);
        }

        // Attempt to delete the physical file
        /*$filePath = WRITEPATH . 'uploads/exhibits/' . $fileRecord->origin;
        if (file_exists($filePath) && !unlink($filePath)) {
            return $this->fail("Failed to delete the file.", 500);
        }*/

        // Delete the database record
        if (!$exhibitsModel->delete($fileRecord->id)) {
            return $this->fail("Failed to delete the database record.", 500);
        }

        // Respond with success
        //return $this->respondDeleted(['success' => true, 'message' => 'File deleted successfully.']);

        // Calculate total pages and exhibits after deletion
        $remainingExhibits = $exhibitsModel->where('order_id', $fileRecord->order_id)->findAll();
        $totalPages = 0;
        $totalExhibit = count($remainingExhibits);

        foreach ($remainingExhibits as $exhibit) {
            $totalPages += $exhibit->page_count;
        }

        // Calculate total cost based on total pages
        $total_cost = $this->calculateCost($totalPages);

        // Update the order with new exhibit and page counts
        $this->ordersModel->update($fileRecord->order_id, [
            'exhibit_count' => $totalExhibit,
            'page_count' => $totalPages,
            'billed_amount'=> $total_cost,
            'billed_currency'=> 'USD',
        ]);

        return $this->respond([ 'status' => 'success', 
                                    'success' => true, 
                                    'message' => 'File deleted successfully.',
                                    'order_number' => $order['order_number'],
                                    'exhibit_count' => $totalExhibit,
                                    'total_pages' => $totalPages,
                                    'total_cost' => $total_cost,
                                ], 201);
    }


    public function saveMedicalChronologyRequest()
    {
         // Check if the request is a POST request
        if (!$this->request->isAJAX()) {
            return $this->failForbidden("Invalid request.");
        }

        // Collect the input data from the request
        $data = [
            //'creater_user_id' => auth()->user()->id, 
            'order_number' => $this->request->getVar('medical_chronology_request_order_number'),
            'claim_type' => $this->request->getVar('medical_chronology_request_claim_type'),
            'claim_number' => $this->request->getVar('medical_chronology_request_claim_number'),
            'case_name' => $this->request->getVar('medical_chronology_request_case_name'),
            'plaintiff_first_name' => $this->request->getVar('medical_chronology_request_plaintiff_first_name'),
            'plaintiff_last_name' => $this->request->getVar('medical_chronology_request_plaintiff_last_name'),
            'plaintiff_dob' => $this->request->getVar('medical_chronology_request_plaintiff_date_of_birth'),
            'plaintiff_gender' => $this->request->getVar('medical_chronology_request_plaintiff_gender'),
            'defendant_first_name' => $this->request->getVar('defendant_first_name'),
            'defendant_last_name' => $this->request->getVar('defendant_last_name'),
            'defendant_company_name' => $this->request->getVar('defendant_company_name'),
            'date_of_incident' => $this->request->getVar('medical_chronology_request_plaintiff_date_of_incident'),
            'location_of_accident' => $this->request->getVar('medical_chronology_request_plaintiff_location_of_accident'),
            'injury_areas' => implode(',', $this->request->getVar('injury_areas') ?? []), // assuming injury areas are in an array
            
        ];

        // Validate required fields
        $validationRules = [
            'claim_type' => 'required',
            'claim_number' => 'required',
            'plaintiff_first_name' => 'required',
            'plaintiff_last_name' => 'required',
            'plaintiff_dob' => 'required|valid_date',
            'plaintiff_gender' => 'required|in_list[male,female]',
            'date_of_incident' => 'required|valid_date',
            'location_of_accident' => 'required',
        ];

        if (!$this->validateData($data, $validationRules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        $order = $this->ordersModel->where('order_number', $data['order_number'])->first();
        if (!$this->ordersModel->update($order['id'], $data)) {
            return $this->fail("Failed to save the order.", 500);
        }

        // get updated data
        $order = $this->ordersModel->find($order['id']);
        $review_html = view('Cases/medical-chronology-review', ['order' => $order]);

        // Respond with success and order ID
        return $this->respondCreated([
            'status' => 'success',
            'message' => 'Order created successfully.',
            'order_id' => $order['id'],
            'review_html' => $review_html
        ]);
    }


    public function reviewMedicalChronologyOrder($orderId)
    {
        $this->ordersModel = new OrdersModel();
        
        $order = $this->ordersModel->find($orderId);

        // Check if the order exists
        if (!$order) {
            throw PageNotFoundException::forPageNotFound('Error 404');
        }

        $userId = auth()->user()->id; // Assuming a user authentication service
        if ((int)$order['creater_user_id'] !== (int)$userId) {
            return $this->failNotFound("You do not have permission to delete this file.");
        }


        return view('Cases/medical-chronology-review', [
            'order' => $order,
        ]);
    }


}