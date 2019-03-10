<?php


    $db_user_name = S_DB_USER;
    $db_user_pass = S_DB_PASS;
    $db_user_host = S_DB_HOST;
    $db_user_port = S_DB_PORT;
    $db_name_____ = S_DB_NAME;


$target_IP = '192.168.8.253';

?>
<div class="jumbotron animated flipInX">
  <h1 class="display-3">SQL injection defense part.</h1>
  <h2 class="display-4">Task Scenario</h2>
  <p class="lead">
      There is a website running under (<a target="_blank" href="http://<?php echo $target_IP; ?>"><span class="target-ip"><?php echo $target_IP; ?></span></a>) IP address. An attacker somehow found the vulnerability hole and started dumping the data from the database. Owner of that website has got an alert but did not know what to do and just removed the configuration file to stop the website running.
      <br>
    Now the owner is asking you for help. You need to make that website working again and fix issues regarding SQL injection.
  </p>
</div>

<div class="jumbotron animated flipInX">
    <h3 class="display-4">Connect to a server and get access to the files.</h3>
    <hr class="mb-3">
    <p>
        There is <b>ssh</b> server running on the target machine. <br>
        Credentials are <b>ninja:ninja</b>.<br><br> 
        Step #1. You can simply use <code>ssh ninja@<span class="target-ip"><?php echo $target_IP; ?></span></code> and once it asks about password - write <em>ninja</em> again. After that you will have a direct access to that server and if you edit anything it will affect to live website. After that you are free to choose any favorite text editor like <b>nano</b>, <b>vim</b> etc. But not everybody like terminal environment and for thet reason we can set up things better. If you dont like 1st step then follow step #2.
        <br>
        <br>
        Step #2. Lets install <em>sshfs</em> by running command [<code> sudo apt-get install sshfs </code>]. The password for current machine is <b>student</b>.<br>
        Then run [<code> mkdir working_dir </code>]<br>
        [ <code>sshfs ninja@<span class="target-ip"><?php echo $target_IP; ?></span>:/var/www/html/ ./working_dir</code> ]
        <br> when it asks for a password use <b>ninja</b>
        <br>
        <br>
        After that we will have all the server files inside <b>./working_dir</b> directory and once we change anything there (locally) it will affect to server files as well. So, we have a direct access and we can do whatever we like.
        <br>
        Last thing is to open it with a text editor which styles code better then <em>nano</em> or <em>vim</em>.<br>
        Such text editor is already installed in your machine and you can access it under menu tab: <b>Menu</b> -> <b>Accessories</b> -> <b>Pluma</b>
        <br>
        If you dont like <b>Pluma</b> you can install any texteditor you like. <br>
        To install <b>Atom</b> run command below <br>
        [ <code>sudo add-apt-repository ppa:webupd8team/atom</code> ]<br>
        [ <code>sudo apt update; sudo apt install atom</code> ] <br>
        Once you install it then you can open whole folder which is way much convenient.
    </p>
    <hr class="mb-3">
</div>

<div class="jumbotron animated flipInX">
    <h3 class="display-4">Task #1. Setup a connetion to the Database</h3>
    <hr class="mb-3">
    <p class="mt-2">
        The owner gave you credentials. You need to find out configuration file and enter data on it. <br>
        Database host: <b class="db-host"><?php echo $db_user_host; ?></b>, <br>
        Database user: <b class="db-user"><?php echo $db_user_name; ?></b>, <br>
        Database password: <b class="db-pass"><?php echo $db_user_pass; ?></b>, <br>
        Database name: <b class="db-name"><?php echo $db_name_____; ?></b>, <br>
        Database port: <b class="db-port"><?php echo $db_user_port; ?></b>, <br>
    </p>
    <p class="mt-1">If you think that you solved the problem then hit the <code>check</code> button</p>
    <hr class="mb-3">
    <div class="alert alert-success" role="alert" id="task-1-alert" style="display: none;">
      <b>Success!</b> You did it!
    </div>
    <div class="alert alert-danger" role="alert" id="task-1-alert-wrong" style="display: none;">
      <b>Wrong!</b> The bug is not fixed yet. Try again!
    </div>
    <button class="btn btn-primary btn-lg" id="task-1" >check</button>
</div>

<div class="jumbotron animated flipInX">
    <h3 class="display-4">Task #2. Fix SQL injection</h3>
    <hr class="mb-3">
    <p class="mt-2">
        Find out vulnerability hole and add proper parsing method.
    </p>
    <p class="mt-1">If you think that you solved the problem then hit the <code>check</code> button</p>
    <hr class="mb-3">
    <div class="alert alert-success" role="alert" id="task-2-alert" style="display: none;">
      <b>Success!</b> You did it!
    </div>
    <div class="alert alert-danger" role="alert" id="task-2-alert-wrong" style="display: none;">
      <b>Wrong!</b> The bug is not fixed yet. Try again!
    </div>
    <button class="btn btn-primary btn-lg" id="task-2" >check</button>
</div>



<script type="text/javascript">
    $("#task-1").click(function(){
        let self = this;
        $.ajax({
            beforeSend: function(){
                $(self).html('Wait...');
                $(self).attr('disabled', '');
            },
            method: 'post',
            url: '<?php echo HOME_AJAX; ?>',
            data: {
                action: 'check',
                task: '1',
                csrf: ''
            },
            success: function(resp){
                $('#task-1-alert, #task-1-alert-wrong').hide();
                if(typeof resp.msg !== "undefined" && resp.msg === 'fixed'){
                    $('#task-1-alert').show();
                }else{
                    $('#task-1-alert-wrong').show();
                }
            },
            error:function(){
                console.warn('No internet');
            },
            complete: function(){
                $(self).html('Check');
                $(self).removeAttr('disabled');
            }
        });
    });

    $("#task-2").click(function(){
        let self = this;
        $.ajax({
            beforeSend: function(){
                $(self).html('Wait...');
                $(self).attr('disabled', '');
            },
            method: 'post',
            url: '<?php echo HOME_AJAX; ?>',
            data: {
                action: 'check',
                task: '2',
                csrf: ''
            },
            success: function(resp){
                $('#task-2-alert, #task-2-alert-wrong').hide();
                if(typeof resp.msg !== "undefined" && resp.msg === 'fixed'){
                    $('#task-2-alert').show();
                }else{
                    $('#task-2-alert-wrong').show();
                }
            },
            error:function(){
                console.warn('No internet');
            },
            complete: function(){
                $(self).html('Check');
                $(self).removeAttr('disabled');
            }
        });
    });

</script>