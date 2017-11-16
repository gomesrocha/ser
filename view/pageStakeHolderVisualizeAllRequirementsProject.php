<?php
	$sUserName = new Sessao();
	$aAllRequirement = new Sessao();
	$aAllRequirementProject = $aAllRequirement->getSessao("allRequirements");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="../css/Principal.css" rel="stylesheet" type="text/css" />
    <link href="../css/StyleSheet.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
</head>
<body>
    <form action="" method="post">
		<?php
			$aAllTypeRequirement	= TypeRequirement::allTypeRequirement();
			$aAllProject 			= Project::allProject();
		?>
     <div id="top-nav" class="navbar navbar-inverse navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar">
                    </span>
                </button>
                <p class="navbar-brand" >SER - Sistema De Engenharia de Requisitos</p>
            </div> 
		
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown"><a  role="button" 
                        ><i class="glyphicon glyphicon-user"></i><?php echo $sUserName->getSessao("sUserName");?> 
                    </a>
                        <ul id="g-account-menu" class="dropdown-menu" role="menu">
                            <li><a href="#">My Profile</a></li>
                        </ul>
                    </li>
                    <li><a href="/ser/login/deslogar">Logout</a></li>
                </ul>
            </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /Header -->
    <!-- Main -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <!-- Left column -->
                <hr />
                <ul class="list-unstyled">
                    <li class="nav-header">
                        <h5>
                            Cadastros 
                        </h5>
                    
                        <ul class="list-unstyled collapse in" id="userMenu">
						    <li class="active"><a href="/ser/login/pagedefaultstakeholder"><i class="glyphicon glyphicon-home"></i> Home</a></li>
                        </ul>
                    </li>
                    <hr />
                    
                    <hr />
                    <li class="nav-header">
                        <h5>
                            Visualizar <i class="glyphicon glyphicon-chevron-down"></i>
                        </h5>
                    
                        <ul class="list-unstyled collapse in" id="Ul1">
                            <li><a href="/ser/login/pagevisualizeliftingstakeholder"><i class="glyphicon glyphicon-eye-open"></i>Acompanhar Levantamento</a></li>
                        </ul>
                    </li>
					
					<hr />
                    
                    <hr />
					
                </ul>
            </div>
			
			 <!-- /col-3 -->
            <div class="col-sm-9">
                <!-- column 2 -->
                <ul class="list-inline pull-right">
                    <li><a href="#"><i class="glyphicon glyphicon-cog"></i></a></li>
                </ul>
                
                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-wrench pull-right"></i>
                                    <h4 id="head_pagina">
                                        VISUALIZAR REQUISITOS</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="control-group col-md-10" >
                                    <table border="1" class="table">

			<tr>
				<th colspan="10" align="center">REQUISITOS</th>
			</tr>
			
			<tr>
				<td  align="center">ID</td>
				<td  align="center">Tipo</td>
				<td  align="center">Projeto</td>
				<td  align="center">Nome </td>
				<td  align="center">Descricao</td>
				<td  align="center">Data de Inicio</td>
				<td  align="center">Data de Termino</td>
				<td  align="center">Importancia</td>
				<td  align="center">Situacao</td>
			</tr>

			<tr>

				<?php
				    if(!empty($aAllRequirementProject))
				    {
						foreach ($aAllRequirementProject as $oRequirement) 
						{
							$oVisualizeTypeRequirement = TypeRequirement::findTypeRequirement($oRequirement['tipoRequisito_idTipoRequisito']);
							$oVisualizeProject = Project::findProject($oRequirement['projeto_idProjeto']);
				?>	
							<tr>
								<td align="center"> <?= $oRequirement['idRequisito'];?> </td>
								<td align="center"> <?= $oVisualizeTypeRequirement['nomeTipoRequisito'];?> </td>
								<td align="center"> <?= $oVisualizeProject['nomeProjeto'];?> </td>
								<td align="center"> <?= $oRequirement['nomeRequisito'];?> </td>
								<td align="center"> <?= $oRequirement['descricaoRequisito'];?> </td>
								<td align="center"> <?= $oRequirement['dataInicioRequisito'];?> </td>
								<td align="center"> <?= $oRequirement['dataTerminoRequisito'];?> </td>
								<td align="center"> <?= $oRequirement['importanciaRequisito'];?> </td>
								<td align="center"> <?= $oRequirement['situacaoRequisito'];?> </td>
							</tr>
				<?php
								
						}
					}
				?> 			
		 	</tr>
		</table>                                    
                                </div>
                                
                            <!--/panel content-->
                        </div>
						
						<!-- Small modal -->




                        <!--/panel-->
                    </div>
                    <!--/col-span-12-->
                </div>
                <!--/row-->
                <hr />
            </div>
            <!--/col-span-9-->
        </div>
    </div>
    <!-- /Main -->
    <footer class="text-center">Desenvolvido Por <strong> Luis Antonio dos Santos Silva / GPITIC</strong>.</footer>
    <div class="modal" id="addWidgetModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        Ã—</button>
                    <h4 class="modal-title">
                        Add Widget</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Add a widget stuff here..</p>
                </div>
                <div class="modal-footer">
                    <a href="#" data-dismiss="modal" class="btn">Close</a> <a href="#" class="btn btn-primary">
                        Save changes</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dalog -->
    </div>
    <!-- /.modal -->
    <!-- script references -->
    </form>
</body>
</html>
			
			
          