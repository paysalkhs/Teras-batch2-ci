<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Bare - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="<?=base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="#">Start Bootstrap</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <?php if($this->session->userdata('login')){ ?>
              <?php foreach($menu->result() as $val){ ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?=base_url($val->menu_url);?>"><?=$val->menu_name;?></a>
                </li>
              <?php } ?>
              <li class="nav-item">
                <a class="nav-link" href="#"><?php echo ucfirst($this->session->userdata('username')); ?></a>
              </li>
          <?php }else{ ?>
            <?php foreach($menu->result() as $val){ ?>
              <li class="nav-item">
                <a class="nav-link" href="<?=base_url($val->menu_url);?>"><?=$val->menu_name;?></a>
              </li>
            <?php } ?>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>