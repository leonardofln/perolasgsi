<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>P&eacute;rolas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/teste/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo site_url('/') ?>">P&eacute;rolas <span class="label">BETA!</span></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="<?php echo site_url('/') ?>"><i class="icon-home icon-white"></i> In&iacute;cio</a></li>
              <li class="active"><a href="<?php echo site_url('/estatisticas/') ?>"><i class="icon-file icon-white"></i> Estat&iacute;sticas</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i> <?php echo $dadosUsuarioLogado->deNome; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
			      <li><a href="<?php echo site_url('/usuario/editar/') ?>">Configura&ccedil;&otilde;es</a></li>
			    </ul>
			  </li>
              <li><a href="<?php echo site_url('/auth/sair/') ?>"><i class="icon-off icon-white"></i> sair</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <h2>Estat&iacute;sticas</h2>
      
      <legend>top 10 (frases mais votadas)</legend>
      
      <?php
      foreach ($frases as $frase) {
      	  echo ' <div class="well">';
      	  echo '  ' . $frase->deFrase . '<br />';
      	  echo '  <span class="badge badge-success">' . $frase->nrGostei . '</span>';
      	  echo '  <a href="javascript:void(0);"><i class="icon-thumbs-up" style="opacity: 0.4"></i></a> &nbsp; ';
      	  echo '  <span class="badge badge-important">' . $frase->nrNaoGostei . '</span>';
      	  echo '  <a href="javascript:void(0);"><i class="icon-thumbs-down" style="opacity: 0.4"></i></a> ';
      	  echo ' </div>';
      }
	  ?>
	  
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/teste/bootstrap/js/jquery.min.js"></script>
    <script src="/teste/bootstrap/js/bootstrap.min.js"></script>
    
  </body>
</html>