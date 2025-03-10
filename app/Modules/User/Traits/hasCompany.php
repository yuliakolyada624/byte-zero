<?php

declare(strict_types=1);

namespace App\Modules\User\Traits;


trait hasCompany
{
    protected $company_name;

    /**
     * @return mixed
     */
    public function setCompany($company_name)
    {
        $this->company_name = $company_name;
        return $this->company_name;
    }
}