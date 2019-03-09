<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/md/css/mdb.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/md/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/md/css/style.css">
    <script src="<?php echo ROOT_PATH; ?>assets/md/js/jquery-3.2.1.min.js"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="<?php echo ROOT_PATH; ?>assets/md/js/popper.min.js"></script>
    <title><?php echo TITLE; ?></title>
  </head>
  <body>
  <!-- nav start -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand text-danger" style="font-weight: bold;" href="#">
      DO<i class="fa fa-database"></i> <i class="fa fa-eyedropper"> </i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item home">
          <a class="nav-link" href="<?php echo HOMEINDEX; ?>">Home <i class="fa fa-home"></i></a>
        </li>
      </ul>

      <span class="navbar-text">
        <?php echo TITLE_DESCR; ?>
      </span>
    </div>
  </nav>

  <!-- nav end -->

    <div class="container-fluid" style="margin-top: 140px;">
      <?php Messages::display(); ?>
      <?php require($view); ?>
      <!-- footer start -->
      <!-- footer end -->
      <?php require('./views/footer.html'); ?>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo ROOT_PATH; ?>assets/md/js/bootstrap.min.js"></script>
    <script src="<?php echo ROOT_PATH; ?>assets/md/js/mdb.min.js"></script>
  </body>
</html>