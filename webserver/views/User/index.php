<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <h3 class="text-center">Welcome</h3>
        <h5>Yay, <span class="text-warning"><?php echo $_SESSION['student'];?></span> is here.</h5>
        <br>
        <p>You can either <a href="<?php echo USER_SIGN_UP; ?>">create</a> new record or <a href="<?php echo USER_SIGN_IN; ?>">login</a> with the existing user!</p><br><br>
        <p>
        	SQL injection challenge for Bloom's Taxonomy Level: <b>Applying</b>
        </p>
        <br><br>
        <p>
            For more details please click <i data-toggle="modal" data-target="#labInfoBtn">Lab info</i>
        </p>
    </div>
</div>
