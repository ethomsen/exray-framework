<?php
/*
    Template Name: Contact Page
*/
?>
<?php 
	
	function isEmail($verify_email) {

		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$verify_email));
	}

	$error_name = false;
	$error_email = false;
	$error_message = false;

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
            $name = trim($_POST['contact-author']);
        }

        //Get the email
         if(trim($_POST['contact-email']) === '' || !isEmail(trim($_POST['contact-email']))){
            $error_email = true;
        }else{
            $email = trim($_POST['contact-email']);
        }

        //Get the website url
        $website = trim($_POST['contact-website']);

        //Get the Message
        if(trim($_POST['contact-message']) === '' ){
            $error_message = true;
        }else{
            $message =  stripslashes( trim($_POST['contact-message']));
        }

        //Check if errors occures
        if(!$error_name && !$error_email && !$error_message){
            //Get the received email
            $options = get_option('exray_custom_settings');
            $receiver_email = $options['contact_email'];
            
            $subject = 'You have been contacted by: '. $name;
            $body = "You have been contacted by $name. Their message is:". PHP_EOL. PHP_EOL;
            $body .= $message . PHP_EOL. PHP_EOL;
            $body .= "You can contact $name via email at $email";
            if($website != ''){
                $body .= "and visit their website at $website";
            }
            $body .= PHP_EOL . PHP_EOL;

            $headers = "From $email". PHP_EOL;
            $headers.= "Reply to: $email". PHP_EOL;
            $headers .= "MIME-version: 1.0". PHP_EOL;
            $headers .= "Content-type: text/plain; charset=utf-8". PHP_EOL;
            $headers .= "Content-Transfer-Encoding: quoted-printable". PHP_EOL;

            if (mail($receiver_email, $subject, $body, "From:bar@foo.com\r\n")) {
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
			
			<div class="content" role="main">

				<?php if(have_posts()) : while(have_posts()) : the_post(); ?>				
				<article class="post clearfix" id="post-1" role="article">
					
					<header>
						
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<div class="entry-meta">								
								<p class="article-meta-extra">										
					                 <?php
                                       if(current_user_can('edit_post', $post->ID)){
					                 		edit_post_link(__('Edit', 'exray-framework'), '<p><span class="icon left-meta-icon">S</span>&nbsp;', '</p>', '');
					                 	}

					                 ?>
									
								</p>
							</div> 
							<!-- End entry-meta -->
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
						<!-- Experimental -->
						<?php if(has_post_thumbnail()) : ?>

							<aside class="post_image">
								<figure class="article-preview-image">

									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

								</figure>
							</aside>

						<?php else: ?>
							<!-- <hr class="content-separator"> -->
						<?php endif ?>
						<!-- End post_image Experimental -->

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
								<label for="contact-website"><?php _e('Website*', 'exray-framework'); ?></label>
								<input type="text" value="<?php if(isset ($_POST['contact-website'])) echo $_POST['contact-website'];  ?>" name="contact-website" id="contact-website"/>
							</p>
							<p <?php if($error_message) echo 'class="p-errors"'; ?>>
								<label for="contact-message"><?php _e('Message', 'exray-framework'); ?></label>
                                <textarea name="contact-message" id="contact-message" cols="30" rows="10"><?php if(isset ($_POST['contact-message'])) echo stripslashes( $_POST['contact-message']);  ?> </textarea>
							</p>

							<input type="hidden" name="contact-submit" id="contact-submit" value="true"/>
							<p><input type="submit" value="Send Message"/></p>
						</form>

					</div>

                        <?php if(has_tag()) : ?>

                            <footer class="entry-meta cb" id="tag-container" role="contentinfo">

                                <ul class="tags">
                                    <li><span class="icon tags">,</span></li>
                                    <?php the_tags() ?>

                                </ul>

                            </footer>

                        <?php else: ?>

                            <hr class="content-separator">

                        <?php endif; ?>
                        <!-- end meta (category & tag) -->

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

					<!-- End article-author -->
					<div class="comment-area" id="comments">
						
						<?php comments_template('', true); ?>

					</div>
					<!-- End comment-area -->
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