<?php namespace App\Modules\Currencies\Models;

use CodeIgniter\Model;

class CurrenciesModel extends Model
{
    protected $table  = 'currencies';
    protected $allowedFields  = [
        'name',
        'symbol',
        'code',
        'rate',
        'is_active',
        'is_popular',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;

    protected $returnType     = CurrenciesModel::class;

    public function getCurrenciesList()
    {
        
    }
	
	public function GetCurrencyRatesByCurrencyCodes($currencyCodes)
	{
		$currency_rows = $this->asObject()->whereIn('code', $currencyCodes)->findAll();
		//echo $this->db->getLastQuery(); die;
		$CurrencyRatesArray = array();
		foreach($currency_rows as $currency_row)
		{
			$CurrencyRatesArray[$currency_row->code] = $currency_row->rate;
		}
		return $CurrencyRatesArray;
	}
	
	public function GetCurrencyRowByCurrencyCode($currencyCode)
	{
		$currency_row = $this->asObject()->where('code', $currencyCode)->where('is_active', 'yes')->first();
		//echo $this->db->getLastQuery(); die;
		return $currency_row;
	}
	
	public function GetCurrencyRowByCurrencyId($currencyId)
	{
		$currency_row = $this->where('is_active', 'yes')->find($currencyId);
		//echo $this->db->getLastQuery(); die;
		return $currency_row;
	}
}