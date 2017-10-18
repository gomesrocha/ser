<?php
class Project
{
	private $iIdProject;
	private $iIdManager;
	private $sProjectName;
	private $dStartDate;
	private $dFinishDate;
	private $sProjectOverview;
	private $sProjectQuestionnaire;
	private $sStatusProject;
	
	function __construct($sProjectName,$iIdManager,$dStartDate,$dFinishDate,$sProjectOverview,$sProjectQuestionnaire =null,$sStatusProject)
	{
		$this->sProjectName 		 = $sProjectName;
		$this->iIdManager 		 	 = $iIdManager;
		$this->dStartDate 			 = $dStartDate;
		$this->dFinishDate			 = $dFinishDate;
		$this->sProjectOverview 	 = $sProjectOverview;
		$this->sProjectQuestionnaire = $sProjectQuestionnaire;
		$this->sStatusProject 		 = $sStatusProject;
	}
	
	public function getIdProject()
	{
		return $this->iIdProject;
	}
	
	public function getStatusProject()
	{
		return $this->sStatusProject;
	}
	
	public function getProjectName()
	{
		return $this->sProjectName;
	}
		
	public function getIdManager()
	{
		return $this->iIdManager;
	}
		
	public function getStartDate()
	{
		return $this->dStartDate;
	}
	
	public function getFinishDate()
	{
		return $this->dFinishDate;
	}
	
	public function getProjectOverview()
	{
		return $this->sProjectOverview;
	}
	
	public function getProjectQuestionnaire()
	{
		return $this->sProjectQuestionnaire;
	}
	
	public function setIdProject($iIdProject)
	{
		$this->iIdProject = $iIdProject;
	}
	
	public function setStatusProject($sStatusProject)
	{
		$this->sStatusProject = $sStatusProject;
	}

	public function setProjectName($sProjectName)
	{
		$this->sProjectName = $sProjectName;
	}
		
	public function setProjectManager($iIdManager)
	{
		$this->iIdManager = $iIdManager;
	}
	
	public function setStartDate($dStartDate)
	{
		$this->dStartDate = $dStartDate;
	} 
	
	public function setFinishDate($dFinishDate)
	{
		$this->dFinishDate = $dFinishDate;
	} 
	
	public function setProjectOverview($sProjectOverview)
	{
		$this->sProjectOverview = $sProjectOverview;
	} 
	
	public function setProjectQuestionnaire($sProjectQuestionnaire)
	{
		$this->sProjectQuestionnaire = $sProjectQuestionnaire;
	} 
	
	public static function allProject()
	{
		$iIdUser = new Sessao();
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
		$sQuery = "SELECT p.idProjeto,
						  p.Usuario_idUsuario,
						  p.nomeProjeto,
						  p.dataInicioProjeto,
						  p.dataTerminoProjeto,
						  p.statusProjeto
					FROM usuario u, projeto p
						WHERE u.idUsuario = p.Usuario_idUsuario AND u.idUsuario = ?  ";
		$ArrayParam = [$iIdUser->getSessao("iIdUser")];
		$aAllProject = $rDatabaseHandler->query($sQuery,$rConnection,$ArrayParam,true);	
		return $aAllProject;
	}
	
	public static function allUserProject()
	{
		$iIdUser = new Sessao();
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
		$sQuery = "SELECT  p.idProjeto,
						   p.Usuario_idUsuario,
						   p.nomeProjeto ,
						   p.dataInicioProjeto,
						   p.dataTerminoProjeto,
						   p.statusProjeto
				   FROM projeto p,
						linkarProjeto l 
					WHERE l.Usuario_idUsuario = ? AND l.projeto_idProjeto = p.idProjeto  ";
		$ArrayParam = [$iIdUser->getSessao("iIdUser")];
		$aAllProject = $rDatabaseHandler->query($sQuery,$rConnection,$ArrayParam,true);	
		return $aAllProject;
	}
	
	public static function reportStatusProject()
	{
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
		$sQuery = "SELECT statusProjeto,count(*) AS numero FROM projeto GROUP BY statusProjeto  ";
		$aStatusProject = $rDatabaseHandler->query($sQuery,$rConnection,null,true);	
		return $aStatusProject;
	}
	
