<?php
	
	class Diagram
	{
		private $iIdDiagram;
		private $iIdProject;
		private $sDiagramName;
		private $sDiagramPath;
		private $iIdActor;
		
		function __construct($iIdProject,$iIdActor,$sDiagramName,$sDiagramPath)
		{
			$this->iIdProject 	 = $iIdProject;
			$this->sDiagramName  = $sDiagramName;
			$this->sDiagramPath  = $sDiagramPath;
			$this->iIdActor  	 = $iIdActor;
		}
		
		public function getIdProject()
		{
			return $this->iIdProject;
		}
	
		public function getDiagramName()
		{
			return $this->sDiagramName;
		}
		
		public function getDiagramPath()
		{
			return $this->sDiagramPath;
		}
		
		public function getIdActor()
		{
			return $this->iIdActor;
		}
		
		public function setIdActor ($iIdActor )
		{
			$this->iIdActor  = $iIdActor ;
		}

		public function setDiagramName($sDiagramName)
		{
			$this->sDiagramName = $sDiagramName;
		}

		public function setDiagramPath($sDiagramPath)
		{
			$this->sDiagramPath = $sDiagramPath;
		}
		
		public static function researchDiagramExist($oDiagram)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM diagrama WHERE nomeDiagrama = ? ";
				$aArrayParam = [$oDiagram->getDiagramName()];
				$aExistDiagram = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (!empty($aExistDiagram))
				{
					echo "<script> 
							alert('Diagrama Ja Foi Cadastrado !!!');
							window.location.href = '/ser/login/pageadddiagram';
					</script>";
				}
			}
			catch(PDOException $e)
			{
				echo "Erro: ".$e->getMessage();
			}
		}
		
		public static function addDiagram($oDiagram)
		{
			self::researchDiagramExist($oDiagram);
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "INSERT INTO diagrama(Projeto_idProjeto, Ator_idAtor, nomeDiagrama,imgDiagrama) 
							VALUES (?,?,?,?) ";
				$aArrayParam = [$oDiagram->getIdProject(),$oDiagram->getIdActor(),$oDiagram->getDiagramName(),$oDiagram->getDiagramPath()];
				$rDatabaseHandler->add($sQuery,$rConnection,$aArrayParam);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				echo "<script> 
							alert('Cadastro Feito Com Sucesso !!!');
							window.location.href = '/ser/login/pageadddiagram';
					  </script>";
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Cadastrar: ".$e->getMessage();
			}
		}
		
		public static function updateDiagram($oDiagram)
		{
			try
			{   
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editDiagram"); 
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "UPDATE diagrama SET 
									   Projeto_idProjeto = ?,
									   Ator_idAtor = ?,
									   nomeDiagrama = ?,
									   imgDiagrama = ?
							WHERE idDiagrama = ? ";
				$aArrayParam = [$oDiagram->getIdProject(),$oDiagram->getIdActor(),$oDiagram->getDiagramName(),$oDiagram->getDiagramPath()];
				$aArrayCondicao = [$iId];
				$rDatabaseHandler->update($sQuery,$rConnection,$aArrayParam,$aArrayCondicao);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				echo "<script> 
						alert('Diagrama Alterado Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizediagram';
					</script>";		
			}	
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Atualizar: ".$e->getMessage();
			}	
		}
	
		public static function removeDiagram($iIdDiagram)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "DELETE FROM diagrama WHERE idDiagrama = ? ";
				$aArrayParam = [$iIdDiagram];
				$lDeleted = $rDatabaseHandler->deleteDate($sQuery,$rConnection,$aArrayParam);
				if($lDeleted)
				{
					$rDatabaseHandler->commit($rConnection);
					$rConnection = $rDatabaseHandler->close($rConnection);
					echo "<script> 
						alert('Requisito Deletado Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizediagram';
					</script>";
				}	
			}
			catch(PDOException $e)
			{
				echo "Erro ao Deletar: ".$e->getMessage();
			}	
		}
		
		public static function allDiagram()
		{	
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM diagrama order by idDiagrama";
			$aAllDiagram = $rDatabaseHandler->query($sQuery,$rConnection,null,true);	
			return $aAllDiagram;
		}
		
		public static function findEditDiagram()
		{
			$iEdit = new Sessao();
			$iId = $iEdit->getSessao("editDiagram");
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM diagrama where idDiagrama = ? order by idDiagrama  ";
			$aArrayParam = [$iId];
			$aDiagram = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aDiagram;		
		}
		
		public static function findDiagram($iIdDiagram)
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM diagrama where idDiagrama = ? order by idDiagrama  ";
			$aArrayParam = [$iIdDiagram];
			$aDiagram = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aDiagram;		
		}
		
		public static function allDiagramProject($iIdProject)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM diagrama where Projeto_idProjeto = ?  ";
				$aArrayParam = [$iIdProject];
				$aAllDiagramProject = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
				if(empty($aAllDiagramProject))
				{
					echo "<script> 
							alert('Nenhum Diagrama Associado Ao Projeto !!!');
							window.location.href = '/ser/login/pagereportdiagramproject';
					</script>";
				}
				return $aAllDiagramProject;
			}
			catch(PDOException $e)
			{
				echo "Erro ao Deletar: ".$e->getMessage();
			}	
		}
		
		public static function createAllReportDiagram()
		{		
			$aAllDiagram = self::allDiagram();
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
								<h3 align ="center">Relatorio de Todos Os Diagramas </h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="5" align="center">Diagramas</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center"> Projeto</td>
										<td  align="center">Ator</td>
										<td  align="center">Nome</td>
										<td  align="center">Imagem</td>
									</tr> ';
			foreach ($aAllDiagram as $aDiagram) 
			{   
				$oProject = Project::findProject($aDiagram['Projeto_idProjeto']);
				$oAtor = Actor::findActor($aDiagram['Ator_idAtor']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aDiagram['idDiagrama'].' </td>
								<td align="center">'.$oProject['nomeProjeto'].'  </td>
								<td align="center">'.$oAtor['nomeAtor'].' </td>
								<td align="center">'.$aDiagram['nomeDiagrama'].' </td>
								<td align="center">'.$aDiagram['imgDiagrama'].' </td>								
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os Diagramas.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportDiagramProject($iIdProject)
		{		
			$aAllDiagramProject = self::allDiagramProject($iIdProject);
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
								<h3 align ="center">Relatorio de Todos Os Diagramas Por Projeto</h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="5" align="center">Diagramas</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center"> Projeto</td>
										<td  align="center">Ator</td>
										<td  align="center">Nome</td>
										<td  align="center">Imagem</td>
									</tr> ';
			foreach ($aAllDiagramProject as $aDiagram) 
			{
				$oProject = Project::findProject($aDiagram['Projeto_idProjeto']);
				$oAtor = Actor::findActor($aDiagram['Ator_idAtor']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aDiagram['idDiagrama'].' </td>
								<td align="center">'.$oProject['nomeProjeto'].'  </td>
								<td align="center">'.$oAtor['nomeAtor'].' </td>
								<td align="center">'.$aDiagram['nomeDiagrama'].' </td>
								<td align="center">'.$aDiagram['imgDiagrama'].' </td>								
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os Diagramas Por Projeto.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
	}