<div class="row justify-content-center">
    <div class="col-md-4 innerText">
        <h3 class="text-center"><i class="fa fa-lock"></i> User Authentication</h3>
        <h3 class="text-center spinner" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x fa-fw text-info"></i>
        </h3>
    	<form data-action="<?php echo USER_AJAX; ?>" method="post" id="loginForm">
    		<div class="form-group">
    			<label class="pl-1" for="user"><i class="fa fa-user"></i> Username</label>
    			<input type="text" required="" id="user" autofocus="on" autocomplete="off" class="form-control" name="user" placeholder="Username">
    		</div>
    		<div class="form-group">
    			<label class="pl-1" for="pass"><i class="fa fa-key"></i> PassCode</label>
    			<input type="password" required="" id="pass" class="form-control" name="pass" placeholder="PassCode">
    		</div>
    		<div class="form-group">
    			<div class="d-flex justify-content-center">
	    			<button type="submit" class="btn btn-dark"><i class="fa fa-sign-in"></i> Sign In</button>
	    			<a href="<?php echo USER_SIGN_UP; ?>" class="btn btn-link">Sign Up</a>
    			</div>
    		</div>
            <input type="hidden" name="csrf" class="csrf" value="">
            <input type="hidden" name="action" value="signin">
    	</form>
    </div>
</div>

<script>
    $('.nav-item.signin').addClass('active');
    $('#loginForm').submit(function(event){
        $(this).find('input[name=csrf]').val($('meta[name=csrf]').attr('content'));
        $.ajax({
            beforeSend: function(){
                $('.alert').alert('close');
                $('.spinner').show();
            },
            method: 'POST',
            data: $('#loginForm').serialize(),
            url: $('#loginForm').data('action'),
            success: function(data){
                $('.spinner').hide();
                $('meta[name=csrf]').attr('content', data.csrf);
                if(typeof data.status !== "undefined" && data.status === 'success'){
                    $('.innerText').prepend(`
                        <div class="alert alert-success fade show text-center" role="alert">
                            <strong>Success:</strong> <i class="fa fa-spinner fa-spin fa-1x fa-fw text-success"></i> Redirecting...
                        </div>
                    `);
                    window.location.href = "<?php echo HOMEINDEX; ?>";
                }else{
                    $('.innerText').prepend(`
                        <div class="alert alert-danger fade show text-center" role="alert">
                            <strong>Error:</strong> ${data.msg}!
                        </div>
                    `);
                }

            },
            error: function(){
                $('.innerText').prepend(`
                    <div class="alert alert-danger fade show text-center" role="alert">
                        <strong>Error:</strong>Connection Error! Please refresh the page!
                    </div>
                `); 
            }
        });

        $('.spinner').show();
        event.preventDefault();
    });
</script>