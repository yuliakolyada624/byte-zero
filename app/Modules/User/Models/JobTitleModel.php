<?php
namespace App\Modules\User\Models;

use CodeIgniter\Model;

class JobTitleModel extends Model
{
    protected $table = 'job_titles';
    protected $primaryKey = 'id';
    protected $allowedFields = [
            'company_id',
            'job_title'
        ];

    /**
     * Get all job titles (global + company-specific).
     *
     * @param int|null $companyId The company ID (optional).
     * @return array
     */
    public function getJobTitles($companyId = null)
    {
        // Select job titles and calculate the count of assigned users
        $builder = $this->select('job_titles.*, COUNT(users.id) as assigned_users')
        ->join('users', 'users.job_title = job_titles.job_title', 'left') // Left join users table to count the assigned users
        ->groupStart()
            ->where('job_titles.company_id', 0) // Global job titles
            ->orWhere('job_titles.company_id', $companyId) // Company-specific job titles if companyId is provided
        ->groupEnd()
        ->groupBy('job_titles.id'); // Group by job title ID to aggregate user count


        // Get the results
        $jobTitles = $builder->findAll();

        // Mark the job titles that can't be deleted
        foreach ($jobTitles as &$jobTitle) {
            if ($jobTitle['company_id'] == 0) {
                // Global job titles are always locked
                $jobTitle['locked'] = 1;
            } else {
                // For company-specific job titles, lock if there are users assigned
                $jobTitle['locked'] = ($jobTitle['assigned_users'] > 0) ? 1 : 0;
            }
        }

        return $jobTitles;
    }

    /**
     * Add a new job title for a specific company.
     *
     * @param string $job_title Job title name.
     * @param int|null $companyId Company ID.
     * @return bool
     */
    public function addJobTitle($job_title, $companyId = 0)
    {
        return $this->insert([
            'job_title' => $job_title,            
            'company_id' => $companyId,
        ]);
    }

    /**
     * Delete a job title (only if it is not locked and belongs to the company).
     *
     * @param int $jobTitleId Job title ID.
     * @param int $companyId Company ID.
     * @return bool
     */
    public function deleteJobTitle($jobTitleId, $companyId)
    {
        $builder = $this->where('id', $jobTitleId)->whereNotIn('company_id', [0]); // Ensure it's not locked
        
        $builder->where('company_id', $companyId);
        
        return $builder->delete();
    }

    /**
     * Update a job title for a specific company.
     *
     * @param int $jobTitleId Job title ID.
     * @param string $newName New job title name.
     * @param int|null $companyId Company ID.
     * @return bool
     */
    public function updateJobTitle($jobTitleId, $newName, $companyId = null)
    {
        $builder = $this->where('id', $jobTitleId);
        
        if ($companyId !== null) {
            // Only update the job title if it belongs to the company or is company-specific
            $builder->where('company_id', $companyId);
        }

        return $builder->set('job_title', $newName)->update();
    }
}
