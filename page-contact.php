<?php
/*
    Template Name: Contact Page
*/
require_once('functions/recaptchalib.php');

global $exray_general_options; 
$error_name = false;
$error_email = false;
$error_message = false;
$error_captcha = false;

// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = $exray_general_options['recaptcha_public_key'];
$privatekey =$exray_general_options['recaptcha_private_key'];
# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

if(isset($_POST['contact-submit'])){
    //Initalize variable for Form FIeld
    $name ="";
    $email="";
    $website="";
    $message="";
    $receiver_email="";

    // get the sender name
    if(trim($_POST['contact-author']) === ''){
        $error_name = true;
    }else{
        $name = esc_attr( trim($_POST['contact-author']) );
    }

    //Get the email
     if(trim($_POST['contact-email']) === '' || !is_email( trim($_POST['contact-email']) )){
        $error_email = true;
    }else{
        $email = esc_attr( trim($_POST['contact-email']) );
    }

    //Get the website url
    $website = esc_attr( trim($_POST['contact-website']) );

    //Get the Message
    if(trim($_POST['contact-message']) === '' ){
        $error_message = true;
    }else{
        $message =  esc_textarea( stripslashes( trim($_POST['contact-message'])) );
    }

    if(!empty($publickey) && !empty($privatekey) ){
	    # was there a reCAPTCHA response?
		if ( isset($_POST["recaptcha_response_field"]) ) {
		    $resp = recaptcha_check_answer (
		    	$privatekey,
		        $_SERVER["REMOTE_ADDR"],
		        $_POST["recaptcha_challenge_field"],
		        $_POST["recaptcha_response_field"]
		    );

		    if (!$resp->is_valid) {
		        $error_captcha = true;
		    }
		}
	}

    //Check if errors occures
    if(!$error_name && !$error_email && !$error_message && !$error_captcha){
        //Get the received email
        $options = get_option('exray_theme_general_options');
        $receiver_email = ( $options['contact_form_email_receiver'] == '' ? get_option( 'admin_email' ) : $options['contact_form_email_receiver'] );
   
        $subject = 'You have been contacted by: '. $name;
        $body = "You have been contacted by $name. Their message is:". PHP_EOL. PHP_EOL;
        $body .= $message . PHP_EOL. PHP_EOL;
        $body .= "You can contact $name via email at $email ";
        if($website != ''){
            $body .= "and visit their website at $website ";
        }
        $body .= PHP_EOL . PHP_EOL;

        $headers = "From: $email" . PHP_EOL;
		$headers .= "Reply-To: $email" . PHP_EOL;
		$headers .= "MIME-Version: 1.0" . PHP_EOL;
		$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
		$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

        if (mail($receiver_email, $subject, $body, $headers)) {
            $email_sent = true;
        } else{
            $email_sent = false;
        }

    }

}
?>
<?php get_header(); ?>

<!-- Main Content -->
<div class="container" id="main-container">
	
	<div class="row">

		<div class="span6 article-container-adaptive" id="main">

			<?php Exray::load_breadcrumb(); ?>
			
			<div class="content" role="main">
				
				<?php  if(have_posts()) : while(have_posts()) : the_post(); ?>				
				<article class="post clearfix" id="post-1" role="article">
					
					<header>
						
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php get_entry_meta('half'); ?>
					</header>

                    <?php if(isset ($email_sent) && $email_sent == true) : ?>

                        <h3><?php _e('Success!', 'exray-framework') ?></h3>
                        <p><?php _e('Email successfully sent', 'exray-framework') ?></p>
                        <a href="<?php the_permalink(); ?>"><?php echo _e('&larr; Back to contact form', 'exray-framework'); ?></a>

                    <?php elseif(isset ($email_sent_error) && $email_sent_error == true) : ?>

                        <h3><?php _e('Error!', 'exray-framework') ?></h3>
                        <p><?php _e('Unable sending email', 'exray-framework') ?></p>

                    <?php else: ?>

                        	<div class="entry-content">

						<?php the_content(); ?>

						<form action="<?php echo the_permalink(); ?>" method="post" id="contact-form">
							<p <?php if($error_name) echo 'class="p-errors"'; ?> >
                                <label for="contact-author"><?php _e('Name *', 'exray-framework'); ?></label>
                                <input type="text" value="<?php if(isset ($_POST['contact-author'])) echo $_POST['contact-author'];  ?>" name="contact-author" id="contact-author"/>
							</p>
							<p <?php if($error_email) echo 'class="p-errors"'; ?>>
								<label for="contact-email"><?php _e('Email *', 'exray-framework'); ?></label>
								<input type="text" value="<?php if(isset ($_POST['contact-email'])) echo $_POST['contact-email'];  ?>" name="contact-email" id="contact-email"/>
							</p>
							<p>
								<label for="contact-website"><?php _e('Website', 'exray-framework'); ?></label>
								<input type="text" value="<?php if(isset ($_POST['contact-website'])) echo $_POST['contact-website'];  ?>" name="contact-website" id="contact-website"/>
							</p>
							<p <?php if($error_message) echo 'class="p-errors"'; ?>>
								<label for="contact-message"><?php _e('Message', 'exray-framework'); ?></label>
                                <textarea name="contact-message" id="contact-message" cols="30" rows="10"><?php if(isset ($_POST['contact-message'])) echo stripslashes( $_POST['contact-message']);  ?> </textarea>
							</p>
							<p <?php if( $error_captcha ) echo 'class="p-errors"'; ?> >
								<?php if(!empty($publickey) && !empty($privatekey) ) : ?>
									<label for="contact-captcha"><?php _e('Are you human? Please solve captcha below to prove it.', 'exray-framework'); ?></label>
									<?php echo recaptcha_get_html($publickey, $error); ?>
								<?php endif; ?>
							</p>

							<input type="hidden" name="contact-submit" id="contact-submit" value="true"/>
							<p><input type="submit" value="Send Message"/></p>
						</form>

					</div>

                    <?php endif; ?>
                    <!--  End Email -->
				
								
				</article> 	
				<!-- End article -->
					
				<?php endwhile; else : ?>
				<!-- If no post found -->
				<article>
					<h1><?php _e('No post were found!', 'exray-framework'); ?></h1>
				</article>

				<?php endif ?>
	
			</div> 
			<!-- end content -->
		</div> 
		<!-- end span6 primary -->

		<div id="primary" class="widget-area span3 main-sidebar" role="complementary">

			<?php get_sidebar('sidebar'); ?>

		</div>  
		<!-- end span3 primary left-sidebar -->	

		<div id="secondary" class="widget-area span3 main-sidebar" role="complementary">						

			<?php get_sidebar('secondary'); ?>
					
		</div> 
		<!-- end span3 secondary right-sidebar -->

	</div>
	<!-- ENd Row -->
</div>
<!-- End main-cotainer -->
<?php get_footer();?>