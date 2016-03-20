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
              <li class="active"><a href="<?php echo site_url('/') ?>">In&iacute;cio</a></li>
              <!-- <li><a href="#about">Ranking</a></li> -->
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

      <h2>Frases</h2> 
      <?php 
      if (!empty($msg)) {
      	  if ($msg == 1) {
      	  	   echo '<div class="alert alert-success">';
      	  	   echo '<button type="button" class="close" data-dismiss="alert">x</button>';
      	  	   echo '<strong>Parab&eacute;ns!</strong> Frase cadastrada com sucesso.';
      	  	   echo '</div>';
      	  } elseif ($msg == 2) {
      	  	   echo '<div class="alert alert-error">';
      	  	   echo '<button type="button" class="close" data-dismiss="alert">x</button>';
      	  	   echo '<strong>Aten&ccedil;&atilde;o!</strong> Ocorreu um problema ao tentar cadastrar uma frase.';
      	  	   echo '</div>';
      	  } elseif ($msg == 3) {
      	  	   echo '<div class="alert alert-error">';
      	  	   echo '<button type="button" class="close" data-dismiss="alert">x</button>';
      	  	   echo '<strong>Aten&ccedil;&atilde;o!</strong> Sem permissao para excluir uma frase.';
      	  	   echo '</div>';
      	  } elseif ($msg == 4) {
      	  	   echo '<div class="alert alert-success">';
      	  	   echo '<button type="button" class="close" data-dismiss="alert">x</button>';
      	  	   echo '<strong>Parab&eacute;ns!</strong> Frase excluida com sucesso.';
      	  	   echo '</div>';
      	  } elseif ($msg == 5) {
      	  	   echo '<div class="alert alert-error">';
      	  	   echo '<button type="button" class="close" data-dismiss="alert">x</button>';
      	  	   echo '<strong>Aten&ccedil;&atilde;o!</strong> Ocorreu um problema ao tentar excluir uma frase.';
      	  	   echo '</div>';
      	  } elseif ($msg == 6) {
      	  	   echo '<div class="alert alert-error">';
      	  	   echo '<button type="button" class="close" data-dismiss="alert">x</button>';
      	  	   echo '<strong>Aten&ccedil;&atilde;o!</strong> Sem permissao para cadastrar uma frase.';
      	  	   echo '</div>';
      	  }
      }
      ?>
      <?php if ($dadosUsuarioLogado->cdTipo == 2) { ?>
      <a href="#cadastrarFrase" data-toggle="modal">[cadastrar frase]</a><br />
      <?php } ?>
      <br />
	  
	  <?php 
	  foreach ($frases as $frasesPorData) {
	  	  echo '<fieldset>';
	  	  foreach ($frasesPorData as $chave => $frase) {
	  	  	  $jaVotei = false;
	  	  	  
	  	  	  $votantesGostei = '';
	  	  	  foreach ($frase->votantesGostei as $votante) {
	  	  	  	  $votantesGostei .= '- ' . $votante->usuario . '<br />';
	  	  	  	  if ($votante->cdUsuario == $dadosUsuarioLogado->cdUsuario) {
	  	  	  	  	  $jaVotei = true;
	  	  	  	  }
			  }
			  
			  $votantesNaoGostei = '';
			  foreach ($frase->votantesNaoGostei as $votante) {
			  	  $votantesNaoGostei .= '- ' . $votante->usuario . '<br />';
			  	  if ($votante->cdUsuario == $dadosUsuarioLogado->cdUsuario) {
			  	      $jaVotei = true;
			  	  }
			  }
	  	  	  
	  	  	  if ($chave == 0) { 
	  	  	  	  echo ' <legend>' . $frase->dtRegistro . '</legend>';
	  	  	  }
	  	  	  echo ' <div class="well">';
		      echo '  ' . $frase->deFrase . '<br />';
		      echo '  <span class="badge badge-success" id="nrGostei_' . $frase->cdFrase . '" data-title="Gostei" data-content="' . $votantesGostei . '" rel="popover">' . $frase->nrGostei . '</span>'; 
		      if ($jaVotei) {
		      	  echo '  <a href="javascript:void(0);"><i class="icon-thumbs-up" style="opacity: 0.4"></i></a> &nbsp; ';
		      } else {
		      	  echo '  <a href="javascript:gostei(' . $frase->cdFrase . ');"><i class="icon-thumbs-up"></i></a> &nbsp; ';
		      }
		      echo '  <span class="badge badge-important" id="nrNaoGostei_' . $frase->cdFrase . '" data-title="N&atilde;o gostei" data-content="' . $votantesNaoGostei . '" rel="popover">' . $frase->nrNaoGostei . '</span>'; 
		      if ($jaVotei) {
		      	  echo '  <a href="javascript:void(0);"><i class="icon-thumbs-down" style="opacity: 0.4"></i></a> ';
		      } else {
		      	  echo '  <a href="javascript:naoGostei(' . $frase->cdFrase . ');"><i class="icon-thumbs-down"></i></a> ';
		      }
		      if ($dadosUsuarioLogado->cdTipo == 2) {
		      	  echo '&nbsp; <a href="javascript:excluir(' . $frase->cdFrase . ');">[excluir]</a>';
		      }
		      echo ' </div>';
	      }
	      echo '</fieldset>';
	  }
	  ?>
 	<!-- <a class="btn" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" rel="popover" href="#" data-original-title="Popover on top">Popover on top</a> -->	  
    </div> <!-- /container -->
    
    <!-- cadastro de frase -->
    
    <div id="cadastrarFrase" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <form class="form-horizontal" method="post" action="<?php echo site_url('/welcome/cadastrar/') ?>">
	 <div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	  <h3 id="myModalLabel">Cadastrar frase</h3>
	 </div>
	 <div class="modal-body">
	   <div class="control-group">
	    <label class="control-label" for="cdUsuario">Usu&aacute;rio</label>
		<div class="controls">
		 <select name="cdUsuario" id="cdUsuario">
		  <option value="">Selecione...</option>
		  <?php 
		  foreach ($listaUsuarios as $usuario) {
		  	   echo '<option value="' . $usuario->cdUsuario . '">' . $usuario->deNome . '</option>';
		  }
		  ?>
		 </select>
		</div>
	   </div>
	   <div class="control-group">
	    <label class="control-label" for="deAcao">A&ccedil;&atilde;o</label>
		<div class="controls">
		 <select name="deAcao" id="deAcao">
		  <option value="">Selecione...</option>
		  <option value="comenta em rela&ccedil;&atilde;o ao">comenta em rela&ccedil;&atilde;o ao</option>
		  <option value="declara para">declara para</option>
		  <option value="diz para">diz para</option>
		  <option value="exclama para">exclama para</option>
		  <option value="pede para">pede para</option>
		  <option value="pergunta para">pergunta para</option>
		 </select>
		</div>
	   </div>
	   <div class="control-group">
	    <label class="control-label" for="deParaQuem">Para quem</label>
		<div class="controls">
		 <select name="deParaQuem" id="deParaQuem">
		  <option value="">Selecione...</option>
		  <option value="todos">todos</option>
		  <?php 
		  foreach ($listaUsuarios as $usuario) {
		  	   echo '<option value="' . $usuario->deNome . '">' . $usuario->deNome . '</option>';
		  }
		  ?>
		 </select>
		</div>
	   </div>
	   <div class="control-group">
	    <label class="control-label" for="deFrase">Frase</label>
		<div class="controls">
		 <input type="text" class="input-xlarge" name="deFrase" id="deFrase">
		</div>
	   </div>
	   <div class="control-group">
	    <label class="control-label" for="dtRegistro">Data</label>
		<div class="controls">
		 <input type="text" class="input-small" name="dtRegistro" id="dtRegistro" value="<?php echo date('d/m/Y'); ?>" placeholder="dd/mm/aaaa">
		</div>
	   </div>
	 </div>
	 <div class="modal-footer">
	  <button class="btn btn-primary" onclick="javascript:return salvarFrase();">Salvar</button>
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
	 </div>
	 </form>
	</div>
	
	<!-- /cadastro de frase -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/teste/bootstrap/js/jquery.min.js"></script>
    <script src="/teste/bootstrap/js/bootstrap.min.js"></script>
    <script src="/teste/bootstrap/js/jquery.blockUI.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    	$('span[class^="badge"]').popover({
    		 html: "true",
    		 trigger: "hover",
    		 placement: "right"
        });
    });

    function showLoading() {
    	$.blockUI({ 
 			message: '<h3>Aguarde...</h3>',
        	css: { 
	            border: 'none', 
	            padding: '15px', 
	            backgroundColor: '#000', 
	            '-webkit-border-radius': '10px', 
	            '-moz-border-radius': '10px', 
	            opacity: .5, 
	            color: '#fff' 
	        } 
        }); 
    }

    function hideLoading() {
        $.unblockUI();
    }

    function gostei(cdFrase) {
    	showLoading();
        
    	$.ajax({
		    type: 'get',
		    data: '',
		    url:'/teste/index.php/welcome/votou/'+cdFrase,
		    success: function(retorno){
		        if (retorno != 0) {
		        	hideLoading();
					alert('Voce ja votou nesta frase!');
				} else {
			        $.ajax({
			    	    type: 'get',
			   		    data: '',
			   		    url:'/teste/index.php/welcome/gostei/'+cdFrase,
			   		    success: function(retorno){
			   		    	hideLoading();
				   			if (retorno) {
								$('#nrGostei_'+cdFrase).html(Number($('#nrGostei_'+cdFrase).html())+1);
				   			} else {
					   			alert('Ocorreu um erro ao tentar votar!');
				   			}
			    		}
			        });
				}
		    }
    	});
    }

    function naoGostei(cdFrase) {
    	showLoading();
    	
    	$.ajax({
		    type: 'get',
		    data: '',
		    url:'/teste/index.php/welcome/votou/'+cdFrase,
		    success: function(retorno){
		        if (retorno != 0) {
		        	hideLoading();
					alert('Voce ja votou nesta frase!');
				} else {
			        $.ajax({
			    	    type: 'get',
			   		    data: '',
			   		    url:'/teste/index.php/welcome/naoGostei/'+cdFrase,
			   		    success: function(retorno){
			   		    	hideLoading();
				   			if (retorno) {
				   				$('#nrNaoGostei_'+cdFrase).html(Number($('#nrNaoGostei_'+cdFrase).html())+1);
				   			} else {
				   				alert('Ocorreu um erro ao tentar votar!');
				   			}
			    		}
			        });
				}
		    }
    	});
    }

    function salvarFrase() {
		cdUsuario = $('#cdUsuario').val();

		if (cdUsuario == '') {
			alert('O campo USUARIO deve ser preenchido!');
			return false;
		}
		
		deAcao = $('#deAcao').val();

		if (deAcao == '') {
			alert('O campo ACAO deve ser preenchido!');
			return false;
		}
		
		deParaQuem = $('#deParaQuem').val();

		if (deParaQuem == '') {
			alert('O campo PARA QUEM deve ser preenchido!');
			return false;
		}
		
		deFrase = $('#deFrase').val();

		if (deFrase == '') {
			alert('O campo FRASE deve ser preenchido!');
			return false;
		} else {
			deFrase = escape(deFrase);
		}
		
		dtRegistro = $('#dtRegistro').val();

		if (dtRegistro == '') {
			alert('O campo DATA deve ser preenchido!');
			return false;
		} else {
			if (!validouData(dtRegistro)) {
				alert('A data informada nao e valida!');
			} else {
				dtRegistro = dtRegistro.replace(/\//g,"-"); 
			}
		}

        return true;
    }

    function validouData(data) {
		if (data.length != 10) {
			return false;
		}
		if (data.indexOf("/") != 2 && data.indexOf("/", 3) != 5) {
			return false;
		}

		return true;
    }

    function excluir(cdFrase) {
		if (confirm('Confirma a exclusao da frase?')) {
			window.location="<?php echo site_url('/welcome/excluir/') ?>/"+cdFrase; 
		}
    }
    </script>
    
  </body>
</html>