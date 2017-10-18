<?php
	
	class Task
	{
		private $iTaskProjectId;
		private $iTaskUserId;
		private $iTaskPend;
		private $sTaskName;
		private $dTaskFinishDate;
		private $dTaskStartDate;
		private $sTaskObs;
		
		function __construct($iTaskProjectId,$iTaskUserId,$dTaskStartDate,$sTaskName,$dTaskFinishDate,$sTaskObs = null,$iTaskPend = null)
		{
			$this->iTaskProjectId 	= $iTaskProjectId;
			$this->iTaskUserId 		= $iTaskUserId;
			$this->sTaskName 		= $sTaskName;
			$this->dTaskStartDate 	= $dTaskStartDate;
			$this->dTaskFinishDate	= $dTaskFinishDate;
			$this->sTaskObs 		= $sTaskObs;
			$this->iTaskPend 		= $iTaskPend;
		}
		
		public function getTaskProjectId()
		{
			return $this->iTaskProjectId;
		}
		
		public function getTaskUserId()
		{
			return $this->iTaskUserId;
		}
		
		public function getTaskName()
		{
			return $this->sTaskName;
		}
	
		public function getTaskStartDate()
		{
			return $this->dTaskStartDate;
		}
		
		public function getTaskFinishDate()
		{
			return $this->dTaskFinishDate;
		}
		
		public function getTaskObs()
		{
			return $this->sTaskObs;
		}
		
		public function getTaskPend()
		{
			return $this->iTaskPend;
		}

		public function setTaskProjectId($iTaskProjectId)
		{
			$this->iTaskProjectId = $iTaskProjectId;
		}
		
		public function setTaskUserId($iTaskUserId)
		{
			$this->iTaskUserId = $iTaskUserId;
		}
		
		public function setTaskName($sTaskName)
		{
			$this->sTaskName = $sTaskName;
		}

		public function setTaskStartDate($dTaskStartDate)
		{
			$this->dTaskStartDate = $dTaskStartDate;
		}
		
		public function setFinishDate($dFinishDate)
		{
			$this->dFinishDate = $dFinishDate;
		}

		public function setTaskDetails($sTaskDetails)
		{
			$this->sTaskDetails = $sTaskDetails;
		}
		
		public function setTaskPend($iTaskPend)
		{
			$this->iTaskPend = $iTaskPend;
		}
		
		public static function allUserTask()
		{
			$iIdUser = new Sessao();
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT *
					FROM tarefa t, projeto p
						WHERE t.Projeto_idProjeto = p.idProjeto AND p.Usuario_idUsuario= ? ";
			$ArrayParam = [$iIdUser->getSessao("iIdUser")];
			$aAllTask = $rDatabaseHandler->query($sQuery,$rConnection,$ArrayParam,true);	
			return $aAllTask;
		}
		
		public static function allTask()
		{
		
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM tarefa t order by idTarefa ";
			$aAllTask = $rDatabaseHandler->query($sQuery,$rConnection,null,true);	
			return $aAllTask;
		}
		public static function allTaskDepEdit()
		{
			$iEdit = new Sessao();
			$iId = $iEdit->getSessao("editTask"); 
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT nomeTarefa,idTarefa FROM tarefa  WHERE idTarefa <> ? order by nomeTarefa   ";
			$aArrayParam = [$iId];
			$aAllTask = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);	
			return $aAllTask;
		}
		
		public static function depTask($iIdDepTask)
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT nomeTarefa FROM tarefa WHERE idTarefa = ?";
			$aArrayParam = [$iIdDepTask];
			$sNameTask = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $sNameTask;
		}
		
		public static function researchTaskExist($oAddTask)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM tarefa WHERE nomeTarefa = ? ";
				$aArrayParam = [$oAddTask->getTaskName()];
				$aExistTask = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
				if (!empty($aExistTask))
				{
					echo "<script> 
									alert('Tarefa Ja Foi Cadastrada !!!');
									window.location.href = '/ser/login/pageaddtask';
						 </script>";
				}
			}
			catch(PDOException $e)
			{
				echo "Erro: ".$e->getMessage();
			}
		}
		
		public static function addTask($oTask)
		{
			self::researchTaskExist($oTask);
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "INSERT INTO tarefa(Projeto_idProjeto,Usuario_idUsuario,nomeTarefa,dataInicioTarefa,
											  dataTerminoTarefa,obsTarefa,Tarefa_idTarefa) 
										VALUES (?,?,?,?,?,?,?) ";
						
				if(!empty($oTask->getTaskPend()))
				{
					$aArrayParam = [$oTask->getTaskProjectId(),$oTask->getTaskUserId(),
									$oTask->getTaskName(),$oTask->getTaskStartDate(),
									$oTask->getTaskFinishDate(),$oTask->getTaskObs(),$oTask->getTaskPend()];
				}
				else
				{
					$aArrayParam = [$oTask->getTaskProjectId(),$oTask->getTaskUserId(),
									$oTask->getTaskName(),$oTask->getTaskStartDate(),
									$oTask->getTaskFinishDate(),$oTask->getTaskObs(),null];
				}
				$rDatabaseHandler->add($sQuery,$rConnection,$aArrayParam);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				$aUser = User::findUser($oTask->getTaskUserId());
				$aProject = Project::findProject($oTask->getProjectId());
				$sUserName = new Sessao();
				self::sendEmail($aUser["emailUsuario"],$sUserName->getSessao("sUserName"),"Tarefa do Projeto ".$aProject['nomeProjeto'],'Olá !!! Há uma nova tarefa para você vinculada ao projeto '.$aProject['nomeProjeto'].'. Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)');
				echo "<script> 
							alert('Cadastro Feito Com Sucesso !!!');
							window.location.href = '/ser/login/pageaddtask';
					  </script>";
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Cadastrar: ".$e->getMessage();
			}
		}
		
		public static function findEditTask()
		{
			try
			{
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editTask");
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM tarefa WHERE idTarefa = ? ";
				$aArrayParam = [$iId];
				$aTaskEdit = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (empty($aTaskEdit))
				{
					echo "<script> 
							alert('Tarefa Não Encontrada !!!');
							window.location.href = '/ser/login/pagevisualizetask';
					  </script>";
				
				}
				return $aTaskEdit;
			
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		public static function findTask($iIdTask)
		{
			try
			{
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editTask");
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM tarefa WHERE idTarefa = ? ";
				$aArrayParam = [$iIdTask];
				$aTask = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (empty($aTask))
				{
					echo "<script> 
							alert('Tarefa Não Encontrada !!!');
							window.location.href = '/ser/login/pagevisualizetask';
					  </script>";
				
				}
				return $aTask;
			
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		public static function updateTask($oTask)
		{
			try
			{   
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editTask"); 
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "UPDATE tarefa SET 
										   Projeto_idProjeto = ?,
						       			   Usuario_idUsuario =?,
						       			   nomeTarefa = ?,
										   dataInicioTarefa = ?,
										   dataTerminoTarefa = ?,
										   obsTarefa = ?,
										   Tarefa_idTarefa = ?
								where idTarefa = ? ";
				if(!empty($oTask->getTaskPend()))
				{
					$aArrayParam = [$oTask->getTaskProjectId(),$oTask->getTaskUserId(),
									$oTask->getTaskName(),$oTask->getTaskStartDate(),
									$oTask->getTaskFinishDate(),$oTask->getTaskObs(),$oTask->getTaskPend()];
				}
				else
				{
					$aArrayParam = [$oTask->getTaskProjectId(),$oTask->getTaskUserId(),
									$oTask->getTaskName(),$oTask->getTaskStartDate(),
									$oTask->getTaskFinishDate(),$oTask->getTaskObs(),null];
				}
							
				$aArrayCondicao = [$iId];
				$rDatabaseHandler->update($sQuery,$rConnection,$aArrayParam,$aArrayCondicao);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				$aUser = User::findUser($oTask->getTaskUserId());
				$aProject = Project::findProject($oTask->getProjectId());
				$sUserName = new Sessao();
				self::sendEmail($aUser["emailUsuario"],$sUserName->getSessao("sUserName"),"Tarefa do Projeto ".$aProject['nomeProjeto'],'Olá !!! Há mudanças na tarefa para você vinculada ao projeto '.$aProject['nomeProjeto'].'. Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)');
				echo "<script> 
						alert('Tarefa Alterada Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizetask';
					  </script>";		
			}	
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Atualizar: ".$e->getMessage();
			}
		}	
		
		public static function removeTask($iIdTask)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "DELETE FROM tarefa WHERE idTarefa = ? ";
				$aArrayParam = [$iIdTask];
				$lDeleted = $rDatabaseHandler->deleteDate($sQuery,$rConnection,$aArrayParam);
				if($lDeleted)
				{
					$rDatabaseHandler->commit($rConnection);
					$rConnection = $rDatabaseHandler->close($rConnection);
					$aUser = User::findUser($oTask->getTaskUserId());
					$aProject = Project::findProject($oTask->getProjectId());
					$sUserName = new Sessao();
					self::sendEmail($aUser["emailUsuario"],$sUserName->getSessao("sUserName"),"Tarefa do Projeto ".$aProject['nomeProjeto']."","Olá !!! Tarefa  ao projeto ".$aProject['nomeProjeto']." foi deletada. Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)");
					echo "<script> 
						alert('Tarefa Deletada Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizetask';
					</script>";
				}	
			}
			catch(PDOException $e)
			{
				echo "Erro ao Deletar: ".$e->getMessage();
			}
		}	
		
		public static function consultStartDateTasks($sStartDateTasks)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM tarefa WHERE  str_to_date(dataInicioTarefa,'%d/%m/%Y') >= ? order by dataInicioTarefa,Projeto_idProjeto";
				$aArrayParam = [$sStartDateTasks];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					
				}
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}
		
		public static function consultFinishDateTasks($sFinishDateTasks)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM tarefa WHERE  str_to_date(dataTerminoTarefa,'%d/%m/%Y') >= ? order by dataTerminoTarefa,Projeto_idProjeto";
				$aArrayParam = [$sFinishDateTasks];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
						alert('Não Há Tarefas A Partir Dessa Data !!!');
						window.location.href = '/ser/login/pagereportfinishdatetask';
					</script>";
				}
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}
		
		public static function consultTaskPeriod($sTaskDateStart,$sTaskDateFinish)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM tarefa WHERE str_to_date(dataInicioTarefa,'%d/%m/%Y') AND str_to_date(dataTerminoTarefa,'%d/%m/%Y')  BETWEEN ? AND ?";
				$aArrayParam = [$sTaskDateStart,$sTaskDateFinish];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
						alert('Não Há Tarefas Nesse Período !!!');
						window.location.href = '/ser/login/pagereporttaskperiod';
					</script>";
				}
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}
		
		public static function consultTaskUser($iUserId)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM tarefa WHERE Usuario_idUsuario = ?";
				$aArrayParam = [$iUserId];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
						alert('Não Há Tarefas Para Esse Usuario !!!');
						window.location.href = '/ser/login/pagereporttaskuser';
					</script>";
				}
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}
		
		public static function consultTaskProject($iProjectId)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM tarefa WHERE Projeto_idProjeto = ?";
				$aArrayParam = [$iProjectId];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
						alert('Não Há Tarefas Para Esse Projeto !!!');
						window.location.href = '/ser/login/pagereporttaskproject';
					</script>";
				}
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}
		
		public static function createAllReportTasks()
		{		
			$aAllTask = self::allTask();
			$sHTML =  '<html>
						<head>
							<title></title>
							<link href="../css/Principal.css" rel="stylesheet" type="text/css" />
							<link href="../css/StyleSheet.css" rel="stylesheet" type="text/css" />
							<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
							<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
							<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
						</head>
		
						<body>
						<h2 align ="center">SER - Sistema de Engenharia de Requisitos </h3>
							<h3 align ="center">Relatorio De Tarefas</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="7" align="center">Tarefas</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Nome da Tarefa</td>
												<td  align="center">Projeto</td>
												<td  align="center">Usuario </td>												
												<td  align="center">Tarefa Dep. </td>
												<td  align="center">Data de Inicio </td>
												<td  align="center">Data de Fim </td>
											</tr> ';
			foreach ($aAllTask as $aTask) 
			{
				$aUser = User::findUser($aTask['Usuario_idUsuario']);
				$aProject = Project::findProject($aTask['Projeto_idProjeto']);
				if(!empty($aTask['Tarefa_idTarefa']))
				{
					$aDepTask = Task::depTask($aTask['Tarefa_idTarefa']); 
				}
				else
				{
					$aDepTask = null;
				}
				$sHTML.= '
						<tr>
							<td align="center">'.$aTask['idTarefa'].' </td>
							<td align="center">'.$aTask['nomeTarefa'].' </td>
							<td align="center">'.$aProject['nomeProjeto'].' </td>
							<td align="center">'.$aUser ['nomeUsuario'].'  </td>
							<td align="center">'.$aDepTask['nomeTarefa'].' </td>
							<td align="center">'.$aTask['dataInicioTarefa'].' </td>
							<td align="center">'.$aTask['dataTerminoTarefa'].' </td>	
						</tr>
						';
			}
			$sHTML.='		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Tarefas.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
	
		public static function createReportTaskDateStart($sTaskDateStart)
		{		
			$aAllTask = self::consultStartDateTasks($sTaskDateStart);
			$sHTML =  '<html>
						<head>
							<title></title>
							<link href="../css/Principal.css" rel="stylesheet" type="text/css" />
							<link href="../css/StyleSheet.css" rel="stylesheet" type="text/css" />
							<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
							<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
							<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
						</head>
							<body>
								<h2 align ="center">SER - Sistema de Engenharia de Requisitos </h3>
								<h3 align ="center">Relatorio de Tarefas Por Data De Inicio</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="7" align="center">Tarefas</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Nome da Tarefa</td>
												<td  align="center">Projeto</td>
												<td  align="center">Usuario </td>												
												<td  align="center">Tarefa Dep. </td>
												<td  align="center">Data de Inicio </td>
												<td  align="center">Data de Fim </td>
											</tr> ';
			foreach ($aAllTask as $aTask) 
			{
				$aUser = User::findUser($aTask['Usuario_idUsuario']);
				$aProject = Project::findProject($aTask['Usuario_idUsuario']);
				if(!empty($aTask['Tarefa_idTarefa']))
				{
					$aDepTask = Task::depTask($aTask['Tarefa_idTarefa']);
				}
				else
				{
					$aDepTask = null;
				}
				$sHTML.= '
						<tr>
							<td align="center">'.$aTask['idTarefa'].' </td>
							<td align="center">'.$aTask['nomeTarefa'].' </td>
							<td align="center">'.$aProject['nomeProjeto'].' </td>
							<td align="center">'.$aUser ['nomeUsuario'].'  </td>
							<td align="center">'.$aDepTask['nomeTarefa'].' </td>
							<td align="center">'.$aTask['dataInicioTarefa'].' </td>
							<td align="center">'.$aTask['dataTerminoTarefa'].' </td>	
						</tr>
					';
			}
			$sHTML.='		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Tarefa Por Data de Inicio.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createReportTaskDateFinish($sTaskDateFinish)
		{		
			$aAllTask = self::consultFinishDateTasks($sTaskDateFinish);
			$sHTML =  '<html>
						<head>
							<title></title>
							<link href="../css/Principal.css" rel="stylesheet" type="text/css" />
							<link href="../css/StyleSheet.css" rel="stylesheet" type="text/css" />
							<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
							<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
							<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
						</head>
							<body>
								<h2 align ="center">SER - Sistema de Engenharia de Requisitos </h3>
								<h3 align ="center">Relatorio de Tarefas Por Data De Termino</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="7" align="center">Tarefas</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Nome da Tarefa</td>
												<td  align="center">Projeto</td>
												<td  align="center">Usuario </td>												
												<td  align="center">Tarefa Dep. </td>
												<td  align="center">Data de Inicio </td>
												<td  align="center">Data de Fim </td>
											</tr> ';
			foreach ($aAllTask as $aTask) 
			{
				$aUser = User::findUser($aTask['Usuario_idUsuario']);
				$aProject = Project::findProject($aTask['Usuario_idUsuario']);
				if(!empty($aTask['Tarefa_idTarefa']))
				{
					$aDepTask = Task::depTask($aTask['Tarefa_idTarefa']);
				}
				else
				{
					$aDepTask = null;
				}
				$sHTML.= '
						<tr>
							<td align="center">'.$aTask['idTarefa'].' </td>
							<td align="center">'.$aTask['nomeTarefa'].' </td>
							<td align="center">'.$aProject['nomeProjeto'].' </td>
							<td align="center">'.$aUser ['nomeUsuario'].'  </td>
							<td align="center">'.$aDepTask['nomeTarefa'].' </td>
							<td align="center">'.$aTask['dataInicioTarefa'].' </td>
							<td align="center">'.$aTask['dataTerminoTarefa'].' </td>	
						</tr>
					';
			}
			$sHTML.='		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Tarefa Por Data de Termino.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createReportTaskPeriod($sTaskDateStart,$sTaskDateFinish)
		{		
			$aAllTask = self::consultTaskPeriod($sTaskDateStart,$sTaskDateFinish);
			$sHTML =  '<html>
						<head>
							<title></title>
							<link href="../css/Principal.css" rel="stylesheet" type="text/css" />
							<link href="../css/StyleSheet.css" rel="stylesheet" type="text/css" />
							<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
							<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
							<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
						</head>
							<body>
								<h2 align ="center">SER - Sistema de Engenharia de Requisitos </h3>
								<h3 align ="center">Relatorio de Tarefas Por Periodo</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="7" align="center">Tarefas</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Nome da Tarefa</td>
												<td  align="center">Projeto</td>
												<td  align="center">Usuario </td>												
												<td  align="center">Tarefa Dep. </td>
												<td  align="center">Data de Inicio </td>
												<td  align="center">Data de Fim </td>
											</tr> ';
			foreach ($aAllTask as $aTask) 
			{
				$aUser = User::findUser($aTask['Usuario_idUsuario']);
				$aProject = Project::findProject($aTask['Usuario_idUsuario']);
				if(!empty($aTask['Tarefa_idTarefa']))
				{
					$aDepTask = Task::depTask($aTask['Tarefa_idTarefa']);
				}
				else
				{
					$aDepTask = null;
				}
				$sHTML.= '
						<tr>
							<td align="center">'.$aTask['idTarefa'].' </td>
							<td align="center">'.$aTask['nomeTarefa'].' </td>
							<td align="center">'.$aProject['nomeProjeto'].' </td>
							<td align="center">'.$aUser ['nomeUsuario'].'  </td>
							<td align="center">'.$aDepTask['nomeTarefa'].' </td>
							<td align="center">'.$aTask['dataInicioTarefa'].' </td>
							<td align="center">'.$aTask['dataTerminoTarefa'].' </td>	
						</tr>
					';
			}
			$sHTML.='		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Tarefa Por Por Periodo.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createReportTaskUser($iUserId)
		{		
			$aAllTask = self::consultTaskUser($iUserId);
			$sHTML =  '<html>
						<head>
							<title></title>
							<link href="../css/Principal.css" rel="stylesheet" type="text/css" />
							<link href="../css/StyleSheet.css" rel="stylesheet" type="text/css" />
							<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
							<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
							<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
						</head>
							<body>
								<h2 align ="center">SER - Sistema de Engenharia de Requisitos </h3>
								<h3 align ="center">Relatorio de Tarefas Por Usuario</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="7" align="center">Tarefas</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Nome da Tarefa</td>
												<td  align="center">Projeto</td>
												<td  align="center">Usuario </td>												
												<td  align="center">Tarefa Dep. </td>
												<td  align="center">Data de Inicio </td>
												<td  align="center">Data de Fim </td>
											</tr> ';
			foreach ($aAllTask as $aTask) 
			{
				$aUser = User::findUser($aTask['Usuario_idUsuario']);
				$aProject = Project::findProject($aTask['Usuario_idUsuario']);
				if(!empty($aTask['Tarefa_idTarefa']))
				{
					$aDepTask = Task::depTask($aTask['Tarefa_idTarefa']);
				}
				else
				{
					$aDepTask = null;
				}
				$sHTML.= '
						<tr>
							<td align="center">'.$aTask['idTarefa'].' </td>
							<td align="center">'.$aTask['nomeTarefa'].' </td>
							<td align="center">'.$aProject['nomeProjeto'].' </td>
							<td align="center">'.$aUser ['nomeUsuario'].'  </td>
							<td align="center">'.$aDepTask['nomeTarefa'].' </td>
							<td align="center">'.$aTask['dataInicioTarefa'].' </td>
							<td align="center">'.$aTask['dataTerminoTarefa'].' </td>	
						</tr>
					';
			}
			$sHTML.='		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Tarefa Por Usuario.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createReportTaskProjects($iProjectId)
		{		
			$aAllTask = self::consultTaskProject($iProjectId);
			$sHTML =  '<html>
						<head>
							<title></title>
							<link href="../css/Principal.css" rel="stylesheet" type="text/css" />
							<link href="../css/StyleSheet.css" rel="stylesheet" type="text/css" />
							<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
							<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
							<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
						</head>
							<body>
								<h2 align ="center">SER - Sistema de Engenharia de Requisitos </h3>
								<h3 align ="center">Relatorio de Tarefas Por Projeto</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="7" align="center">Tarefas</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Nome da Tarefa</td>
												<td  align="center">Projeto</td>
												<td  align="center">Usuario </td>												
												<td  align="center">Tarefa Dep. </td>
												<td  align="center">Data de Inicio </td>
												<td  align="center">Data de Fim </td>
											</tr> ';
			foreach ($aAllTask as $aTask) 
			{
				$aUser = User::findUser($aTask['Usuario_idUsuario']);
				$aProject = Project::findProject($aTask['Usuario_idUsuario']);
				if(!empty($aTask['Tarefa_idTarefa']))
				{
					$aDepTask = Task::depTask($aTask['Tarefa_idTarefa']);
				}
				else
				{
					$aDepTask = null;
				}
				$sHTML.= '
						<tr>
							<td align="center">'.$aTask['idTarefa'].' </td>
							<td align="center">'.$aTask['nomeTarefa'].' </td>
							<td align="center">'.$aProject['nomeProjeto'].' </td>
							<td align="center">'.$aUser ['nomeUsuario'].'  </td>
							<td align="center">'.$aDepTask['nomeTarefa'].' </td>
							<td align="center">'.$aTask['dataInicioTarefa'].' </td>
							<td align="center">'.$aTask['dataTerminoTarefa'].' </td>	
						</tr>
					';
			}
			$sHTML.='		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Tarefa Por Projeto.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
	}
	