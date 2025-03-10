<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JobTitleSeeder extends Seeder
{
    public function run()
    {
        // Array of standard job titles (global, i.e., company_id = 0)
        $data = [
            ['job_title' => 'Associate Attorney', 'company_id' => 0],
            ['job_title' => 'Attorney', 'company_id' => 0],
            ['job_title' => 'Managing Partner', 'company_id' => 0],
            ['job_title' => 'Of Counsel', 'company_id' => 0],
            ['job_title' => 'Paralegal', 'company_id' => 0],
            ['job_title' => 'Partner', 'company_id' => 0],
            ['job_title' => 'Senior Associate Attorney', 'company_id' => 0],
            ['job_title' => 'Senior Partner', 'company_id' => 0],
        ];

        // Insert the job titles into the job_titles table
        foreach ($data as $jobTitle) {
            $this->db->table('job_titles')->insert($jobTitle);
        }
    }
}
