<section id="loginSectionWrap" class="">
	<div class="container">
		<form id="loginform" name="loginform" class="form-horizontal" method="POST" action="<?php echo str_replace('index.php', '', htmlspecialchars($_SERVER["PHP_SELF"]) ); ?>sign-in">
			<?php
			// echo '<pre>';
			// var_dump($_POST);
			// echo '</pre>';
			?>
			<div class="form-group">
				<div class="col-xs-12"><p class="text-center">Please enter your email and password</p></div>
				<div class="col-md-8 col-md-offset-2">
				<?php if (!empty( $_POST['error']['errMsgAlreadyExist'] )): ?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<strong>Email already exist.</strong> Your email <em><?php echo $_POST['ermInputEmail'] ?></em> has already been used to enrol with us.
					</div>
				<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
					<input type="text" class="form-control input-lg <?php if ( !empty( $_POST['error']['ermInputEmail'] ) ) echo 'error'; ?>" id="ermInputEmail" name="ermInputEmail" placeholder="Email" value="<?php echo !empty( $_POST['ermInputEmail'] ) ? $_POST['ermInputEmail'] : '' ?>">
					<?php if ( !empty( $_POST['error']['ermInputEmail'] ) ) :?>
					<label id="ermInputEmail-error" class="error" for="ermInputEmail"><?php echo $_POST['error']['ermInputEmail'] ?></label>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
		        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
		        	<label class="sr-only" for="user_pass">Password</label>
		        	<input type="password" class="form-control input input-lg" name="user_pass" id="user_pass" value="" size="20" placeholder="Password">
		        </div>
		    </div>
		    <div class="form-group margin-top-2x margin-bottom-2x  text-center">
		    	<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
		    		<a href="<?php echo esc_url( home_url( '/forgot-password' ) ); ?>" class="">Forgot Password</a>
		    	</div>
		    </div>

			<button type="submit" class="btn btn-warning btn-lg padding-left-2x padding-right-2x aligncenter margin-top-1x" name="wp-submit" id="wp-submit">Log in</button>
		    <input type="hidden" name="login_nonce" value="<?php echo wp_create_nonce('login-nonce'); ?>"/>
		    <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url() ) ?>">

		</form>
	</div>
</section>
