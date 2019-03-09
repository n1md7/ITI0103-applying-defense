<?php
if(file_exists('../../db_user_name.txt')){
    $db_user_name = file_get_contents('../../db_user_name.txt');
    $db_user_pass = file_get_contents('../../db_user_pass.txt');
    $db_user_host = file_get_contents('../../db_user_host.txt');
    $db_user_port = file_get_contents('../../db_user_port.txt');
    $db_name_____ = file_get_contents('../../db_name.txt');
}else{
    $db_user_name = file_get_contents('/var/www/db_user_name.txt');
    $db_user_pass = file_get_contents('/var/www/db_user_pass.txt');
    $db_user_host = file_get_contents('/var/www/db_user_host.txt');
    $db_user_port = file_get_contents('/var/www/db_user_port.txt');
    $db_name_____ = file_get_contents('/var/www/db_name.txt');
}

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
        Then run [<code> mkdir working_dir; cd working_dir </code>]<br>
        [ <code>sshf ninja@<span class="target-ip"><?php echo $target_IP; ?></span>:/var/www/html/ ./working_dir</code> ]
        <br> when it asks for a password use <b>ninja</b>
        <br>
        <br>
        After that we will have all the server files inside <b>./working_dir</b> directory and once we change anything there (locally) it will affect to server files as well. So, we have a direct access and we can do whatever we like.
        <br>
        Last thig is to open it with a text editor which styles code better then <em>nano</em> or <em>vim</em>.<br>
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
        The owner gaved you credentials. You need to find out configuration file and enter data on it. <br>
        Database host: <b class="db-host"><?php echo $db_user_host; ?></b>, 
        Database user: <b class="db-user"><?php echo $db_user_name; ?></b>, 
        Database passowrd: <b class="db-pass"><?php echo $db_user_pass; ?></b>, 
        Database name: <b class="db-name"><?php echo $db_name_____; ?></b>, 
        Database port: <b class="db-port"><?php echo $db_user_port; ?></b>, 
    </p>
    <p class="mt-1">If you think that you solved the problem then hit the <code>check</code> button</p>
    <hr class="mb-3">
    <a class="btn btn-primary btn-lg" href="javascript:void(0)" role="button">check</a>
</div>