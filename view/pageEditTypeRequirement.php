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
	<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
</head>
<body>
    <form action="/ser/requirement/updatetyperequirement" method="post">
		<?php
			$oEditTypeRequirement = TypeRequirement::findEditTypeRequirement(); 
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
						    <li class="active"><a href="pagedefaultanalyst"><i class="glyphicon glyphicon-home"></i> Home</a></li>
                            <li class="active"><a href="pageaddtyperequirement"><i class="glyphicon glyphicon-folder-open"></i> Tipo de Requisito</a></li>
                            <li><a href="pageaddrequirement"><i class="glyphicon glyphicon-list-alt"></i> Requisito</a></li>
							<li><a href="pageaddactor"><i class="glyphicon glyphicon-user"></i> Ator</a></li>
							<li><a href="pageadddiagram"><i class="glyphicon glyphicon-pencil"></i> Diagrama</a></li>
							<li><a href="pageaddusecase"><i class="glyphicon glyphicon-tasks"></i> Caso de Uso</a></li>
                        </ul>
                    </li>
                    <hr />
                    
                    <hr />
                    <li class="nav-header">
                        <h5>
                            Gerenciar <i class="glyphicon glyphicon-chevron-down"></i>
                        </h5>
                    
                        <ul class="list-unstyled collapse in" id="Ul1">
                            <li><a href="pagevisualizetyperequirement"><i class="glyphicon glyphicon-folder-open"></i> Tipo de Requisito</a></li>
                            <li><a href="pagevisualizerequirement"><i class="glyphicon glyphicon-list-alt"></i>Requisito </a></li>
							<li><a href="pagevisualizeactor"><i class="glyphicon glyphicon-user"></i> Ator</a></li>
							<li><a href="pagevisualizediagram"><i class="glyphicon glyphicon-pencil"></i> Diagrama</a></li>
							<li><a href="pagevisualizeusecase"><i class="glyphicon glyphicon-tasks"></i> Caso de Uso</a></li>
                        </ul>
                    </li>
					
					<hr />
                    
                    <hr />
					  <li class="nav-header">
                        <h5>
                            Relatorios <i class="glyphicon glyphicon-chevron-down"></i>
                        </h5>
                    
                       <ul class="list-unstyled collapse in" id="Ul1">
                            <li><i class="glyphicon glyphicon-folder-open"></i>  Tipos de Requisito</li>
							
								<ul>
									<li><a href="/ser/requirement/createallreporttyperequirement"><i class="glyphicon glyphicon-print"></i> Todos Os Tipos  </a></li>
									
								</ul>
                            <li><i class="glyphicon glyphicon-list-alt"></i>  Requisito</li>
								<ul>
									<li><a href="/ser/requirement/createallreportrequirement"><i class="glyphicon glyphicon-print"></i> Todos os Requisitos </a></li>
									<li><a href="/ser/requirement/pagereportprojectrequirement"><i class="glyphicon glyphicon-print"></i> Requisitos Por Projeto </a></li>
									<li><a href="/ser/requirement/pagereportrequirementtyperequirement"><i class="glyphicon glyphicon-print"></i> Requisitos Por Tipo de Requisito </a></li>
									<li><a href="/ser/requirement/pagereportstartdaterequirement"><i class="glyphicon glyphicon-print"></i> Requisitos Por Data De Inicio </a></li>
									<li><a href="/ser/requirement/pagereportfinishdaterequirement"><i class="glyphicon glyphicon-print"></i> Requisitos Por Data De Fim </a></li>
									<li><a href="/ser/requirement/pagereportrequirementperiod"><i class="glyphicon glyphicon-print"></i> Requisitos Por Data Periodo </a></li>
									<li><a href="/ser/requirement/pagereportimportancerequirement"><i class="glyphicon glyphicon-print"></i> Requisitos Por Importancia </a></li>
									<li><a href="/ser/requirement/pagereportsituationrequirement"><i class="glyphicon glyphicon-print"></i> Requisitos Por Situacao </a></li>
								</ul>
							<li><i class="glyphicon glyphicon-user"></i> Ator</li>
								<ul>
									<li><a href="/ser/actor/createallreportactors"><i class="glyphicon glyphicon-print"></i> Todos os Atores </a></li>
								</ul>
							
							<li><i class="glyphicon glyphicon-pencil"></i> Diagrama</li>
								<ul>
									<li><a href="/ser/diagram/createallreportdiagram"><i class="glyphicon glyphicon-print"></i> Todos os Diagramas </a></li>
									<li><a href="/ser/diagram/pagereportdiagramproject"><i class="glyphicon glyphicon-print"></i> Diagramas Por Projeto </a></li>
								</ul>
								
                            <li><i class="glyphicon glyphicon-tasks"></i> Caso De Uso</li>
							<ul>
									<li><a href="/ser/usecase/createallreportusecase"><i class="glyphicon glyphicon-print"></i> Todos os Casos de Uso </a></li>
									<li><a href="/ser/usecase/pagereportusecasediagram"><i class="glyphicon glyphicon-print"></i> Casos de Uso Por Diagrama </a></li>
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
                <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i>Tipos de Requisito</strong></a>
                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-wrench pull-right"></i>
                                    <h4 id="head_pagina">
                                        Editar Tipo de Requisito</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="control-group col-md-7">
                                    <label>
                                        Tipo de Requisito</label>
                                    <div class="controls">
										<input type="text" name ="sRequirementName" required class="form-control" autocomplete = "off" value= "<?= $oEditTypeRequirement['nomeTipoRequisito']?>"/>
                                    </div>
                                </div>
                                 <div class="control-group col-md-6">
                                    <label>
                                        Obs </label>
                                    <div class="controls">
                                       <textarea class="ckeditor" rows="12" cols="61" autocomplete = "off" required  name ="sRequirementObs" ><?= $oEditTypeRequirement['obsTipoRequisito']?> </textarea>
                                        <br />
                                    </div>
                                </div>
								</br>
								</br>
				
                                    <div class="controls">
                                        <div class="control-group col-md-12">
                                   
											<div class="controls">
												<input type="submit" name = "btnUpdate" class="btn btn-primary" value="Alterar"/>
									
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