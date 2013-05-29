<?php
global $exray_general_options; 

class Contact{
	public $error_name = false;
	public $error_email  = false;
	public $error_message = false;
	public $error_captcha = false;
	public $resp = null;
	public $error = null;
	public $publickey, $privatekey;

	//Initalize variable for Form FIeld
    public $name ="";
    public $email="";
    public $website="";
    public $message="";
    public $receiver_email="";
 	public $email_sent;
    public $email_sent_error;

    /**
     * Process all contact form data and sent email to website admin
     * @param  string $name    Sender name from contact form, Must be filled.
     * @param  string $email   Sender email address from contact form, must be filled.
     * @param  string $website Sender website from contact form.
     * @param  string $message Sender message from contact form, Must be filled.
     * @return string          Sent all sender data to admin / designated email address from Theme option.
     */
	public function load_contact($name, $email, $website, $message){

		if(isset($name) && isset($email) && isset($message) ){
			$this->validate_name($name);
			$this->validate_email($email);
			$this->validate_website($website);
			$this->validate_message($message);
			$this->validate_recaptcha($this->get_publickey(), $this->get_privatekey());

			$this->sent_mail();
		}
	}

	/**
	 * Validate sender name to make sure it's not empty.
	 * @param  string $name sender name
	 */
	private function validate_name($name){
		if(Exray::isEmpty($name)) {
			$this->error_name = true;
		}
		else{
			$this->name = esc_attr( trim($name) );
		}
	}

	/**
	 * Get sender name.
	 * @return string 
	 */
	public function get_name(){
		return $this->name;
	}

	/**
	 * Get error message value.
	 * @return boolean error will appear if sender name isn't filled correctly.
	 */
	public function get_error_name(){
		return $this->error_name;
	}

	/**
	 * Validate sender email to make sure it's not empty and correct email format.
	 * @param  string $email sender email
	 */
	private function validate_email($email){
		if( Exray::isEmpty($email) || !is_email(trim($email)) ) {
			$this->error_email = true;
		}
		else{
			$this->email = esc_attr( trim($email) );
		}
	}

	/**
	 * Get sender email.
	 * @return string 
	 */
	public function get_email(){
		return $this->email;
	}

	/**
	 * Get error email value.
	 * @return boolean error will appear if sender email isn't filled correctly.
	 */
	public function get_error_email(){
		return $this->error_email;
	}

	/**
	 * Trim website url.
	 * @param  string $website sender website.
	 */
	private function validate_website($website){
		$this->website = esc_attr( trim($website) );
	}

	/**
	 * Get sender website.
	 * @return string 
	 */
	public function get_website(){
		return $this->website;
	}

	/**
	 * Validate sender message to make sure it's not empty.
	 * @param  string $message sender message.
	 */
	private function validate_message($message){
		if(Exray::isEmpty($message)) {
			$this->error_message = true;
		}
		else{
			$this->message = esc_textarea( stripslashes(trim($message)) );
		}
	}

	/**
	 * Get sender message.
	 * @return string 
	 */
	public function get_message(){
		return $this->message;
	}

	/**
	 * Get error message value.
	 * @return boolean error will appear if sender message isn't filled correctly.
	 */
	public function get_error_message(){
		return $this->error_message;
	}

	/**
	 * Set public key for reCaptcha.
	 * @param string $publickey reCaptcha publickey.
	 */
	public function set_publickey($publickey){
		$this->publickey = $publickey;
	}

	/**
	 * Get public key for reCaptcha.
	 * @param string $publickey reCaptcha publickey.
	 */
	public function get_publickey(){
		return $this->publickey;
	}

	/**
	 * Set private key for reCaptcha.
	 * @param string $privatekey reCaptcha privatekey.
	 */
	public function set_privatekey($privatekey){
		$this->privatekey = $privatekey;
	}

	/**
	 * Get private key for reCaptcha.
	 * @param string $privatekey reCaptcha privatekey.
	 */
	public function get_privatekey(){
		return $this->privatekey;
	}

	/**
	 * Get error catcha value.
	 * @return boolean error will appear if catcha isn't filled correctly.
	 */
	public function get_error_captcha(){
		return $this->error_captcha;
	}

	/**
	 * Get the status if email is successfullt sent or not.
	 * @return boolen true if success.
	 */
	public function get_email_sent(){
		return $this->email_sent;
	}

	/**
	 * Find if there are any error on sending email process.
	 * @return boolean true if email error found.
	 */
	public function get_email_sent_error(){
		return $this->email_sent_error;
	}

	/**
	 * Validate reCaptcha catpcha value from user.
	 * @param  string $publickey  reCaptcha public key.
	 * @param  string $privatekey reCaptcha private key.
	 * @return boolean            True if correct captcha inputed.
	 */
	private function validate_recaptcha($publickey, $privatekey){
	   if(!empty($publickey) && !empty($privatekey) ){

	   		 # was there a reCAPTCHA response?
			if ( isset($_POST["recaptcha_response_field"]) ) {
			    $this->resp = recaptcha_check_answer (
			    	$privatekey,
			        $_SERVER["REMOTE_ADDR"],
			        $_POST["recaptcha_challenge_field"],
			        $_POST["recaptcha_response_field"]
			    );

			    if (!$this->resp->is_valid) {
			        $this->error_captcha = true;
			    }
			}
		}

	}

	/**
	 * Process all data and sent mail to designated email / admin email address.
	 * @return string sent email if all data correct.
	 */
	private function sent_mail(){
	    if(!$this->error_name && !$this->error_email && !$this->error_message && !$this->error_captcha)
	    {
	        global $exray_general_options;
	        // If contact form email reciver not set, email will be sent to admin email address.
	        $this->receiver_email = ( Exray::isEmpty( $exray_general_options['contact_form_email_receiver'] ) ? get_option( 'admin_email' ) : $exray_general_options['contact_form_email_receiver'] );

	        $subject = __('You have been contacted by: ', 'exray-framework') . $this->name;
	     	// Init wordpress __($text, $domain) translation function to be used inside heredocs.
	        $_ = "__"; 

$body = <<<BODY
{$_('You have been contacted by', 'exray-framework')} $this->name. 
{$_('Their message is', 'exray-framework')}: 

$this->message 

{$_('You can contact', 'exray-framework')} $this->name {$_('via email at', 'exray-framework')} $this->email 
BODY;
			//If sender website exist/ append it to message body.
			if($this->website != ''){
	            $body .= __('and visit their website at ', 'exray-framework'). $this->website;
	        }

$header = <<<HEADER
From: $this->email 
Reply-To: $this->email 
MIME-Version: 1.0 
Content-type: text/plain; charset=utf-8 
Content-Transfer-Encoding: quoted-printable
HEADER;

	        if (mail( $this->receiver_email, $subject, $body, $header)) {
	            $this->email_sent = true;
	            $this->email_sent_error = false;
	        } else{
	            $this->email_sent = false;
	            $this->email_sent_error = true;
	        }

    	}
	}
}

$contact = new Contact;

?>