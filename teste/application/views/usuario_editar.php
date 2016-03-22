<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Configura&ccedil;&otilde;es do usu&aacute;rio</title>
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
              <li><a href="<?php echo site_url('/estatisticas/') ?>"><i class="icon-file icon-white"></i> Estat&iacute;sticas</a></li>
              <li class="dropdown active">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i> <?php echo $dadosUsuarioLogado->deNome; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
			      <li><a href="#">Configura&ccedil;&otilde;es</a></li>
			    </ul>
			  </li>
              <li><a href="<?php echo site_url('/auth/sair/') ?>"><i class="icon-off icon-white"></i> sair</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

       <h2>Configura&ccedil;&otilde;es do usu&aacute;rio</h2>
       <br />
       
	   <?php echo validation_errors(); ?>
       
       <form class="form-horizontal" action="<?php echo site_url('/usuario/atualizar/') ?>" method="post">
	    <fieldset>
		 <legend>Dados pessoais</legend>
	     <div class="control-group">
	      <label class="control-label" for="deNome">Nome</label>
	      <div class="controls">
	       <input type="text" name="deNome" id="deNome" value="<?php echo $dadosUsuarioBanco->deNome; ?>">
	      </div>
	     </div>
	     <div class="control-group">
	      <label class="control-label" for="deSobrenome">Sobrenome</label>
	      <div class="controls">
	       <input type="text" name="deSobrenome" id="deSobrenome" value="<?php echo $dadosUsuarioBanco->deSobrenome; ?>">
	      </div>
	     </div>
	    </fieldset>
	    
	    <fieldset>
		 <legend>Dados de acesso</legend>
	     <div class="control-group">
	      <label class="control-label" for="deEmail">E-mail</label>
	      <div class="controls">
	       <input type="text" name="deEmail" id="deEmail" value="<?php echo $dadosUsuarioBanco->deEmail; ?>">
	      </div>
	     </div>
	     <div class="control-group">
	      <label class="control-label" for="deSenha">Senha</label>
	      <div class="controls">
	       <input type="password" name="deSenha" id="deSenha" value="">
	      </div>
	     </div>
	    </fieldset>
	    
	    <?php if ($dadosUsuarioLogado->cdTipo == 2) { ?>
	    <fieldset>
		 <legend>Permiss&otilde;es</legend>
	     <div class="control-group">
	      <label class="control-label" for="cdTipo">Tipo de usu&aacute;rio</label>
	      <div class="controls">
	       <select name="cdTipo" id="cdTipo">
	        <option value="">Selecione...</option>
	        <?php 
	        foreach ($tipoUsuario as $usuario) {
	        	$selected = ($usuario->cdTipo == $dadosUsuarioLogado->cdTipo ? 'selected' : null);
	        	echo '<option value="' . $usuario->cdTipo . '" ' . $selected . '>' . $usuario->deTipo . '</option>';
	        }
	        ?>
	       </select>
	      </div>
	     </div>
	    </fieldset>
	    <?php } ?>
	    
        <div class="form-actions">
	     <button type="submit" class="btn btn-primary">Salvar</button>
	     <button type="button" class="btn" onClick="javascript:cancelar();">Cancelar</button>
	    </div>
	   </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/teste/bootstrap/js/jquery.min.js"></script>
    <script src="/teste/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    	
    });

    function cancelar() {
		location.href="<?php echo site_url('/') ?>";
    }
    </script>

  </body>
</html>