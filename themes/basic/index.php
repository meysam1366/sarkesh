<?php use \core\cls\browser as browser;?>
<!DOCTYPE html> 
<head>
</#HEADERS#/>
<title></#PAGE_TITTLE#/></title>
</head>
<body> 
<div class="navbar navbar-default">
  <div class="container">
    <a class="navbar-brand" href="/"></#SITE_NAME#/></a>
    <?php browser\page::set_position('main_menu'); ?>
  </div>
</div>

<div class="container">
  <?php browser\page::set_position('slide_show'); ?>
  <div class="row">
    <div class="col-lg-4">
      <?php browser\page::set_position('sidebar1'); ?>
    </div>
    
    <div class="col-lg-8">
      <?php browser\page::set_position('content'); ?>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-3">
      <?php browser\page::set_position('top_footer1'); ?>
    </div>
    <div class="col-lg-3">
      <?php browser\page::set_position('top_footer2'); ?>
    </div>
    <div class="col-lg-3">
      <?php browser\page::set_position('top_footer3'); ?>
    </div>
    <div class="col-lg-3">
      <?php browser\page::set_position('top_footer4'); ?>
    </div>
  </div>
  <hr>
  <div class="col-lg-12">
      <?php browser\page::set_position('footer'); ?>
  </div>
  
  
</div> <!-- /container -->
  </body>
</html>