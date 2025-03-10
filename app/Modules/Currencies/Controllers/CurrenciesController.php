<?php namespace App\Modules\Currencies\Controllers;

use App\Modules\Currencies\Models\CurrenciesModel;
use CodeIgniter\Controller;
use Config\Services;

class CurrenciesController extends Controller
{
    private $currenciesModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->currenciesModel = new CurrenciesModel();
    }

    public function index()
	{
		$currencies = $this->currenciesModel->orderBy('id', 'ASC')->paginate(10);
        $data = [ 'currencies' => $currencies, 
                  'pager'=>$this->currenciesModel->pager, 
                  'title' => 'Currencies List'
                ];

		return view('Admin/Currencies/list', $data);
	}



    public function edit($id){
        $currency = $this->currenciesModel->find($id);
        
        
        $data = [ 'currency' => $currency, 'title' => 'Edit currency'];
        return view('Admin/Currencies/edit', $data);
    }



    public function update(){
        //helper(['form']);
		$model = new currenciesModel();
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[20]',
            'rate' => 'required',
            ];

        if (! $this->validate($rules)) {
            
            return redirect()->to('/currencies/edit/'.$this->request->getPost('id'))->withInput()->with('errors', $this->validator);
        }else{
             $newData = [
                        'id' => $this->request->getPost('id'),
                        'name' => $this->request->getPost('name'),
                        'rate' => $this->request->getPost('rate'),
                        'is_active' => $this->request->getPost('is_active'),
                        'is_popular' => $this->request->getPost('is_popular'),
                        'code' => $this->request->getPost('code'),
                        
                        /*
                        'symbol' => $this->request->getPost('symbol'),
                        'code' => $this->request->getPost('code'),
                        'source_currency' => $this->request->getPost('source_currency'),
                        'decimals' => $this->request->getPost('decimals'),
                        'symbol_placement' => $this->request->getPost('symbol_placement'),
                        'is_default' => $this->request->getPost('is_default'),
                        */
                        ];

            $model->save($newData);

            session()->setFlashdata('success', 'Successfuly Updated');
            return redirect()->to('/currencies/list');

        }
    }

    public function update_rates()
    {
        $currencies = $this->currenciesModel->orderBy('id', 'DESC')->findAll();
      //  dd($currencies);

		foreach ($currencies as $key => $value) {

			$jsonData[$value->code]['name'] = $value->name; 
			$jsonData[$value->code]['symbol'] = $value->symbol; 
			$jsonData[$value->code]['code'] = $value->code; 
			$jsonData[$value->code]['rate'] = $value->rate; 
			$jsonData[$value->code]['symbol_placement'] = $value->symbol_placement; 

			$sourceCurrency = $value->source_currency;
			$targetCurrency = $value->code;
			$id 			= $value->id;

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.currconv.com/api/v5/convert?q=$sourceCurrency"."_"."$targetCurrency&compact=ultra&apiKey=a13893a3-8591-46e8-abd1-1dcebf70b857",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "Cache-Control: no-cache",
			    "Postman-Token: 06342b21-f68d-e986-4812-acbb841e15f5"
			  ),
			));

			$response = curl_exec($curl);
			curl_close($curl);

			$results = json_decode($response);

			$key = $sourceCurrency."_".$targetCurrency;

            //dd($results);
			if(isset($results->{$key})){
                $currencyData['rate'] = $results->{$key};
            } else {
                $currencyData['rate'] = 0;
            }
            
			

			$ip = gethostbyname($_SERVER['HTTP_HOST']);
			
			if($ip == "34.198.65.99"){
				$subject = "Live Currency Price logs";
			}else{			
				$subject = "Dev Currency Price logs";
			}
			
			if ($currencyData['rate'] == 0) {

				$data['currency'] 	= $sourceCurrency."_".$targetCurrency;
				$data['rate'] 		= $currencyData['rate'];
                // TODO  TEST it!!!
                $email = \Config\Services::email();
                $email->setFrom('scanterkk@gmail.com', 'Alex Dev Test');
                $email->setTo('olexandr@med-test.ai');
                
                $email->setSubject($subject. ' '.$ip);
                $email->setMessage('Update Currency Fail: '.$data['currency'].' Rate = '.$data['rate']);

                $email->send();

		      	$currencyData['rate'] = $value->rate;
			}
			else{
				$jsonData[$value->code]['rate'] = $currencyData['rate'];
			}

			$this->currenciesModel->update($id,$currencyData);
		}


        /*
		if(isset($jsonData)){
			$file = FCPATH.'json/currencies.json';
	    	file_put_contents($file, json_encode($jsonData));
		}*/

        session()->setFlashdata('success', 'Currencies Successfuly Updated!');
        return redirect()->to('/currencies/list');

    }



    /**
     * Set the currency for the user.
     *
     * This function sets the currency for the user by storing it in a cookie.
     * It also stores the previous URL in the session for redirection purposes.
     *
     * @param string $new_currency The new currency to set for the user.
     * @return \CodeIgniter\HTTP\RedirectResponse Returns a redirect response.
     */
    public function set($new_currency)
    {
        $new_currency = esc($new_currency);

        $currenciesModel = new \App\Modules\Currencies\Models\CurrenciesModel();
        $row = $currenciesModel->where('code', $new_currency)->where('is_active', 'yes')->find();
        
        if(sizeof($row)==1 && $row[0]->code == $new_currency ){

            // Load the cookie helper
            helper('cookie');
            
            // Set the currency in a cookie
            set_cookie('currency', $new_currency);
            
        }

        // Store the previous URL in the session for redirection
        session()->set('_ci_previous_url', Services::request()->getServer('HTTP_REFERER', FILTER_SANITIZE_URL));
        
        // Redirect back to the previous URL with updated cookies
        return redirect()->back()->withCookies();
        
    }
    

}
