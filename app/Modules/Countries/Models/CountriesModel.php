<?php namespace App\Modules\Countries\Models;

use CodeIgniter\Model;

class CountriesModel extends Model
{
    protected $table  = 'countries';
    protected $allowedFields  = [
        'active',
        'alpha2',
        'alpha3',
        'preferred',
        'name_english',
        'name_french',
        'name_german',
        'name_italian',
        'name_portuguese',
        'name_russian',
        'name_spanish',
        'name_romanian',
        'name_hungarian',
        'name_chinese',
        'name_arabic',
        'region_code',
        'region_name',
        'sub_region_code',
        'sub_region_name',
        'intermediate_region_name',
        'continent',
        'is_eu'
    ];
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

    protected $returnType     = CountriesModel::class;

    public function getNameByAlpha2(string $alpha2): ?string
    {
        return $this->where('alpha2', $alpha2)->select('name_english')->first()->name_english ?? null;
    }
}