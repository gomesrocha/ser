<?php
	$bLogged = new Sessao("bLogged",false);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="../css/Principal.css" rel="stylesheet" type="text/css" />
    <link href="../css/StyleSheet.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../js/Mascara.js"></script>
</head>
<body>
    <form action="/ser/user/firstacess" method="POST">
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
                  
                </ul>
            </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /Header -->
    <!-- Main -->
    <div class="container-fluid"   >
        <div class="row">
            
            <!-- /col-3 -->
             <div class="col-sm-9" style ="left: 200px ">
                <!-- column 2 -->
                <ul class="list-inline pull-right">
                    <li><a href="#"><i class="glyphicon glyphicon-cog"></i></a></li>
                </ul>
                <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i>Primeiro Acesso</strong></a>
                <hr />
                <div class="row">
                    <div class="col-md-12" style= "margin-left: 0px">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-wrench pull-right"></i>
                                    <h4 id="head_pagina">
                                        Cadastrar Usuario</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="control-group col-md-7">
                                    <label>
                                        Nome</label>
                                    <div class="controls">
										<input type="text" name ="sUserName" autocomplete = "off"  class="form-control"/>
                                    </div>
                                </div>
								
                                <div class="control-group col-md-6">
                                    <label>
                                        Tipo de Usuario</label>
                                    <div class="controls">
                                        <select name = "sUserType"  class="form-control">
											
											<option value="gerente">Gerente de Projeto</option>
											<option value="keyUser">KeyUser</option>
											<option value="stakeholder">Stakeholder</option>
											<option value="analista">Analista</option>
											<option value="desenvolvedor">Desenvolvedor</option>
										</select>
                                        <br />
                                    </div>
                                </div>
                                 <div class="control-group col-md-4">
                                    <label>
                                        CPF</label>
                                    <div class="controls">
                                        <input type="text" name ="sUserCpf" autocomplete = "off" class="form-control" maxlength="14" id= "cpf" onKeyUp="formataCPF(cpf,event)" />
                                        <br />
                                    </div>
                                </div>
								</br>
								<div class="control-group col-md-3">
                                    <label>
                                        Email</label>
                                    <div class="controls">
                                        <input type="email" name ="sUserEmail" autocomplete = "off" class="form-control" />
                                        <br />
                                    </div>
                                </div>
								
								<div class="control-group col-md-3">
                                    <label>
                                        Senha</label>
                                    <div class="controls">
                                        <input type="password" name ="sUserPassword" autocomplete = "off" class="form-control" />
                                        <br />
                                    </div>
                                </div>
								
								<div class="controls">
                                        <div class="control-group col-md-12">
                                   
											<div class="controls">
												<input type="submit" name = "btnAdd" class="btn btn-success" value="Cadastrar"/>
												<input type="submit" name = "btnVoltar" class="btn btn-primary" value="Voltar"/>
											</div>
										</div>
                                </div>
								</div>
                            </div>
                            <br />
                            <br />
                    
							
                            </div>
                            <!--/panel content-->
                        </div>
                        <!--/panel-->
                    </div>
    </div>
    <!-- /Main -->
    <footer class="text-center">Desenvolvido por <strong>Luis Antonio dos Santos Silva / GPITIC</strong>.</footer>
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