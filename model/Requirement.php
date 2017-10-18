<?php
	
	class Requirement
	{
		private $iIdRequirement;
		private $iIdTask;
		private $iIdProject;
		private $iIdTypeRequirement;
		private $sRequirementName;
		private $sDescriptionRequirement;
		private $dStartDateRequirement;
		private $dFinishDateRequirement;
		private $iImportanceRequirement;
		private $sSituationRequirement;
		
		function __construct($iIdTask,$iIdProject,$iIdTypeRequirement,$sRequirementName,$iImportanceRequirement,$dStartDateRequirement,$dFinishDateRequirement,$sDescriptionRequirement,$sSituationRequirement)
		{
			$this->iIdTypeRequirement   	= $iIdTypeRequirement;
			$this->iIdTask   				= $iIdTask;
			$this->iIdProject   			= $iIdProject;
			$this->sRequirementName 		= $sRequirementName;
			$this->iImportanceRequirement 	= $iImportanceRequirement;
			$this->dStartDateRequirement	= $dStartDateRequirement;
			$this->dFinishDateRequirement	= $dFinishDateRequirement;
			$this->sDescriptionRequirement	= $sDescriptionRequirement;
			$this->sSituationRequirement	= $sSituationRequirement;
		}
		
		public function getIdRequirement()
		{
			return $this->iIdRequirement;
		}
		
		public function getIdTypeRequirement()
		{
			return $this->iIdTypeRequirement;
		}
		
		public function getIdTask()
		{
			return $this->iIdTask;
		}
		
		public function getIdProject()
		{
			return $this->iIdProject;
		}
	
		public function getRequirementName()
		{
			return $this->sRequirementName;
		}
		
		public function getImportance()
		{
			return $this->iImportanceRequirement;
		}
		
		public function getDescriptionRequirement()
		{
			return $this->sDescriptionRequirement;
		}
		
		public function getStartDate()
		{
			return $this->dStartDateRequirement;
		}
		
		public function getFinishDate()
		{
			return $this->dFinishDateRequirement;
		}
		
		public function getSituation()
		{
			return $this->sSituationRequirement;
		}

		public function setIdRequirement($iIdRequirement)
		{
			$this->iIdRequirement = $iIdRequirement;
		}
		
		public function setIdTypeRequirement($iIdTypeRequirement)
		{
			$this->iIdTypeRequirement = $iIdTypeRequirement;
		}
		
		public function setIdProject($iIdProject)
		{
			$this->iIdProject = $iIdProject;
		}
		
		public function setIdTask($iIdTask)
		{
			$this->iIdTask = $iIdTask;
		}
		
		public function setRequirementName($sRequirementName)
		{
			$this->sRequirementName = $sRequirementName;
		}
		
		public function setStartDate($dStartDateRequirement)
		{
			$this->dStartDateRequirement = $dStartDateRequirement;
		}
		
		public function setFinishDate($dFinishDateRequirement)
		{
			$this->dFinishDateRequirement = $dFinishDateRequirement;
		}

		public function setImportance($iImportanceRequirement)
		{
			$this->iImportanceRequirement = $iImportanceRequirement;
		}
		
		public function setDescription($sDescriptionRequirement)
		{
			$this->sDescriptionRequirement = $sDescriptionRequirement;
		}
		
		public function setSituation($sSituationRequirement)
		{
			$this->sSituationRequirement = $sSituationRequirement;
		}
		
		public static function researchRequirementExist($oAddRequirement)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM requisito WHERE nomeRequisito = ? ";
				$aArrayParam = [$oAddRequirement->getRequirementName()];
				$aExistRequirement = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (!empty($aExistRequirement))
				{
					echo "<script> 
									alert(' Requisito Ja Foi Cadastrado !!!');
									window.location.href = 'ser/login/pageaddrequirement';
						 </script>";
				}
			}
			catch(PDOException $e)
			{
				echo "Erro: ".$e->getMessage();
			}
		
		}
		
		public static function addRequirement($oRequirement)
		{
			self::researchRequirementExist($oRequirement);
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "INSERT INTO requisito(TipoRequisito_idTipoRequisito,Tarefa_idTarefa,Projeto_idProjeto,
												nomeRequisito,descricaoRequisito,dataInicioRequisito,dataTerminoRequisito,importanciaRequisito,situacaoRequisito) 
							VALUES (?,?,?,?,?,?,?,?,?) ";
				$aArrayParam = [$oRequirement->getIdTypeRequirement(),$oRequirement->getIdTask(),$oRequirement->getIdProject(),
								$oRequirement->getRequirementName(),$oRequirement->getDescriptionRequirement(),$oRequirement->getStartDate(),
								$oRequirement->getFinishDate(),$oRequirement->getImportance(),$oRequirement->getSituation()];
				$rDatabaseHandler->add($sQuery,$rConnection,$aArrayParam);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				$aProject = Project::findProject($oRequirement->getIdProject());
				$aUser = User::findUser($aProject['Usuario_idUsuario']);
				$sUserName = new Sessao();
				self::sendEmail($aUser["emailUsuario"],$sUserName->getSessao("sUserName"),"Requisito do Projeto ".$aProject['nomeProjeto'],'Olá !!! Há uma novo requisito chamado'.$oRequirement->getRequirementName().' vinculado a você ao projeto '.$aProject['nomeProjeto'].'. Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)');
				echo "<script> 
							alert('Cadastro Feito Com Sucesso !!!');
							window.location.href = '/ser/login/pageaddrequirement';
					  </script>";
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Cadastrar: ".$e->getMessage();
			}
		}
		
		public static function updateRequirement($oRequirement)
		{
			try
			{   
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editRequirement"); 
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "UPDATE requisito SET 
										TipoRequisito_idTipoRequisito = ?,
										Tarefa_idTarefa = ?,
										Projeto_idProjeto = ?,
										nomeRequisito = ?,
										descricaoRequisito = ?,
										dataInicioRequisito = ?,
										dataTerminoRequisito = ?,
										importanciaRequisito = ?,
										situacaoRequisito = ?
							WHERE idRequisito = ? ";
				$aArrayParam = [$oRequirement->getIdTypeRequirement(),$oRequirement->getIdTask(),$oRequirement->getIdProject(),
								$oRequirement->getRequirementName(),$oRequirement->getDescriptionRequirement(),$oRequirement->getStartDate(),
								$oRequirement->getFinishDate(),$oRequirement->getImportance(),$oRequirement->getSituation()];
				$aArrayCondicao = [$iId];
				$rDatabaseHandler->update($sQuery,$rConnection,$aArrayParam,$aArrayCondicao);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				$aProject = Project::findProject($oRequirement->getIdProject());
				$aUser = User::findUser($aProject['Usuario_idUsuario']);
				$sUserName = new Sessao();
				self::sendEmail($aUser["emailUsuario"],$sUserName->getSessao("sUserName"),"Requisito do Projeto ".$aProject['nomeProjeto'],'Olá !!! Houve uma alteração no requisito'.$oRequirement->getRequirementName().' para você vinculada ao projeto '.$aProject['nomeProjeto'].'. Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)');
				echo "<script> 
						alert('Requisito Alterado Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizerequirement';
					</script>";		
			}	
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Atualizar: ".$e->getMessage();
			}	
		}
		
		public static function situationUpdateRequirement($sSituationRequirementRequirement)
		{
			try
			{   
				$iRequirement = new Sessao();
				$iId = $iRequirement->getSessao("keyUserRequirement");
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "UPDATE requisito SET 
										situacaoRequisito = ?    
							WHERE idRequisito = ? ";
				$aArrayParam = [$sSituationRequirementRequirement];
				$aArrayCondicao = [$iId];
				$rDatabaseHandler->update($sQuery,$rConnection,$aArrayParam,$aArrayCondicao);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				$aRequirement = Requirement::findRequirement($iId); 
				$aTask = Task::findTask($aRequirement["Tarefa_idTarefa"]);
				$aUser = User::findUser($aTask["Usuario_idUsuario"]);
				$aProject = Project::findProject($aRequirement["Projeto_idProjeto"]);
				$sUserName = new Sessao();
				User::sendEmail($aUser["emailUsuario"],$sUserName->getSessao("sUserName"),"Requisito do Projeto ".$aProject['nomeProjeto']."",'Olá !!! O requisito '.$aRequirement['nomeRequisito'].' vinculado ao projeto '.$aProject['nomeProjeto'].' teve seu status mudado para '.$aRequirement['situacaoRequisito'].'. Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)');
				echo "<script> 
						alert('Requisito Alterado Com Sucesso !!!');
						window.location.href = '/ser/login/pagekeyuservisualizeproject';
					</script>";		
			}	
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Atualizar: ".$e->getMessage();
			}	
		}
		
		public static function removeRequirement($iIdRequirement)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "DELETE FROM requisito WHERE idRequisito = ? ";
				$aArrayParam = [$iIdRequirement];
				$lDeleted = $rDatabaseHandler->deleteDate($sQuery,$rConnection,$aArrayParam);
				if($lDeleted)
				{
					$rDatabaseHandler->commit($rConnection);
					$rConnection = $rDatabaseHandler->close($rConnection);
					echo "<script> 
						alert('Requisito Deletado Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizerequirement';
					</script>";
				}	
			}
			catch(PDOException $e)
			{
				echo "Erro ao Deletar: ".$e->getMessage();
			}	
		}
		
		public static function allRequirement()
		{	
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM requisito order by nomeRequisito";
			$aAllRequirement = $rDatabaseHandler->query($sQuery,$rConnection,null,true);	
			return $aAllRequirement;
		}
		
		public static function findRequirement($iIdRequirement)
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM requisito where idRequisito = ?  ";
			$aArrayParam = [$iIdRequirement];
			$aRequirement = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aRequirement;		
		}
		
		public static function findEditRequirement()
		{
			$iEdit = new Sessao();
			$iId = $iEdit->getSessao("editRequirement");
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM requisito where idRequisito = ?  ";
			$aArrayParam = [$iId];
			$aRequirement = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aRequirement;		
		}
		
		public static function findKeyUserRequirement()
		{
			$iRequirement = new Sessao();
			$iId = $iRequirement->getSessao("keyUserRequirement");
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM requisito where idRequisito = ?  ";
			$aArrayParam = [$iId];
			$aRequirement = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aRequirement;		
		}
		
		public static function findDeveloperRequirement()
		{
			$iRequirement = new Sessao();
			$iId = $iRequirement->getSessao("developerRequirement");
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM requisito where idRequisito = ?  ";
			$aArrayParam = [$iId];
			$aRequirement = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aRequirement;		
		}
		
		public static function consultProjectRequirement($iIdProject)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM requisito where Projeto_idProjeto = ?";
				$aArrayParam = [$iIdProject];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (empty($aReport))
				{
					echo "<script> 
						alert('Não Há Requisitos Cadastrados Nesse Projeto !!!');
						window.location.href = '/ser/login/pagereportprojectrequirement';
					</script>";
				}
				return $aReport;
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}
	
		public static function consultTaskRequirement($iIdTask)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM requisito WHERE Tarefa_idTarefa = ?";
				$aArrayParam = [$iIdTask];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
						alert('Não Há Projetos A Partir Dessa Data !!!');
						window.location.href = '/ser/login/pagereporttaskrequirement';
					</script>";
				}
			}
			catch(PDOException $e)
			{
				echo "Erro : ".$e->getMessage();
			}
		}
	
		public static function consultRequirementTypeRequirement($iIdTypeRequirement)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM requisito WHERE  TipoRequisito_idTipoRequisito = ?";
				$aArrayParam = [$iIdTypeRequirement];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
						alert('Não Há Requisitos Desse Tipo !!!');
						window.location.href = '/ser/login/pagereportrequirementtyperequirement';
					</script>";
				}
			}
			catch(PDOException $e)
			{
				echo "Erro : ".$e->getMessage();
			}
		}
	
		public static function consultStartDateRequirement($sRequirementDateStart)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM requisito WHERE  str_to_date(dataInicioRequisito,'%d/%m/%Y') >= ? order by dataInicioRequisito";
				$aArrayParam = [$sRequirementDateStart];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
						alert('Não Há Requisitos Iniciados A Partir Dessa Data !!!');
						window.location.href = '/ser/login/pagereportstartdaterequirement';
					</script>";	
				}
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}
		
		public static function consultFinishDateRequirement($sRequirementDateFinish)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM requisito WHERE  str_to_date(dataTerminoRequisito,'%d/%m/%Y') >= ? order by dataTerminoRequisito";
				$aArrayParam = [$sRequirementDateFinish];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
						alert('Não Há Requisitos Que Serão Finalizados A Partir Dessa Data !!!');
						window.location.href = '/ser/login/pagereportfinishdaterequirement';
					</script>";	
				}
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}
		
		public static function consultRequirementPeriod($sRequirementDateStart,$sRequirementDateFinish)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM requisito WHERE str_to_date(dataInicioRequisito,'%d/%m/%Y') AND str_to_date(dataTerminoRequisito,'%d/%m/%Y')  BETWEEN ? AND ?";
				$aArrayParam = [$sRequirementDateStart,$sRequirementDateFinish];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
						alert('Não Há Requisitos Cadastrados Nesse Período !!!');
						window.location.href = '/ser/login/pagereportrequirementperiod';
					</script>";	
				}
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}
		
		public static function consultSituationRequirement($sSituationRequirement)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM requisito WHERE situacaoRequisito = ?";
				$aArrayParam = [$sSituationRequirement];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
						alert('Não Há Requisitos Nessa Situacao !!!');
						window.location.href = '/ser/login/pagereportsituationrequirement';
					</script>";	
				}
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}
		
		public static function consultImportanceRequirement($sImportance)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM requisito WHERE importanciaRequisito = ?";
				$aArrayParam = [$sImportance];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
						alert('Não Há Requisitos Com Essa Importancia !!!');
						window.location.href = '/ser/login/pagereportimportancerequirement';
					</script>";
				}
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}

		public static function createAllReportRequirement()
		{		
			$aAllRequirement = self::allRequirement();
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
							<h3 align ="center">Relatorio de Requisitos</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="9" align="center">Requisitos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Tipo</td>
												<td  align="center">Projeto </td>
												<td  align="center">Tarefa</td>
												<td  align="center">Nome</td>
												<td  align="center">Data De Inicio </td>
												<td  align="center">Data De Termino </td>
												<td  align="center">Importancia </td>
												<td  align="center">Situacao </td>
											</tr>
							 ';
			foreach ($aAllRequirement as $aRequirement) 
			{
				$aTypeRequirement = TypeRequirement::findTypeRequirement($aRequirement['TipoRequisito_idTipoRequisito']);
				$aTask = Task::findTask($aRequirement['Tarefa_idTarefa']);
				$aProject = Project::findProject($aRequirement['Projeto_idProjeto']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aRequirement['idRequisito'].' </td>
								<td align="center">'.$aTypeRequirement ['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aProject['nomeProjeto'].' </td>
								<td align="center">'.$aTask['nomeTarefa'].' </td>
								<td align="center">'.$aRequirement['nomeRequisito'].' </td>
								<td align="center">'.$aRequirement['dataInicioRequisito'].' </td>
								<td align="center">'.$aRequirement['dataTerminoRequisito'].' </td>	
								<td align="center">'.$aRequirement['importanciaRequisito'].' </td>	
								<td align="center">'.$aRequirement['situacaoRequisito'].' </td>		
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os Requisitos.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportProjectRequirement($iIdProject)
		{		
			$aAllRequirement = self::consultProjectRequirement($iIdProject);
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
							<h3 align ="center">Relatorio de Requisitos Por Projeto</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="9" align="center">Requisitos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Tipo</td>
												<td  align="center">Projeto </td>
												<td  align="center">Tarefa</td>
												<td  align="center">Nome</td>
												<td  align="center">Data De Inicio </td>
												<td  align="center">Data De Termino </td>
												<td  align="center">Importancia </td>
												<td  align="center">Situacao </td>
											</tr>
							 ';
			foreach ($aAllRequirement as $aRequirement) 
			{
				$aTypeRequirement = TypeRequirement::findTypeRequirement($aRequirement['TipoRequisito_idTipoRequisito']);
				$aTask = Task::findTask($aRequirement['Tarefa_idTarefa']);
				$aProject = Project::findProject($aRequirement['Projeto_idProjeto']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aRequirement['idRequisito'].' </td>
								<td align="center">'.$aTypeRequirement ['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aProject['nomeProjeto'].' </td>
								<td align="center">'.$aTask['nomeTarefa'].' </td>
								<td align="center">'.$aRequirement['nomeRequisito'].' </td>
								<td align="center">'.$aRequirement['dataInicioRequisito'].' </td>
								<td align="center">'.$aRequirement['dataTerminoRequisito'].' </td>	
								<td align="center">'.$aRequirement['importanciaRequisito'].' </td>	
								<td align="center">'.$aRequirement['situacaoRequisito'].' </td>		
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Requisitos Por Projeto.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportTaskRequirement($iIdTask)
		{		
			$aAllRequirement = self::consultTaskRequirement($iIdTask);
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
							<h3 align ="center">Relatorio de Requisitos Por Tarefa</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="9" align="center">Requisitos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Tipo</td>
												<td  align="center">Projeto </td>
												<td  align="center">Tarefa</td>
												<td  align="center">Nome</td>
												<td  align="center">Data De Inicio </td>
												<td  align="center">Data De Termino </td>
												<td  align="center">Importancia </td>
												<td  align="center">Situacao </td>
											</tr>
							 ';
			foreach ($aAllRequirement as $aRequirement) 
			{
				$aTypeRequirement = TypeRequirement::findTypeRequirement($aRequirement['TipoRequisito_idTipoRequisito']);
				$aTask = Task::findTask($aRequirement['Tarefa_idTarefa']);
				$aProject = Project::findProject($aRequirement['Projeto_idProjeto']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aRequirement['idRequisito'].' </td>
								<td align="center">'.$aTypeRequirement ['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aProject['nomeProjeto'].' </td>
								<td align="center">'.$aTask['nomeTarefa'].' </td>
								<td align="center">'.$aRequirement['nomeRequisito'].' </td>
								<td align="center">'.$aRequirement['dataInicioRequisito'].' </td>
								<td align="center">'.$aRequirement['dataTerminoRequisito'].' </td>	
								<td align="center">'.$aRequirement['importanciaRequisito'].' </td>	
								<td align="center">'.$aRequirement['situacaoRequisito'].' </td>		
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio De Requisitos Por Tarefa.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportRequirementTypeRequirement($iIdTypeRequirement)
		{		
			$aAllRequirement = self::consultRequirementTypeRequirement($iIdTypeRequirement);
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
							<h3 align ="center">Relatorio de Requisitos Por Tipo de Requisitos</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="9" align="center">Requisitos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Tipo</td>
												<td  align="center">Projeto </td>
												<td  align="center">Tarefa</td>
												<td  align="center">Nome</td>
												<td  align="center">Data De Inicio </td>
												<td  align="center">Data De Termino </td>
												<td  align="center">Importancia </td>
												<td  align="center">Situacao </td>
											</tr>
							 ';
			foreach ($aAllRequirement as $aRequirement) 
			{
				$aTypeRequirement = TypeRequirement::findTypeRequirement($aRequirement['TipoRequisito_idTipoRequisito']);
				$aTask = Task::findTask($aRequirement['Tarefa_idTarefa']);
				$aProject = Project::findProject($aRequirement['Projeto_idProjeto']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aRequirement['idRequisito'].' </td>
								<td align="center">'.$aTypeRequirement ['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aProject['nomeProjeto'].' </td>
								<td align="center">'.$aTask['nomeTarefa'].' </td>
								<td align="center">'.$aRequirement['nomeRequisito'].' </td>
								<td align="center">'.$aRequirement['dataInicioRequisito'].' </td>
								<td align="center">'.$aRequirement['dataTerminoRequisito'].' </td>	
								<td align="center">'.$aRequirement['importanciaRequisito'].' </td>	
								<td align="center">'.$aRequirement['situacaoRequisito'].' </td>		
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio De Requisitos Por Tipo de Requisitos.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportStartDateRequirement($sDateStart)
		{		
			$aAllRequirement = self::consultStartDateRequirement($sDateStart);
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
							<h3 align ="center">Relatorio de Requisitos Por Data De Inicio</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="9" align="center">Requisitos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Tipo</td>
												<td  align="center">Projeto </td>
												<td  align="center">Tarefa</td>
												<td  align="center">Nome</td>
												<td  align="center">Data De Inicio </td>
												<td  align="center">Data De Termino </td>
												<td  align="center">Importancia </td>
												<td  align="center">Situacao </td>
											</tr>
							 ';
			foreach ($aAllRequirement as $aRequirement) 
			{
				$aTypeRequirement = TypeRequirement::findTypeRequirement($aRequirement['TipoRequisito_idTipoRequisito']);
				$aTask = Task::findTask($aRequirement['Tarefa_idTarefa']);
				$aProject = Project::findProject($aRequirement['Projeto_idProjeto']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aRequirement['idRequisito'].' </td>
								<td align="center">'.$aTypeRequirement ['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aProject['nomeProjeto'].' </td>
								<td align="center">'.$aTask['nomeTarefa'].' </td>
								<td align="center">'.$aRequirement['nomeRequisito'].' </td>
								<td align="center">'.$aRequirement['dataInicioRequisito'].' </td>
								<td align="center">'.$aRequirement['dataTerminoRequisito'].' </td>	
								<td align="center">'.$aRequirement['importanciaRequisito'].' </td>	
								<td align="center">'.$aRequirement['situacaoRequisito'].' </td>		
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio De Requisitos Por Data De Inicio.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportFinishDateRequirement($sDateFinish)
		{		
			$aAllRequirement = self::consultFinishDateRequirement($sDateFinish);
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
							<h3 align ="center">Relatorio De Requisitos Por Data De Termino</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="9" align="center">Requisitos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Tipo</td>
												<td  align="center">Projeto </td>
												<td  align="center">Tarefa</td>
												<td  align="center">Nome</td>
												<td  align="center">Data De Inicio </td>
												<td  align="center">Data De Termino </td>
												<td  align="center">Importancia </td>
												<td  align="center">Situacao </td>
											</tr>
							 ';
			foreach ($aAllRequirement as $aRequirement) 
			{
				$aTypeRequirement = TypeRequirement::findTypeRequirement($aRequirement['TipoRequisito_idTipoRequisito']);
				$aTask = Task::findTask($aRequirement['Tarefa_idTarefa']);
				$aProject = Project::findProject($aRequirement['Projeto_idProjeto']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aRequirement['idRequisito'].' </td>
								<td align="center">'.$aTypeRequirement ['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aProject['nomeProjeto'].' </td>
								<td align="center">'.$aTask['nomeTarefa'].' </td>
								<td align="center">'.$aRequirement['nomeRequisito'].' </td>
								<td align="center">'.$aRequirement['dataInicioRequisito'].' </td>
								<td align="center">'.$aRequirement['dataTerminoRequisito'].' </td>	
								<td align="center">'.$aRequirement['importanciaRequisito'].' </td>	
								<td align="center">'.$aRequirement['situacaoRequisito'].' </td>		
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio De Requisitos Por Data De Termino.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportRequirementPeriod($sDateStart,$sDateFinish)
		{		
			$aAllRequirement = self::consultRequirementPeriod($sDateStart,$sDateFinish);
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
							<h3 align ="center">Relatorio de Requisitos Por Periodo</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="9" align="center">Requisitos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Tipo</td>
												<td  align="center">Projeto </td>
												<td  align="center">Tarefa</td>
												<td  align="center">Nome</td>
												<td  align="center">Data De Inicio </td>
												<td  align="center">Data De Termino </td>
												<td  align="center">Importancia </td>
												<td  align="center">Situacao </td>
											</tr>
							 ';
			foreach ($aAllRequirement as $aRequirement) 
			{
				$aTypeRequirement = TypeRequirement::findTypeRequirement($aRequirement['TipoRequisito_idTipoRequisito']);
				$aTask = Task::findTask($aRequirement['Tarefa_idTarefa']);
				$aProject = Project::findProject($aRequirement['Projeto_idProjeto']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aRequirement['idRequisito'].' </td>
								<td align="center">'.$aTypeRequirement ['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aProject['nomeProjeto'].' </td>
								<td align="center">'.$aTask['nomeTarefa'].' </td>
								<td align="center">'.$aRequirement['nomeRequisito'].' </td>
								<td align="center">'.$aRequirement['dataInicioRequisito'].' </td>
								<td align="center">'.$aRequirement['dataTerminoRequisito'].' </td>	
								<td align="center">'.$aRequirement['importanciaRequisito'].' </td>	
								<td align="center">'.$aRequirement['situacaoRequisito'].' </td>		
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio De Requisitos Por Periodo.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportSituationRequirement($sSituationRequirementRequirement)
		{		
			$aAllRequirement = self::consultSituationRequirement($sSituationRequirementRequirement);
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
							<h3 align ="center">Relatorio de Requisitos Por Situacao</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="9" align="center">Requisitos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Tipo</td>
												<td  align="center">Projeto </td>
												<td  align="center">Tarefa</td>
												<td  align="center">Nome</td>
												<td  align="center">Data De Inicio </td>
												<td  align="center">Data De Termino </td>
												<td  align="center">Importancia </td>
												<td  align="center">Situacao </td>
											</tr>
							 ';
			foreach ($aAllRequirement as $aRequirement) 
			{
				$aTypeRequirement = TypeRequirement::findTypeRequirement($aRequirement['TipoRequisito_idTipoRequisito']);
				$aTask = Task::findTask($aRequirement['Tarefa_idTarefa']);
				$aProject = Project::findProject($aRequirement['Projeto_idProjeto']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aRequirement['idRequisito'].' </td>
								<td align="center">'.$aTypeRequirement ['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aProject['nomeProjeto'].' </td>
								<td align="center">'.$aTask['nomeTarefa'].' </td>
								<td align="center">'.$aRequirement['nomeRequisito'].' </td>
								<td align="center">'.$aRequirement['dataInicioRequisito'].' </td>
								<td align="center">'.$aRequirement['dataTerminoRequisito'].' </td>	
								<td align="center">'.$aRequirement['importanciaRequisito'].' </td>	
								<td align="center">'.$aRequirement['situacaoRequisito'].' </td>		
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio De Requisitos Por Situacao.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportImportanceRequirement($sImportanceRequirement)
		{		
			$aAllRequirement = self::consultImportanceRequirement($sImportanceRequirement);
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
							<h3 align ="center">Relatorio de Requisitos Por Importancia</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="9" align="center">Requisitos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Tipo</td>
												<td  align="center">Projeto </td>
												<td  align="center">Tarefa</td>
												<td  align="center">Nome</td>
												<td  align="center">Data De Inicio </td>
												<td  align="center">Data De Termino </td>
												<td  align="center">Importancia </td>
												<td  align="center">Situacao </td>
											</tr>
							 ';
			foreach ($aAllRequirement as $aRequirement) 
			{
				$aTypeRequirement = TypeRequirement::findTypeRequirement($aRequirement['TipoRequisito_idTipoRequisito']);
				$aTask = Task::findTask($aRequirement['Tarefa_idTarefa']);
				$aProject = Project::findProject($aRequirement['Projeto_idProjeto']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aRequirement['idRequisito'].' </td>
								<td align="center">'.$aTypeRequirement ['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aProject['nomeProjeto'].' </td>
								<td align="center">'.$aTask['nomeTarefa'].' </td>
								<td align="center">'.$aRequirement['nomeRequisito'].' </td>
								<td align="center">'.$aRequirement['dataInicioRequisito'].' </td>
								<td align="center">'.$aRequirement['dataTerminoRequisito'].' </td>	
								<td align="center">'.$aRequirement['importanciaRequisito'].' </td>	
								<td align="center">'.$aRequirement['situacaoRequisito'].' </td>		
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio De Requisitos Por Importancia.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportApprovedProjectRequirement($iIdProject)
		{		
			$aAllRequirement = Project::findApprovedRequirements($iIdProject);
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
							<h3 align ="center">Relatorio de Requisitos Aprovados Do Projeto </h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="9" align="center">Requisitos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Tipo</td>
												<td  align="center">Projeto </td>
												<td  align="center">Tarefa</td>
												<td  align="center">Nome</td>
												<td  align="center">Data De Inicio </td>
												<td  align="center">Data De Termino </td>
												<td  align="center">Importancia </td>
												<td  align="center">Situacao </td>
											</tr>
							 ';
			foreach ($aAllRequirement as $aRequirement) 
			{
				$aTypeRequirement = TypeRequirement::findTypeRequirement($aRequirement['TipoRequisito_idTipoRequisito']);
				$aTask = Task::findTask($aRequirement['Tarefa_idTarefa']);
				$aProject = Project::findProject($aRequirement['Projeto_idProjeto']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aRequirement['idRequisito'].' </td>
								<td align="center">'.$aTypeRequirement ['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aProject['nomeProjeto'].' </td>
								<td align="center">'.$aTask['nomeTarefa'].' </td>
								<td align="center">'.$aRequirement['nomeRequisito'].' </td>
								<td align="center">'.$aRequirement['dataInicioRequisito'].' </td>
								<td align="center">'.$aRequirement['dataTerminoRequisito'].' </td>	
								<td align="center">'.$aRequirement['importanciaRequisito'].' </td>	
								<td align="center">'.$aRequirement['situacaoRequisito'].' </td>		
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Requisitos Aprovados Do Projeto.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportNotApprovedProjectRequirement($iIdProject)
		{		
			$aAllRequirement = Project::findNotApprovedRequirements($iIdProject);
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
							<h3 align ="center">Relatorio de Requisitos Em Avaliacao Do Projeto </h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="9" align="center">Requisitos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Tipo</td>
												<td  align="center">Projeto </td>
												<td  align="center">Tarefa</td>
												<td  align="center">Nome</td>
												<td  align="center">Data De Inicio </td>
												<td  align="center">Data De Termino </td>
												<td  align="center">Importancia </td>
												<td  align="center">Situacao </td>
											</tr>
							 ';
			foreach ($aAllRequirement as $aRequirement) 
			{
				$aTypeRequirement = TypeRequirement::findTypeRequirement($aRequirement['TipoRequisito_idTipoRequisito']);
				$aTask = Task::findTask($aRequirement['Tarefa_idTarefa']);
				$aProject = Project::findProject($aRequirement['Projeto_idProjeto']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aRequirement['idRequisito'].' </td>
								<td align="center">'.$aTypeRequirement ['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aProject['nomeProjeto'].' </td>
								<td align="center">'.$aTask['nomeTarefa'].' </td>
								<td align="center">'.$aRequirement['nomeRequisito'].' </td>
								<td align="center">'.$aRequirement['dataInicioRequisito'].' </td>
								<td align="center">'.$aRequirement['dataTerminoRequisito'].' </td>	
								<td align="center">'.$aRequirement['importanciaRequisito'].' </td>	
								<td align="center">'.$aRequirement['situacaoRequisito'].' </td>		
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Requisitos Em Avaliacao Do Projeto.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
	}