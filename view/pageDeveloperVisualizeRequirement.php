<?php
	$sUserName = new Sessao();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="../css/Principal.css" rel="stylesheet" type="text/css" />
    <link href="../css/StyleSheet.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/Mascara.js"></script>
	<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
	
</head>
<body>
    <form action="/ser/requirement/situationupdaterequirement" method="post">
		<?php
			$aAllTypeRequirement = TypeRequirement::allTypeRequirement();
			$aAllProject = Project::allUserProject();
			$aRequirement = Requirement::findDeveloperRequirement();
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
						    <li class="active"><a href="pagedefaultdeveloper"><i class="glyphicon glyphicon-home"></i> Home</a></li>
                        </ul>
                    </li>
                    <hr />
                    
                    <hr />
                    <li class="nav-header">
                        <h5>
                            Visualizar <i class="glyphicon glyphicon-chevron-down"></i>
                        </h5>
                    
                        <ul class="list-unstyled collapse in" id="Ul1">
                            <li><a href="pagedevelopervisualizeproject"><i class="glyphicon glyphicon-list-alt"></i> Consultar Requisitos Aprovados</a></li>
                        </ul>
                    </li>
					
					<hr />
                    
                    <hr />
					
					<li class="nav-header">
                        <h5>
                            Relatorios <i class="glyphicon glyphicon-chevron-down"></i>
                        </h5>
                    
                        <ul class="list-unstyled collapse in" id="Ul1">
                            <li><i class="glyphicon glyphicon-list-alt"></i> Requisitos</li>
							
								<ul>
									<li><a href="pagereportapprovedrequirement"><i class="glyphicon glyphicon-print"></i> Requisitos Aprovados Por Projeto </a></li>
									
								</ul>
						</ul>
                    </li>					
                </ul>					                
            </div>
            <!-- /col-3 -->
            <div class="col-sm-9">
                <!-- column 2 -->
                <ul class="list-inline pull-right">
                    <li><a href="#"><i class="glyphicon glyphicon-cog"></i></a></li>
                </ul>
                <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i>Requisito</strong></a>
                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-wrench pull-right"></i>
                                    <h4 id="head_pagina">
                                        Consultar Requisitos Aprovados</h4>
                                </div>
                            </div>
                            <div class="panel-body">
							   <div class="control-group col-md-6">
                                    <label>
                                        Tipo do Requisito</label>
                                    <div class="controls">
                                        <select name = "iRequirementType" class="form-control" readonly="true">
											<?php
												foreach($aAllTypeRequirement as $oTypeRequirement)
												{
											?>		
											<option  <?php echo $aRequirement['TipoRequisito_idTipoRequisito'] == $oTypeRequirement['idTipoRequisito'] ? 'selected':'';?> value="<?= $oTypeRequirement['idTipoRequisito']?>"> <?= $oTypeRequirement['nomeTipoRequisito']?></option>
											<?php
												}
											?>

										</select>
                                        <br />
                                    </div>
                                </div>
								
								  <div class="control-group col-md-4">
                                    <label>
                                        Projeto</label>
                                    <div class="controls">
                                        <select name = "iRequirementProject" class="form-control"  readonly="true">
											
											<?php
												foreach($aAllProject as $oProject)
												{
											?>		
											 <option  <?php echo $aRequirement['Projeto_idProjeto'] == $oProject['idProjeto'] ? 'selected':'';?> value="<?= $oProject['idProjeto']?>"> <?= $oProject['nomeProjeto']?></option>
											<?php
												}
											?>

										</select>
                                        <br />
                                    </div>
                                </div>
                                <div class="control-group col-md-6">
                                    <label>
                                        Nome do Requisito</label>
                                    <div class="controls">
                                        <input type="text"   name = "sRequirementName" required class="form-control"  readonly="true" value ='<?php echo $aRequirement['nomeRequisito'] ?>' />
											
                                        <br />
                                    </div>
                                </div>
								<div class="control-group col-md-4">
                                    <label>
                                        Data de Inicio</label>
                                    <div class="controls">
                                        <input type="text" readonly="true"  name = "sRequirementDateStart" required   class="form-control" value ='<?php echo $aRequirement['dataInicioRequisito'] ?>'/>
											
                                        <br />
                                    </div>
                                </div>
								
								<div class="control-group col-md-4">
                                    <label>
                                        Data de Termino</label>
                                    <div class="controls">
                                        <input type="text"   name = "sRequirementDateFinish" required class="form-control"  readonly="true" value ='<?php echo $aRequirement['dataTerminoRequisito'] ;?>' />							
                                        <br />
                                    </div>
                                </div>
								
								<div class="control-group col-md-4">
                                    <label>
                                       Importancia</label>
                                   <div class="controls">
                                        <select name = "sImportanceRequirement" class="form-control"  readonly="true">
											 <option value='Baixa' <?php echo $aRequirement["importanciaRequisito"]=='Baixa'?'selected':'';?>>Baixa</option>
											 <option value='Media' <?php echo $aRequirement["importanciaRequisito"]=='Media'?'selected':'';?>>Media</option>
											 <option value='Alta' <?php echo $aRequirement["importanciaRequisito"]=='Alta'?'selected':'';?>>Alta</option>
										</select>
                                        <br />
                                    </div>
                                </div>
								<div class="control-group col-md-4">
                                    <label>
                                        Situacao</label>
                                    <div class="controls">
                                        <select name = "sRequirementSituation" readonly="true" autocomplete = "off" class="form-control">
											
											<option value="avaliacao" <?php echo $aRequirement["situacaoRequisito"]=='avaliacao'?'selected':'';?>>Avaliação</option>
											<option value="aprovado" <?php echo $aRequirement["situacaoRequisito"]=='aprovado'?'selected':'';?>>Aprovado</option>
											<option value="desenvolvimento" <?php echo $aRequirement["situacaoRequisito"]=='desenvolvimento'?'selected':'';?>>Desenvolvimento</option>
											<option value="atrasado" <?php echo $aRequirement["situacaoRequisito"]=='atrasado'?'selected':'';?>>Atrasado</option>
											<option value="finalizado" <?php echo $aRequirement["situacaoRequisito"]=='finalizado'?'selected':'';?>>Finalizado</option>
										</select>
                                        <br />
                                    </div>
                                </div>
								 <div class="control-group col-md-6">
                                    <label>
                                        Descricao</label>
                                    <div class="controls">
                                         <textarea class="ckeditor" rows="12" cols="61" required  name ="sDescriptionRequirement"  readonly="true" > <?php echo $aRequirement["descricaoRequisito"]?></textarea>
											
                                        <br />
                                    </div>
                                </div>
								
                                    <br />
									 
									<br/>
                                    <br />
									<br/>
									
                                    <div class="controls">
                                        <div class="control-group col-md-12">
                                   <br/>
											<div class="controls">
												<a href="/ser/login/pagedevelopervisualizeproject"> << Voltar </a>
									
										</div>
                                    </div>
                                </div>
                            </div>
                            <!--/panel content-->
                        </div>
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