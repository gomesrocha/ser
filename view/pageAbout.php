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
    <form action="/ser/user/about" method="POST">
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
                <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i>Sobre</strong></a>
                <hr />
                <div class="row">
                    <div class="col-md-12" style= "margin-left: 0px">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-wrench pull-right"></i>
                                    <h4 id="head_pagina">
                                        Sobre O Sistema</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="control-group col-md-12">
                                   <p>
										De acordo com o estudo do PMI (Project Management Institute) Pulse of the Profession (<a href ="https://www.pmi.org/learning/thought-leadership/pulse/the-high-cost-of-low-performance-2014" style="text-decoration:none"> https://www.pmi.org/learning/thought-leadership/pulse/the-high-cost-of-low-performance-2014 </a>) do ano de 2014, 
										37% das organizações afirmaram que as falhas em seus projetos tiveram origem em um mau levantamento de requisitos.
										O SER – Sistema de Engenharia de Requisitos é uma reestruturação de um sistema criado em 2010. É opensource e está
										disponível no gitHub em <a href ="https://github.com/gomesrocha/ser" style="text-decoration:none">https://github.com/gomesrocha/ser</a>. Tem como caracteristicas:</br></br>
										<ul style="list-style-type:square">
											<li>Feito com PHP 5.6 e banco de dados Mysql</li>
											<li>Multiusuário</li>
											<li>Multiplataforma</li>
											<li>Elicitar, validar e gerenciar requisitos que são listados e aprovados pelo keyUser, bem como o gerenciamento de projetos.</li>
										</ul>
										E tem como objetivo diminuir ou evitar problemas como estes por causa dos requisitos:</br></br>
										<ul style="list-style-type:square">
											<li>Orçamento fora do limite</li>
											<li>Projeto não atende o escopo do projeto</li>
											<li>Projeto fora do prazo</li>
											<li>Redução ou eliminação de ruídos na comunicação entre gerente, analista, keyUser, desenvolvedor e nonKeyUser</li>
										</ul>
								   </p>
								   
								   <div class="controls">
                                        <div class="control-group col-md-12">
                                   
											<div class="controls">
												<input type="submit" name = "btnVoltar" class="btn btn-primary" value="Voltar"/>
											</div>
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