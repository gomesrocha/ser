<?php
	
	class UseCase
	{
		private $iIdUseCase;
		private $iIdDiagram;
		private $sUseCaseName;
		private $sUseCaseFlow;
		private $sUseCaseResume;
		private $sUseCasePrecondition;
		private $sUseCasePoscondition;
		private $sUseCaseAlternativeFlow;
		private $sUseCaseException;
		private $sUseCaseBusinessRule;
		
		function __construct($iIdDiagram,$sUseCaseName,$sUseCaseFlow,$sUseCaseResume,
							 $sUseCasePrecondition,$sUseCasePoscondition = null,$sUseCaseAlternativeFlow,
							 $sUseCaseException = null,$sUseCaseBusinessRule = null)
		{
			$this->iIdDiagram 				= $iIdDiagram;
			$this->sUseCaseName 			= $sUseCaseName;
			$this->sUseCaseFlow 			= $sUseCaseFlow;
			$this->sUseCaseResume 			= $sUseCaseResume;
			$this->sUseCasePrecondition		= $sUseCasePrecondition;
			$this->sUseCasePoscondition 	= $sUseCasePoscondition;
			$this->sUseCaseAlternativeFlow 	= $sUseCaseAlternativeFlow;
			$this->sUseCaseException 		= $sUseCaseException;
			$this->sUseCaseBusinessRule 	= $sUseCaseBusinessRule;
		}
		
		public function getIdDiagram()
		{
			return $this->iIdDiagram;
		}
		
		public function getUseCaseName()
		{
			return $this->sUseCaseName;
		}
		
		public function getUseCaseFlow()
		{
			return $this->sUseCaseFlow;
		}
	
		public function getUseCaseResume()
		{
			return $this->sUseCaseResume;
		}
		
		public function getUseCasePrecondition()
		{
			return $this->sUseCasePrecondition;
		}
		
		public function getUseCasePoscondition()
		{
			return $this->sUseCasePoscondition;
		}
		
		public function getUseCaseAlternativeFlow()
		{
			return $this->sUseCaseAlternativeFlow;
		}
		
		public function getUseCaseException()
		{
			return $this->sUseCaseException;
		}
		
		public function getUseCaseBusinessRule()
		{
			return $this->sUseCaseBusinessRule;
		}

		public function setIdDiagram($iIdDiagram)
		{
			$this->iIdDiagram = $iIdDiagram;
		}
		
		public function setUseCaseName($sUseCaseName)
		{
			$this->sUseCaseName = $sUseCaseName;
		}
		
		public function setUseCaseFlow($sUseCaseFlow)
		{
			$this->sUseCaseFlow = $sUseCaseFlow;
		}

		public function setUseCaseResume($sUseCaseResume)
		{
			$this->sUseCaseResume = $sUseCaseResume;
		}
		
		public function setUseCasePrecondition($sUseCasePrecondition)
		{
			$this->sUseCasePrecondition = $sUseCasePrecondition;
		}

		public function setUseCasePoscondition($sUseCasePoscondition)
		{
			$this->sUseCasePoscondition = $sUseCasePoscondition;
		}
		
		public function setUseCaseAlternativeFlow($sUseCaseAlternativeFlow)
		{
			$this->sUseCaseAlternativeFlow = $sUseCaseAlternativeFlow;
		}
		
		public function setUseCaseException($sUseCaseException)
		{
			$this->sUseCaseException = $sUseCaseException;
		}
		
		public function setUseCaseBusinessRule($sUseCaseBusinessRule)
		{
			$this->sUseCaseBusinessRule = $sUseCaseBusinessRule;
		}
		
		public static function allUseCase()
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM casoDeUso order by idCasoDeUso ";
			$aAllUseCase = $rDatabaseHandler->query($sQuery,$rConnection,null,true);	
			return $aAllUseCase;
		}
		
		public static function researchUseCaseExist($oAddUseCase)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM casoDeUso WHERE nomeCasoDeUso = ? ";
				$aArrayParam = [$oAddUseCase->getUseCaseName()];
				$aExistUseCase = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
				if (!empty($aExistUseCase))
				{
					echo "<script> 
									alert('Caso de Uso Ja Foi Cadastrado !!!');
									window.location.href = '/ser/login/pageaddusecase';
						 </script>";
				}
			}
			catch(PDOException $e)
			{
				echo "Erro: ".$e->getMessage();
			}
		}
		
		public static function addUseCase($oUseCase)
		{
			self::researchUseCaseExist($oUseCase);
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "INSERT INTO casoDeUso(Diagrama_idDiagrama,nomeCasoDeUso,fluxoCasoDeUso,
												 resumoCasoDeUso,precondicaoCasoDeUso,fluxoAltCasoDeUso,
												 excecaoCasoDeUso,posCondicaoCasoDeUso,regraNegocioCasoDeUso) 
							VALUES (?,?,?,?,?,?,?,?,?) ";
				$aArrayParam = [$oUseCase->getIdDiagram(),$oUseCase->getUseCaseName(),$oUseCase->getUseCaseFlow(),
								$oUseCase->getUseCaseResume(),$oUseCase->getUseCasePrecondition(),$oUseCase->getUseCaseAlternativeFlow(),
								$oUseCase->getUseCaseException(),$oUseCase->getUseCasePoscondition(),$oUseCase->getUseCaseBusinessRule()];
				$rDatabaseHandler->add($sQuery,$rConnection,$aArrayParam);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				echo "<script> 
							alert('Cadastro Feito Com Sucesso !!!');
							window.location.href = '/ser/login/pageaddusecase';
					  </script>";
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Cadastrar: ".$e->getMessage();
			}
		}
		
		public static function findEditUseCase()
		{
			try
			{
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editUseCase");
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM casoDeUso WHERE idCasoDeUso = ? ";
				$aArrayParam = [$iId];
				$aUseCaseEdit = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (empty($aUseCaseEdit))
				{
					echo "<script> 
							alert('Caso de Uso Não Encontrada !!!');
							window.location.href = '/ser/login/pagevisualizeusecase';
					  </script>";
				
				}
				return $aUseCaseEdit;
			
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		public static function findUseCase($iIdUseCase)
		{
			try
			{
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editUseCase");
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM casoDeUso WHERE idCasoDeUso = ? ";
				$aArrayParam = [$iIdUseCase];
				$aUseCase = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (empty($aUseCase))
				{
					echo "<script> 
							alert('Caso de Uso Não Encontrada !!!');
							window.location.href = '/ser/login/pagevisualizeusecase';
					  </script>";
				
				}
				return $aUseCase;
			
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		public static function updateUseCase($oUseCase)
		{
			try
			{   
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editUseCase"); 
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "UPDATE casoDeUso SET 
										   Diagrama_idDiagrama = ?,
						       			   nomeCasoDeUso =?,
						       			   fluxoCasoDeUso = ?,
										   resumoCasoDeUso = ?,
										   precondicaoCasoDeUso = ?,
										   fluxoAltCasoDeUso = ?,
										   excecaoCasoDeUso = ?,
										   posCondicaoCasoDeUso = ?,
										   regraNegocioCasoDeUso = ?
								where idCasoDeUso = ? ";
				$aArrayParam = [$oUseCase->getIdDiagram(),$oUseCase->getUseCaseName(),
								$oUseCase->getUseCaseFlow(),$oUseCase->getUseCaseResume(),
								$oUseCase->getUseCasePrecondition(),$oUseCase->getUseCaseAlternativeFlow(),$oUseCase->getUseCaseException(),
								$oUseCase->getUseCasePoscondition(),$oUseCase->getUseCaseBusinessRule()];
				
							
				$aArrayCondicao = [$iId];
				$rDatabaseHandler->update($sQuery,$rConnection,$aArrayParam,$aArrayCondicao);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				echo "<script> 
						alert('Caso de Uso Alterada Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizeusecase';
					  </script>";		
			}	
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Atualizar: ".$e->getMessage();
			}
		}	
		
		public static function removeUseCase($iIdUseCase)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "DELETE FROM casoDeUso WHERE idCasoDeUso = ? ";
				$aArrayParam = [$iIdUseCase];
				$lDeleted = $rDatabaseHandler->deleteDate($sQuery,$rConnection,$aArrayParam);
				if($lDeleted)
				{
					$rDatabaseHandler->commit($rConnection);
					$rConnection = $rDatabaseHandler->close($rConnection);
					echo "<script> 
						alert('Caso de Uso Deletado Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizeusecase';
					</script>";
				}	
			}
			catch(PDOException $e)
			{
				echo "Erro ao Deletar: ".$e->getMessage();
			}
		}	
		
		public static function allUseCaseDiagram($iIdDiagram)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM casoDeUso WHERE Diagrama_idDiagrama = ? ";
				$aArrayParam = [$iIdDiagram];
				$aUseCase = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
				if (empty($aUseCase))
				{
					echo "<script> 
						alert('Nenhum Caso De Uso Associado Ao Diagrama !!!');
						window.location.href = '/ser/login/pagedefaultanalyst';
					</script>";	
				}
				return $aUseCase;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		public static function createAllReportUseCase()
		{		
			$aAllUseCase = self::allUseCase();
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
								<h3 align ="center">Relatorio de Todos Os Casos De Uso </h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="4" align="center">Casos De Uso</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center"> Diagrama</td>
										<td  align="center">Nome</td>
										<td  align="center">Resumo</td>
									</tr> ';
			foreach ($aAllUseCase as $aUseCase) 
			{
				$aDiagram = Diagram::findDiagram($aUseCase['Diagrama_idDiagrama']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aUseCase['idCasoDeUso'].' </td>
								<td align="center">'.$aDiagram['nomeDiagrama'].'  </td>
								<td align="center">'.$aUseCase['nomeCasoDeUso'].' </td>
								<td align="center">'.$aUseCase['resumoCasoDeUso'].' </td>								
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os Casos De Uso.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportUseCaseDiagram($iIdDiagram)
		{		
			$aAllUseCaseDiagram = self::allUseCaseDiagram($iIdDiagram);
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
								<h3 align ="center">Relatorio De Casos De Uso Por Diagrama </h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="4" align="center">Casos De Uso</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center"> Diagrama</td>
										<td  align="center">Nome</td>
										<td  align="center">Resumo</td>
									</tr> ';
			foreach ($aAllUseCaseDiagram as $aUseCase) 
			{
				$aDiagram = Diagram::findDiagram($aUseCase['Diagrama_idDiagrama']);
				$sHTML.= '
							<tr>
								<td align="center">'.$aUseCase['idCasoDeUso'].' </td>
								<td align="center">'.$aDiagram['nomeDiagrama'].'  </td>
								<td align="center">'.$aUseCase['nomeCasoDeUso'].' </td>
								<td align="center">'.$aUseCase['resumoCasoDeUso'].' </td>								
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os Casos De Uso Por Diagrama.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
	}