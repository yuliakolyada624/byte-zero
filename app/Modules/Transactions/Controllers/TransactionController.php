<?php

namespace App\Modules\Transactions\Controllers;

use App\Modules\Transactions\Controllers\RegisterController;
use App\Modules\Transactions\Models\TransactionModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\MailSender;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\FileCollection;
use CodeIgniter\Files\File;
use CodeIgniter\Shield\Authentication\Actions\EmailActivator;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserIdentityModel;
use App\Modules\Offices\Models\OfficesModel;

class TransactionController extends RegisterController
{   

    private $TransactionModel;
    private $pager;

    // /**
    //  * Constructor.
    //  */
    public function __construct()
    {
        $this->TransactionModel = new TransactionModel();
    }
    public function list() {

        $perPage = 10;
         
        $pager = \Config\Services::pager();
        $page = $this->request->getVar('page') ?? 1;
        $pages = $this->TransactionModel->transactionsPages($perPage);
        $pagination = $this->pagination($page,$pages);
        
        $transactions =  $this->TransactionModel->getTransactions($page, $perPage);
        
        return view(
            'Transactions/list',
            [
                'transactions' => $transactions,
                'pager' => $pager,
                'pagination' => $pagination,
            ]
        );
    }

    public function filter() {
        
        $perPage = 10;
        $pager = \Config\Services::pager();
        $page = $this->request->getPost('page');
        $pages = $this->TransactionModel->transactionsPages($perPage);

        $pagination = $this->pagination($page,$pages);
        $transactions =  $this->TransactionModel->getTransactions($page, $perPage);

        $Content = view('Transactions/list_table', [
            'transactions' => $transactions,
            'pager' => $pager,
            'pagination' => $pagination
            ]);

        $result['content'] = $Content;
        return $this->response->setJSON($result);    
    }

    public function pagination($page = 1, $pages = 1)
    {   
        $pagination = '<ul class="pagination">';

        $prev_page_get = '?page='.$page-1;
        $next_page_get = '?page='.$page+1;
        $prev_page = $page-1;
        $next_page = $page+1;

        if($page > 1){
            $previous_class = '';
        }else{
            $previous_class = 'disabled';
        }

        if($page < intval($pages['pages'])){
            $next_class = '';
        }else{
            $next_class = 'disabled';
        }
      
        $pagination .= '<li class="page-item '.$previous_class.'">
                        <a href="/'.uri_string().$prev_page_get.'" class="page-link" data-page="'.$prev_page.'">       
                          <svg class="icon icon-arrow-pagination prev">
                            <use href="./icon/icons/icons.svg#arrow-pagination"></use>
                          </svg>
                                <span class="text">Previous</span>
                            </a>
                        </li>';
        
        $i=1;
        while($pages['pages'] >= $i){

            $active = '';
            if($page == $i){
                $active = 'active';
            }

            $pagination .= '<li class="page-item page" aria-current="page">
                    <a class="page-link '.$active.'" href="/'.uri_string().'?page='.$i.'" data-page="'.$i.'">'.$i.'</a>
                </li>';

            $i++;
        }                 
                            
        $pagination .= '<li class="page-item" '.$next_class.'>
                    <a class="page-link" href="/'.uri_string().$next_page_get.'" data-page="'.$next_page.'">
                        <span class="text">Next</span>
                        
                      <svg class="icon icon-arrow-pagination next">
                        <use href="./icon/icons/icons.svg#arrow-pagination"></use>
                      </svg>

                    </a>
                </li>
            </ul>
            <div class="pagination-info">
                Showing <span class="active-items">'.$page.' - '.$pages['pages'].'</span> of '.$pages['transactions'].'
            </div>
        ';

        return $pagination;
    }
}