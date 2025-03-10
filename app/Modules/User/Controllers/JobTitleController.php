<?php 
namespace App\Modules\User\Controllers;

use App\Modules\User\Models\JobTitleModel;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class JobTitleController extends BaseController
{
    use ResponseTrait;

    protected $jobTitleModel;

    public function __construct()
    {
        $this->jobTitleModel = new JobTitleModel();
    }

    /**
     * Display the job titles for a specific company.
     *
     * @param int|null $companyId
     * @return \CodeIgniter\HTTP\Response
     */
    public function list($companyId = null)
    {
        // Fetch both global and company-specific job titles
        $jobTitles = $this->jobTitleModel->getJobTitles($companyId);

        // Return job titles as JSON response
        return $this->respond(['jobTitles' => $jobTitles]);
    }

    /**
     * Add a new job title (either global or company-specific).
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function add()
    {
        $job_title = $this->request->getPost('job_title');
        $currentUser = auth()->user();
        
    
        // Check if the required fields are present
        if (!$job_title) {
            return $this->failValidationErrors('Job title name is required.');
        }
    
        // Insert the new job title and get the ID of the inserted row
        $jobTitleId = $this->jobTitleModel->insert([
            'job_title' => $job_title,
            'company_id' => $currentUser->company_id ?? 0, // Set company_id to 0 if it's null for global job titles
        ], true); // Passing true to return the inserted ID
    
        // Check if insertion was successful
        if ($jobTitleId) {
            // Fetch the newly added job title from the database
            $newJobTitle = $this->jobTitleModel->find($jobTitleId);
    
            return $this->respondCreated([
                'message' => 'Job title added successfully.',
                'job_title' => $newJobTitle['job_title'],
                'id' => $newJobTitle['id'],
                'assigned_users'=> 0
            ]);
        }
    
        return $this->fail('Failed to add job title.');
    }
    

    /**
     * Delete a job title (company-specific only if not locked).
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function delete($id)
    {
        $currentUser = auth()->user();

        // Ensure the job title is deletable (not locked)
        if ($this->jobTitleModel->deleteJobTitle($id, $currentUser->company_id)) {
            return $this->respondDeleted(['message' => 'Job title deleted successfully.']);
        }

        return $this->fail('Failed to delete job title or the job title is locked.');
    }

    /**
     * Update a job title (company-specific only).
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function update($id)
    {
        $companyId = $this->request->getPost('company_id'); // Optional, required for company-specific updates
        $newName = $this->request->getPost('name');

        // Validate input
        if (!$newName) {
            return $this->failValidationErrors('Job title name is required.');
        }

        // Update the job title
        if ($this->jobTitleModel->updateJobTitle($id, $newName, $companyId)) {
            return $this->respond(['message' => 'Job title updated successfully.']);
        }

        return $this->fail('Failed to update job title or the job title is locked.');
    }
}
