<?php 

namespace App\Libraries;

class MailSender{

    private object $config;
	
	public function __construct()
    {        
		$this->config = config('MailSender');
	}
	
	private function getSendTo($user_data)
    {
        if($this->config->mode=='dev'){
            return $this->config->testmode_email;
        } else {
            return $user_data["email"];
        }
    }
	
	public function sendCommonMail($to_emails_list, $email_subject, $email_text, $email_template_path = 'email/common_mail')
	{
		$email = \Config\Services::email();
        $email->setFrom($this->config->from_email, $this->config->from_name);
		
		if($this->config->mode == 'dev')
		{
			$email->setTo($this->config->testmode_email);
        } else {
			$email->setTo($to_emails_list);
		}
		
		$email->setSubject($email_subject);
		
		$template = view($email_template_path, [
			'title' => $email_subject,
            'text' => $email_text,
        ]);
		
		$email->setMessage($template);

        $email->send();

        return true;
	}

    public function SendUserRegisterMail($user_data)
    {
        $email = \Config\Services::email();
        $email->setFrom($this->config->from_email, $this->config->from_name);
        $email->setTo($this->getSendTo($user_data));
        
        $email->setSubject('Register on Med-Test');

        $template = view("email/register", [
            'first_name' => $user_data["first_name"],
            'last_name' => $user_data["last_name"],
            'email' => $user_data["email"],
            'password' => $user_data["password"],
        ]);
        $email->setMessage($template);

        $email->send();
    }


    public function SendInviteMail($user_data)
    {
        $email = \Config\Services::email();
        $email->setFrom($this->config->from_email, $this->config->from_name);
        $email->setTo($this->getSendTo($user_data));

        $email->setSubject('Invite to Med-Test');
      
        $template = view("auth/Email/email_invite", [
            'first_name' => $user_data["first_name"],
            'company_name' => $user_data['company_name'],
            'email' => $user_data["email"],
            'password' => $user_data["password"],
            'code' => $user_data["code"],
            'user' => $user_data["user"],
        ]);
        $email->setMessage($template);

        $email->send();
    }
	

    public function SendResetPasswordMail($user_data){
        $email = \Config\Services::email();
        $email->setFrom($this->config->from_email, $this->config->from_name);
        $email->setTo($this->getSendTo($user_data));

        $email->setSubject('Forgot Your Password?');
      
        $template = view("default/auth/Email/email_reset_password", [
            'token' => $user_data['token'],
        ]);
        $email->setMessage($template);

        $email->send();
    }
	
	
    
}
