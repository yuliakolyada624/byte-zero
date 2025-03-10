<?php 
namespace App\Modules\Landing\Controllers;


use App\Libraries\MailSender;
use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
	use ResponseTrait;
	
	public function index()
	{

        $data = [ 
			'title' => 'Mebibrief - home',
			'bodyClass' => 'index-page',
	  	];

 		return view('Landing/landing', $data);
	}

	public function sendForm()
	{
		// Get the data from the request
		$requestData = $this->request->getPost();

		// Check for the presence of required fields
		if (!isset($requestData['first_name'], $requestData['last_name'], $requestData['email'], $requestData['message'])) {
			return $this->setResponseFormat('json')->respond(['error' => true, 'message' => 'Missing required fields.'], 400);
		}

		// Compile the data for the email
		$to_emails_list = 'olexandr@med-test.ai, nikolay@med-test.ai';
		$email_subject = 'Med-Test - Get in touch submitted form';
		
		$email_text = "First Name: " . htmlspecialchars($requestData['first_name']) . "<br />" .
					"Last Name: " . htmlspecialchars($requestData['last_name']) . "<br />" .
					"Email: " . htmlspecialchars($requestData['email']) . "<br />" .
					"Message: " . nl2br(htmlspecialchars($requestData['message'])) . "<br />" .
					(isset($requestData['topic_of_interest']) ? "Topic of Interest: " . htmlspecialchars($requestData['topic_of_interest']) : '');

		// Initialize MailSender
		$MailSender = new MailSender();

		// Send the email
		if ($MailSender->sendCommonMail($to_emails_list, $email_subject, $email_text)) {
			return $this->setResponseFormat('json')->respond(['error' => false, 'message' => 'Email sent successfully.']);
		} else {
			return $this->setResponseFormat('json')->respond(['error' => true, 'message' => 'Failed to send email.'], 500);
		}
	}


}