	public static function reportManagerProject()
	{
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
		$sQuery = "SELECT u.nomeUsuario,count(*) AS numero FROM projeto p, usuario u where u.idUsuario = p.Usuario_idUsuario  GROUP BY u.idUsuario  ";
		$aStatusProject = $rDatabaseHandler->query($sQuery,$rConnection,null,true);	
		return $aStatusProject;
	}

	public static function researchProjectExist($oAddProject)
	{
		try
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM projeto WHERE nomeProjeto  = ? ";
			$aArrayParam = [$oAddProject->getProjectName()];
			$aExistProject = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			if (!empty($aExistProject))
			{
				echo "<script> 
							alert('Projeto Ja Foi Cadastrado !!!');
							window.location.href = '/ser/login/pageadddproject';
					</script>";
			}
		}
		catch(PDOException $e)
		{
			echo "Erro: ".$e->getMessage();
		}
	}
	
	public static function addProject($oProject)
	{
		self::researchProjectExist($oProject);
		try
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$rDatabaseHandler->begin($rConnection);
			$sQuery = "INSERT INTO projeto(	nomeProjeto ,
											Usuario_idUsuario ,
											dataInicioProjeto,
											dataTerminoProjeto,
											visaoGeralProjeto,
											statusProjeto,
											questionarioProjeto) 
						VALUES (?,?,?,?,?,?,?) ";
						
			$aArrayParam = [$oProject->getProjectName(),$oProject->getIdManager(),
							$oProject->getStartDate(),$oProject->getFinishDate(),$oProject->getProjectOverview(),
							$oProject->getStatusProject(),$oProject->getProjectQuestionnaire()];
			$rDatabaseHandler->add($sQuery,$rConnection,$aArrayParam);
			$rDatabaseHandler->commit($rConnection);
			$rConnection = $rDatabaseHandler->close($rConnection);
			echo "<script> 
						alert('Cadastro Feito Com Sucesso !!!');
						window.location.href = '/ser/login/pageaddproject';
			     </script>";
		}
		catch(PDOException $e)
		{
			$rDatabaseHandler->roolBack($rConnection);
			echo "Erro ao Cadastrar: ".$e->getMessage();
		}
	}
	
	public static function removeProject($iIdProject)
	{
		try
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$rDatabaseHandler->begin($rConnection);
			$sQuery = "DELETE FROM projeto WHERE idProjeto  = ? ";
			$aArrayParam = [$iIdProject];
	    	$lDeleted = $rDatabaseHandler->deleteDate($sQuery,$rConnection,$aArrayParam);
			if($lDeleted)
			{
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				echo "<script> 
					alert('Projeto Deletado Com Sucesso !!!');
					window.location.href = '/ser/login/pagevisualizeproject';
				</script>";
			}	
		}
		catch(PDOException $e)
		{
			echo "Erro ao Deletar: ".$e->getMessage();
		}
	}
	
	public static function allLinkProject()
	{
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
    	$sQuery = "SELECT l.Usuario_idUsuario,
						  l.projeto_idProjeto ,
						  p.nomeProjeto 
				    FROM linkarProjeto l,
						 usuario u,projeto p 
					WHERE l.projeto_idprojeto = p.idProjeto AND 
						  l.Usuario_idUsuario = u.idUsuario order by u.idUsuario  ";
		$aProject = $rDatabaseHandler->query($sQuery,$rConnection,null,true);
		return $aProject;		
	}
	
	public static function findAllUserLinkProject($iIdUser)
	{
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
    	$sQuery = "SELECT l.Usuario_idUsuario,
						  l.projeto_idProjeto 
				    FROM linkarProjeto l 
					WHERE l.Usuario_idUsuario = ? ";
		$aArrayParam = [$iIdUser];
		$aProject = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
		return $aProject;		
	}
	
	public static function findUserLinkProject($iIdUser)
	{
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
    	$sQuery = "SELECT l.Usuario_idUsuario,
						  l.projeto_idProjeto 
				    FROM linkarProjeto l 
					WHERE l.Usuario_idUsuario = ? ";
		$aArrayParam = [$iIdUser];
		$aProject = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
		return $aProject;		
	}

	public static function findProject($iIdProject)
	{
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
    	$sQuery = "SELECT * FROM projeto where idProjeto  = ?  ";
		$aArrayParam = [$iIdProject];
		$aProject = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
		return $aProject;		
	}
	
	public static function findEditProject()
	{
		$iEdit = new Sessao();
		$iId = $iEdit->getSessao("editProject");
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
    	$sQuery = "SELECT * FROM projeto where idProjeto  = ?  ";
		$aArrayParam = [$iId];
		$aProject = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
		return $aProject;		
	}

	public static function updateProject($oProject)
	{
		try
		{   
			$iEdit = new Sessao();
			$iId = $iEdit->getSessao("editProject"); 
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$rDatabaseHandler->begin($rConnection);
			$sQuery = "UPDATE projeto SET 
									   nomeProjeto = ?,
									   Usuario_idUsuario = ? ,
									   dataInicioProjeto = ?,
									   dataTerminoProjeto = ?,
									   visaoGeralProjeto = ?,
									   statusProjeto = ?,
									   questionarioProjeto = ?
							where idProjeto = ? ";
			$aArrayParam = [$oProject->getProjectName(),$oProject->getIdManager(),
							$oProject->getStartDate(),$oProject->getFinishDate(),$oProject->getProjectOverview(),
							$oProject->getStatusProject(),$oProject->getProjectQuestionnaire()];
			$aArrayCondicao = [$iId];
			$rDatabaseHandler->update($sQuery,$rConnection,$aArrayParam,$aArrayCondicao);
			$rDatabaseHandler->commit($rConnection);
			$rConnection = $rDatabaseHandler->close($rConnection);
			echo "<script> 
					alert('Projeto Alterado Com Sucesso !!!');
					window.location.href = '/ser/login/pagevisualizeproject';
				  </script>";		
		}	
		catch(PDOException $e)
		{
			$rDatabaseHandler->roolBack($rConnection);
			echo "Erro ao Atualizar: ".$e->getMessage();
		}
	}	
	
	public static function allUsersLinkProject()
	{
		$iIdProject = new Sessao();
		$iId = $iIdProject->getSessao("linkProject");
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
		$sQuery = " select * from linkarProjeto l,
								  usuario u 
						where u.idUsuario = l.Usuario_idUsuario and l.projeto_idProjeto  = ?";
		$aArrayParam = [$iId];
		$aUser = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
		if (empty($aUser))
		{
			echo "<script> 
						alert('Não Há Usuarios Vinculados Ao Projeto !!!');
						window.location.href = '/ser/login/pageremovelinkproject';
				  </script>";	
		}
		return $aUser;
	}

	public static function findManager($iIdUser)
	{
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
		$sQuery = "SELECT p.nomeProjeto ,
						  p.Usuario_idUsuario,
						  u.nomeUsuario,
						  p.idProjeto,
						  u.tipoUsuario
		  		   FROM projeto p,
						usuario u
				   WHERE p.Usuario_idUsuario = ?";
		$aArrayParam = [$iIdUser];
		$aUser = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
		return $aUser;
	}
	
	public static function consultAllProjectManager($iIdUser)
	{
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
		$sQuery = "SELECT p.nomeProjeto ,
						p.Usuario_idUsuario,
						u.nomeUsuario,
						p.idProjeto ,p.dataInicioProjeto ,p.dataTerminoProjeto ,p.statusProjeto 
					FROM projeto p,usuario u
						WHERE u.idUsuario = p.Usuario_idUsuario
							and p.Usuario_idUsuario = ?";
		$aArrayParam = [$iIdUser];
		$aUser = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
		return $aUser;
	}

	public static function findRequirements($iIdProject)
	{
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
		$sQuery = "SELECT * FROM requisito WHERE projeto_idProjeto  = ?";
		$aArrayParam = [$iIdProject];
		$aRequirement = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
		return $aRequirement;
	}
	
	public static function findNotApprovedRequirements($iIdProject)
	{
		try
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM requisito WHERE projeto_idProjeto  = ? AND situacaoRequisito = 'avaliacao'";
			$aArrayParam = [$iIdProject];
			$aRequirement = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
			if(empty($aRequirement))
			{
				echo "<script> 
						alert('Nenhum Requisito Não Aprovado no Projeto !!!');
						window.location.href = '/ser/login/pagekeyuservisualizeproject';
					</script>";	
			}
			return $aRequirement;
		}
		catch(PDOException $e)
		{
			$rDatabaseHandler->roolBack($rConnection);
			echo "Erro : ".$e->getMessage();
		}
	}
	
	public static function findApprovedRequirements($iIdProject)
	{
		try
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM requisito WHERE projeto_idProjeto  = ? AND situacaoRequisito = 'aprovado'";
			$aArrayParam = [$iIdProject];
			$aRequirement = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
			if(empty($aRequirement))
			{
				echo "<script> 
						alert('Nenhum Requisito Aprovado no Projeto !!!');
						window.location.href = '/ser/login/pagedevelopervisualizeproject';
					</script>";	
			}
			return $aRequirement;
		}
		catch(PDOException $e)
		{
			$rDatabaseHandler->roolBack($rConnection);
			echo "Erro : ".$e->getMessage();
		}
	}
		
	public static function researchManagerProject($iIdProject)
	{
		$aJson = CommonFunctions::readJSON("database/.config.json");
		$rDatabaseHandler = new SerDatabaseHandler($aJson);
		$rConnection = $rDatabaseHandler->getInstance();
		$sQuery = "SELECT * FROM projeto p WHERE p.idProjeto = ?";
		$aArrayParam = [$iIdProject];
		$aUser = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);				
		return $aUser;
	}
	
	public static function consultStatusProjects($sStatusProject)
	{
		try
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM projeto where statusProjeto  = ?";
			$aArrayParam = [$sStatusProject];
			$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
			if (empty($aReport))
			{
				echo "<script> 
						alert('Nenhum Projeto Com Esse Status !!!');
						window.location.href = '/ser/login/pagereportstatusproject';
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
	
	public static function consultStartDateProjects($sStartDateProjects)
	{
		try
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM projeto WHERE  str_to_date(dataInicioProjeto ,'%d/%m/%Y') >= ? order by dataInicioProjeto ";
			$aArrayParam = [$sStartDateProjects];
			$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
			if (!empty($aReport))
			{
				return $aReport;
			}
			else
			{
				echo "<script> 
						alert('Nenhum Projeto Com Essa A Partir desta Data De Inicio !!!');
						window.location.href = '/ser/login/pagereportstartdateproject';
					</script>";	
			}
		}
		catch(PDOException $e)
		{
			$rDatabaseHandler->roolBack($rConnection);
			echo "Erro : ".$e->getMessage();
		}
	}
	
	public static function consultFinishDateProjects($sFinishDateProjects)
	{
		try
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM projeto WHERE  str_to_date(dataTerminoProjeto ,'%d/%m/%Y') >= ? order by dataTerminoProjeto ";
			$aArrayParam = [$sFinishDateProjects];
			$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
			if (!empty($aReport))
			{
				return $aReport;
			}
			else
			{
				echo "<script> 
						alert('Nenhum Projeto Com Essa A Partir desta Data De Termino !!!');
						window.location.href = '/ser/login/pagereportfininshproject';
					</script>";	
			}
		}
		catch(PDOException $e)
		{
			$rDatabaseHandler->roolBack($rConnection);
			echo "Erro : ".$e->getMessage();
		}
	}
	
	public static function consultProjectPeriod($sProjectDateStart,$sProjectDateFinish)
	{
		try
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM projeto WHERE str_to_date(dataInicioProjeto ,'%d/%m/%Y') AND str_to_date(dataTerminoProjeto ,'%d/%m/%Y')  BETWEEN ? AND ?";
			$aArrayParam = [$sProjectDateStart,$sProjectDateFinish];
			$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
			if (!empty($aReport))
			{
				return $aReport;
			}
			else
			{
				echo "<script> 
						alert('Nenhum Projeto Com Esse Periodo !!!');
						window.location.href = '/ser/login/pagereportperiodproject';
					</script>";		
			}
		}
		catch(PDOException $e)
		{
			$rDatabaseHandler->roolBack($rConnection);
			echo "Erro : ".$e->getMessage();
		}
	}
	
	public static function createReportStatusProjects($sStatusProject)
	{		
		$aStatusProject = self::consultStatusProjects($sStatusProject);
		try
		{
			
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
										<h3 align ="center">Relatorio de Projetos Por Situacao</h3>
                           
										<table border="1" align="center" class="table">

										<tr>
											<th colspan="6" align="center">Projetos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Gerente</td>
												<td  align="center">Nome </td>
												<td  align="center">Data Inicio</td>
												<td  align="center">Data de Término</td>
												<td  align="center">Status do projeto </td>
				
											</tr>
							 ';
							foreach ($aStatusProject as $aProject) 
							{
								$oManager = User::findUser($aProject['Usuario_idUsuario']);			
								$sHTML.= '
											<tr>
												<td align="center">'.$aProject['idProjeto'].' </td>
												<td align="center">'.$oManager ['nomeUsuario'].'  </td>
												<td align="center">'.$aProject['nomeProjeto'].' </td>
												<td align="center">'.$aProject['dataInicioProjeto'].' </td>
												<td align="center">'.$aProject['dataTerminoProjeto'].' </td>
												<td align="center">'.$aProject['statusProjeto'].' </td>	
											</tr>
										';
							}
							$sHTML.=' 		</table>
									</body>
								</html>';
							$arquivo = "sitprojetos.pdf";
							$mpdf = new mPDF();
							$mpdf->WriteHTML($sHTML);	
							$mpdf->Output($arquivo,'I');							
		}
		catch(PDOException $e)
		{
			echo "Erro : ".$e->getMessage();
		}
		
	}

	public static function createAllReportProjects()
	{		
		$aStatusProject = self::allProject();
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
							<h3 align ="center">Relatorio de Projetos</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="6" align="center">Projetos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Gerente</td>
												<td  align="center">Nome </td>
												<td  align="center">Data Inicio</td>
												<td  align="center">Data de Término</td>
												<td  align="center">Status do projeto </td>
				
											</tr>
							 ';
		foreach ($aStatusProject as $aProject) 
		{
			$oManager = User::findUser($aProject['Usuario_idUsuario']);		
			$sHTML.= '
						<tr>
							<td align="center">'.$aProject['idProjeto'].' </td>
							<td align="center">'.$oManager ['nomeUsuario'].'  </td>
							<td align="center">'.$aProject['nomeProjeto'].' </td>
							<td align="center">'.$aProject['dataInicioProjeto'].' </td>
							<td align="center">'.$aProject['dataTerminoProjeto'].' </td>
							<td align="center">'.$aProject['statusProjeto'].' </td>	
						</tr>
					';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os Projetos.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);
			$mpdf->Output($arquivo,'I');
	}
	
	public static function createReportManagerProjects($iIdUser)
	{		
		$aAllProject = self::consultAllProjectManager($iIdUser);
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
							<h3 align ="center">Relatorio de Projetos Por Gerente</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="6" align="center">Projetos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Gerente</td>
												<td  align="center">Nome </td>
												<td  align="center">Data Inicio</td>
												<td  align="center">Data de Término</td>
												<td  align="center">Status do projeto </td>
				
											</tr> ';
		foreach ($aAllProject as $aProject) 
		{
			$oManager = User::findUser($aProject['Usuario_idUsuario']);			
			$sHTML.= '
						<tr>
							<td align="center">'.$aProject['idProjeto'].' </td>
							<td align="center">'.$oManager ['nomeUsuario'].'  </td>
							<td align="center">'.$aProject['nomeProjeto'].' </td>
							<td align="center">'.$aProject['dataInicioProjeto'].' </td>
							<td align="center">'.$aProject['dataTerminoProjeto'].' </td>
							<td align="center">'.$aProject['statusProjeto'].' </td>	
						</tr>
						';
		}
		$sHTML.='	</table>
				   </body>
					</html>';
			$arquivo = "Relatorio de projetos Por Gerente.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
	}
	
	public static function createReportProjectDateStart($sProjectDateStart)
	{		
		$aAllProjectDateStart = self::consultStartDateProjects($sProjectDateStart);
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
							<h3 align ="center">Relatorio de Projetos Por Data de Inicio</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="6" align="center">Projetos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Gerente</td>
												<td  align="center">Nome </td>
												<td  align="center">Data Inicio</td>
												<td  align="center">Data de Término</td>
												<td  align="center">Status do projeto </td>
				
											</tr> ';
		foreach ($aAllProjectDateStart as $aProject) 
		{
			$oManager = User::findUser($aProject['Usuario_idUsuario']);			
			$sHTML.= '
						<tr>
							<td align="center">'.$aProject['idProjeto'].' </td>
							<td align="center">'.$oManager ['nomeUsuario'].'  </td>
							<td align="center">'.$aProject['nomeProjeto'].' </td>
							<td align="center">'.$aProject['dataInicioProjeto'].' </td>
							<td align="center">'.$aProject['dataTerminoProjeto'].' </td>
							<td align="center">'.$aProject['statusProjeto'].' </td>	
						</tr>
						';
		}
		$sHTML.='	</table>
				   </body>
					</html>';
		$arquivo = "Relatorio de projetos Por Data de Inicio.pdf";
		$mpdf = new mPDF();
		$mpdf->WriteHTML($sHTML);	
		$mpdf->Output($arquivo,'I');
	}
	
	public static function createReportProjectDateFinish($sProjectDateFinish)
	{		
		$aAllProjectDateFinish = self::consultFinishDateProjects($sProjectDateFinish);
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
							<h3 align ="center">Relatorio de Projetos Por Data de Termino</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="6" align="center">Projetos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Gerente</td>
												<td  align="center">Nome </td>
												<td  align="center">Data Inicio</td>
												<td  align="center">Data de Término</td>
												<td  align="center">Status do projeto </td>
				
											</tr> ';
		foreach ($aAllProjectDateFinish as $aProject) 
		{
			$oManager = User::findUser($aProject['Usuario_idUsuario']);			
			$sHTML.= '
						<tr>
							<td align="center">'.$aProject['idprojeto'].' </td>
							<td align="center">'.$oManager ['nomeUsuario'].'  </td>
							<td align="center">'.$aProject['nomeProjeto'].' </td>
							<td align="center">'.$aProject['dataInicioProjeto'].' </td>
							<td align="center">'.$aProject['dataTerminoProjeto'].' </td>
							<td align="center">'.$aProject['statusProjeto'].' </td>	
						</tr>
						';
		}
		$sHTML.='	</table>
				   </body>
					</html>';
		$arquivo = "Relatorio de projetos Por Data de Inicio.pdf";
		$mpdf = new mPDF();
		$mpdf->WriteHTML($sHTML);	
		$mpdf->Output($arquivo,'I');
	}
	
	public static function createReportProjectPeriod($sProjectDateStart,$sProjectDateFinish)
	{		
		$aAllProjectPeriod = self::consultProjectPeriod($sProjectDateStart,$sProjectDateFinish);
		try
		{
			
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
							<h3 align ="center">Relatorio de Projetos Por Periodo</h3>
                           
                                    <table border="1" align="center" class="table">

										<tr>
											<th colspan="6" align="center">Projetos</th>
										</tr>
											
											<tr>
												<td  align="center">ID</td>
												<td  align="center">Gerente</td>
												<td  align="center">Nome </td>
												<td  align="center">Data Inicio</td>
												<td  align="center">Data de Término</td>
												<td  align="center">Status do projeto </td>
				
											</tr> ';
				foreach ($aAllProjectPeriod as $aProject) 
				{
					$oManager = User::findUser($aProject['Usuario_idUsuario']);			
					$sHTML.= '
						<tr>
							<td align="center">'.$aProject['idProjeto'].' </td>
							<td align="center">'.$oManager ['nomeUsuario'].'  </td>
							<td align="center">'.$aProject['nomeProjeto'].' </td>
							<td align="center">'.$aProject['dataInicioProjeto'].' </td>
							<td align="center">'.$aProject['dataTerminoProjeto'].' </td>
							<td align="center">'.$aProject['statusProjeto'].' </td>	
						</tr>
						';
				}
				$sHTML.='	</table>
						</body>
						</html>';
				$arquivo = "Relatorio de projetos Por Periodo.pdf";
				$mpdf = new mPDF();
				$mpdf->WriteHTML($sHTML);	
				$mpdf->Output($arquivo,'I');
		}
		catch(PDOException $e)
		{
			$rDatabaseHandler->roolBack($rConnection);
			echo "Erro : ".$e->getMessage();
		}
	}
}


