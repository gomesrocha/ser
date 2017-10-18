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
	<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
</script>
</head>
<body>
    <form action="/ser/task/updatetask" method="post">
		<?php
			$oTask 		 = Task::findEditTask(); 
			$aAllProject = Project::allUserProject();
			$aAllUser 	 = User::allUser();
			$aAllTask	 = Task::allTaskDepEdit();
			$aAllProjectManager = Project::allProject();
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
						    <li class="active"><a href="/ser/login/pagedefaultmanager"><i class="glyphicon glyphicon-home"></i> Home</a></li>
                            <li class="active"><a href="/ser/login/pageaddproject"> <i class="glyphicon glyphicon-folder-open"></i>  Projetos</a></li>
                            <li><a href="/ser/login/pageadduser"><i class="glyphicon glyphicon-user"></i> Usuarios</a></li>
                            <li><a href="/ser/login/pageaddtask"><i class="glyphicon glyphicon-file"></i> Tarefas</a></li>
							<li><a href="/ser/login/pagelinkproject"><i class="glyphicon glyphicon-link"></i> Vincular Usuario a Projeto</a></li>
                        </ul>
                    </li>
                    <hr />
                    
                    <hr />
                    <li class="nav-header">
                        <h5>
                            Gerenciar <i class="glyphicon glyphicon-chevron-down"></i>
                        </h5>
                    
                        <ul class="list-unstyled collapse in" id="Ul1">
                            <li><a href="/ser/login/pagevisualizeproject"><i class="glyphicon glyphicon-folder-open"></i> Projetos</a></li>
                            <li><a href="/ser/login/pagevisualizeuser"><i class="glyphicon glyphicon-user"></i> Usuarios </a></li>
                            <li><a href="/ser/login/pagevisualizetask"><i class="glyphicon glyphicon-file"></i> Tarefas</a></li>
							<li><a href="/ser/login/pageremovelinkproject"><i class="glyphicon glyphicon-scissors"></i> Desvincular Usuario ao Projeto</a></li>
							<li><a href="/ser/login/pagevisualizeliftingmanager"><i class="glyphicon glyphicon-eye-open"></i> Acompanhar Aprovacoes</a></li>
							
                        </ul>
                    </li>
					
					<hr />
                    
                    <hr />
					  <li class="nav-header">
                        <h5>
                            Relatorios <i class="glyphicon glyphicon-chevron-down"></i>
                        </h5>
                    
                        <ul class="list-unstyled collapse in" id="Ul1">
                            <li><i class="glyphicon glyphicon-folder-open"></i> Projetos</li>
							
								<ul>
									<li><a href="/ser/project/createallreportprojects"><i class="glyphicon glyphicon-print"></i> Todos Os Projetos </a></li>
									<li><a href="/ser/project/pagereportstatusprojects"><i class="glyphicon glyphicon-print"></i> Projetos Por Situacao </a></li>
									<li><a href="/ser/project/pagereportmanagerprojects"><i class="glyphicon glyphicon-print"></i> Projetos Por Gerente </a></li>
									<li><a href="/ser/project/pagereportprojectdatestart"><i class="glyphicon glyphicon-print"></i> Projetos Por Inicio </a></li>
									<li><a href="/ser/project/pagereportprojectdatefinish"> <i class="glyphicon glyphicon-print"></i> Projetos Por Termino </a></li>
									<li><a href="/ser/project/pagereportprojectperiod"><i class="glyphicon glyphicon-print"></i> Projetos Por Periodo </a></li>
								</ul>
                            <li><i class="glyphicon glyphicon-user"></i> Usuarios</li>
								<ul>
									<li><a href="/ser/user/createallreportusers"><i class="glyphicon glyphicon-print"></i> Todos os Usuarios </a></li>
									<li><a href="/ser/user/pagereportusertype"><i class="glyphicon glyphicon-print"></i> Usuarios Por Tipo </a></li>
									<li><a href="/ser/user/pagereportdateinclusionusers"><i class="glyphicon glyphicon-print"></i> Usuarios Por Data De Inclusão </a></li>
									<li><a href="/ser/user/createallreportlinkusers"><i class="glyphicon glyphicon-print"></i> Usuarios Vinculados </a></li>
									<li><a href="/ser/user/pagereportlinkusersproject"><i class="glyphicon glyphicon-print"></i> Usuarios Vinculados Por Projeto </a></li>
									<li><a href="/ser/user/createallreportnotlinkusers"><i class="glyphicon glyphicon-print"></i> Usuarios Não Vinculados </a></li>
								</ul>
                            <li><i class="glyphicon glyphicon-file"></i> Tarefas</li>
							<ul>
									<li><a href="/ser/task/createallreporttasks"><i class="glyphicon glyphicon-print"></i> Todos as Tarefas </a></li>
									<li><a href="/ser/task/pagereporttaskprojects"><i class="glyphicon glyphicon-print"></i> Tarefas Por Projeto </a></li>
									<li><a href="/ser/task/pagereporttaskusers"><i class="glyphicon glyphicon-print"></i> Tarefas Por Usuario </a></li>
									<li><a href="/ser/task/pagereporttaskdatestart"> <i class="glyphicon glyphicon-print"></i> Tarefas Por Inicio </a></li>
									<li><a href="/ser/task/pagereporttaskdatefinish"><i class="glyphicon glyphicon-print"></i> Tarefas Por Termino </a></li>
									<li><a href="/ser/task/pagereporttaskperiod"><i class="glyphicon glyphicon-print"></i> Tarefas Por Periodo </a></li>
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
                <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i>Tarefas</strong></a>
                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-wrench pull-right"></i>
                                    <h4 id="head_pagina">
                                        Editar Tarefa</h4>
                                </div>
                            </div>
                            <div class="panel-body">
							    <div class="control-group col-md-6">
                                    <label>
                                        Nome do Projeto</label>
                                    <div class="controls">
                                        <select id="projectId" name = "sProjectId" class="form-control">
											
											<?php
												foreach($aAllProject as $oProject )
												{
											?>
											 
											<option  <?php echo $oProject['idProjeto'] == $oTask['Projeto_idProjeto'] ? 'selected':'';?> value="<?=$oProject['idProjeto']?>"> <?= $oProject['nomeProjeto']?></option>
											<?php
												}
												foreach($aAllProjectManager as $oProject )
												{
											?>
											 
											
													<option  <?php echo $oProject['idProjeto'] == $oTask['Projeto_idProjeto'] ? 'selected':'';?> value="<?=$oProject['idProjeto']?>"> <?= $oProject['nomeProjeto']?></option>
											<?php
												}
												
											?>
										</select>
                                        <br />
                                    </div>
                                </div>
                                <div class="control-group col-md-7">
                                    <label>
                                        Nome do Responsável</label>
                                    <div class="controls">
										<select id="userName" name = "sUserId" class="form-control">
											
												<?php
												
													foreach($aAllUser as $oUser )
													{
												?>
												<option  <?php echo $oUser['idUsuario'] == $oTask['Usuario_idUsuario'] ? 'selected':'';?> value="<?=$oUser['idUsuario']?>"> <?=$oUser['nomeUsuario']?></option>
								
												<?php
													}
												?>
										</select>
                                    </div>
                                </div>
								
								 <div class="control-group col-md-4">
                                    <label>
                                        Nome da Tarefa</label>
                                    <div class="controls">
                                          <input type="text" name = "sTaskName" required autocomplete = "off" class="form-control" value="<?php echo $oTask["nomeTarefa"] ?>"/>
                                        <br />
                                    </div>
                                </div>
                                <div class="control-group col-md-4">
                                    <label>
                                        Data de Inicio</label>
                                    <div class="controls">
                                        <input type="text" readonly="true"  name = "sTaskDateStart" autocomplete = "off" required class="form-control" value='<?php echo $oTask["dataInicioTarefa"] ?>'/>
											
                                        <br />
                                    </div>
                                </div>
								
								 <div class="control-group col-md-4">
                                    <label>
                                        Data de Termino</label>
                                    <div class="controls">
                                        <input type="text" name = "sTaskDateConclusion" autocomplete = "off" maxlength="10" id= "dataTermino" onKeyUp="formataData(dataTermino,event)" required class="form-control"   value = '<?php echo $oTask['dataTerminoTarefa'] ;?>'/>
											
                                        <br />
                                    </div>
                                </div>
								
                                 <div class="control-group col-md-6">
                                    <label>
                                       Observacao</label>
                                    <div class="controls">
                                       <textarea class="ckeditor" rows="12" cols="61" required  autocomplete = "off" name ="sTaskObs"><?php echo $oTask["obsTarefa"]; ?> </textarea>
                                        <br />
                                    </div>
                                </div>
								</br>
								</br>
								
								<div class="control-group col-md-6">
                                    <label>
                                        Tarefa Dependente</label>
                                    <div class="controls">
                                       <select name = "sTaskNameDepend" class="form-control">
											<option value="" selected></option>
											<?php
												
												foreach($aAllTask as $oTaskDep)
												{
													
											?>
											<option  <?php echo $oTask['Tarefa_idTarefa'] == $oTaskDep['idTarefa'] ? 'selected':'';?> value="<?=$oTaskDep['idTarefa']?>"> <?=$oTaskDep['nomeTarefa']?></option>
											<?php										
												}
											?>
										</select>
                                        <br />
                                    </div>
                                </div>
                                    <br />
                                    <br />
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