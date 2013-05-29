<?php
/*
    Template Name: Contact Page
*/
$publickey = $exray_general_options['recaptcha_public_key'];
$privatekey = $exray_general_options['recaptcha_private_key'];

$contact->set_publickey($publickey);
$contact->set_privatekey($privatekey);

if(isset($_POST['contact-submit']) )
{
	$name= $_POST['contact-author'];
	$email= $_POST['contact-email'];
	$website= $_POST['contact-website'];
	$message= $_POST['contact-message'];
	$contact->load_contact($name, $email, $website, $message);
	$email_sent = $contact->get_email_sent();				// Email sent status
	$email_sent_error = $contact->get_email_sent_error();	// Email sent error
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

                    <?php if(isset ($email_sent ) && $email_sent == true) : ?>

                        <h3><?php _e('Email successfully sent', 'exray-framework') ?></h3>
                        <p><?php _e('Thank you for emailing us, we will respond your email immedeatly.', 'exray-framework') ?></p>
                        <a href="<?php the_permalink(); ?>"><?php echo _e('&larr; Back to contact form', 'exray-framework'); ?></a>

                    <?php elseif(isset ($email_sent_error ) && $email_sent_error == true) : ?>

                        <h3><?php _e('Oops, Error!', 'exray-framework') ?></h3>
                        <p><?php _e('Look like we failed to send your email, please try again.', 'exray-framework') ?></p>
                        <a href="<?php the_permalink(); ?>"><?php echo _e('&larr; Back to contact form', 'exray-framework'); ?></a>

                    <?php else: ?>

                	<div class="entry-content">

						<?php the_content(); ?>

						<form action="<?php echo the_permalink(); ?>" method="post" id="contact-form">
							<p <?php if($contact->get_error_name() ) echo 'class="p-errors"'; ?> >
                                <label for="contact-author"><?php _e('Name *', 'exray-framework'); ?></label>
                                <input type="text" value="<?php if(isset ($_POST['contact-author'])) echo $_POST['contact-author'];  ?>" name="contact-author" id="contact-author"/>
							</p>
							<p <?php if($contact->get_error_email() ) echo 'class="p-errors"'; ?>>
								<label for="contact-email"><?php _e('Email *', 'exray-framework'); ?></label>
								<input type="text" value="<?php if(isset ($_POST['contact-email'])) echo $_POST['contact-email'];  ?>" name="contact-email" id="contact-email"/>
							</p>
							<p>
								<label for="contact-website"><?php _e('Website', 'exray-framework'); ?></label>
								<input type="text" value="<?php if(isset ($_POST['contact-website'])) echo $_POST['contact-website'];  ?>" name="contact-website" id="contact-website"/>
							</p>
							<p <?php if($contact->get_error_message() ) echo 'class="p-errors"'; ?>>
								<label for="contact-message"><?php _e('Message', 'exray-framework'); ?></label>
                                <textarea name="contact-message" id="contact-message" cols="30" rows="10"><?php if(isset ($_POST['contact-message'])) echo stripslashes( $_POST['contact-message']);  ?> </textarea>
							</p>
							<p <?php if( $contact->get_error_captcha() ) echo 'class="p-errors"'; ?> >
								<?php if(!Exray::isEmpty($contact->get_publickey() ) && !Exray::isEmpty($contact->get_privatekey() ) ) : ?>
									<label for="contact-captcha"><?php _e('Are you human? Please solve captcha below to prove it.', 'exray-framework'); ?></label>
									<!-- reCaptcha Widget -->
									<?php echo recaptcha_get_html($contact->get_publickey(), $contact->get_privatekey() ); ?>
								<?php endif; ?>
							</p>

							<input type="hidden" name="contact-submit" id="contact-submit" value="true"/>
							<p><input type="submit" value="<?php _e('Send Message', 'exray-framework'); ?>"/></p>
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