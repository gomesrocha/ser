<?php
	
	class Actor
	{
		private $iIdActor;
		private $sActorName;
		private $sActorDescription;
		
		function __construct($sActorName,$sActorDescription)
		{
			$this->sActorName = $sActorName;
			$this->sActorDescription  = $sActorDescription;
		}
		
		public function getIdActor()
		{
			return $this->iIdActor;
		}
	
		public function getActorName()
		{
			return $this->sActorName;
		}
		
		public function getActorDescription()
		{
			return $this->sActorDescription;
		}
		
		public function setActorName($sActorName)
		{
			$this->sActorName = $sActorName;
		}

		public function setActorDescription($sActorDescription)
		{
			$this->sActorDescription = $sActorDescription;
		}
		
		public static function researchActorExist($oAddActor)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM ator WHERE idAtor = ? ";
				$aArrayParam = [$oAddActor->getActorName()];
				$aExistActor = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (!empty($aExistActor))
				{
					echo "<script> 
									alert('Ator Ja Foi Cadastrado !!!');
									window.location.href = '/ser/login/pageaddactor';
						 </script>";
				}
			
			}
			catch(PDOException $e)
			{
				echo "Erro: ".$e->getMessage();
			}
		
		}
		
		public static function addActor($oActor)
		{
			self::researchActorExist($oActor);
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "INSERT INTO ator(nomeator,descAtor) 
							VALUES (?,?) ";
				$aArrayParam = [$oActor->getActorName(),$oActor->getActorDescription()];
				$rDatabaseHandler->add($sQuery,$rConnection,$aArrayParam);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				echo ("<script> 
							alert('Cadastro Feito Com Sucesso !!!');
							window.location.href = '/ser/login/pageaddactor';
					  </script>");
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Cadastrar: ".$e->getMessage();
			}
		}
		
		public static function updateActor($oActor)
		{
			try
			{   
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editActor"); 
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "UPDATE ator SET 
									   nomeAtor = ?,
									   descAtor = ?    
							WHERE idAtor = ? ";
				$aArrayParam = [$oActor->getActorName(),$oActor->getActorDescription()];
				$aArrayCondicao = [$iId];
				$rDatabaseHandler->update($sQuery,$rConnection,$aArrayParam,$aArrayCondicao);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				echo "<script> 
						alert('Ator Alterado Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizeactor';
					</script>";		
			}	
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Atualizar: ".$e->getMessage();
			}	
		}
	
		public static function removeActor($iIdActor)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "DELETE FROM ator WHERE idAtor = ? ";
				$aArrayParam = [$iIdActor];
				$lDeleted = $rDatabaseHandler->deleteDate($sQuery,$rConnection,$aArrayParam);
				if($lDeleted)
				{
					$rDatabaseHandler->commit($rConnection);
					$rConnection = $rDatabaseHandler->close($rConnection);
					echo "<script> 
						alert('Ator Deletado Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizeactor';
					</script>";
				}	
			}
			catch(PDOException $e)
			{
				echo "Erro ao Deletar: ".$e->getMessage();
			}	
		}
		
		public static function allActor()
		{	
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM ator order by idAtor  ";
			$aAllActor = $rDatabaseHandler->query($sQuery,$rConnection,null,true);	
			return $aAllActor;
		}
		
		public static function findActor($iIdActor)
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM ator where idAtor = ?  ";
			$aArrayParam = [$iIdActor];
			$aActor = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aActor;		
		}
		
		public static function findEditActor()
		{
			$iEdit = new Sessao();
			$iId = $iEdit->getSessao("editActor");
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM ator where idAtor = ?  ";
			$aArrayParam = [$iId];
			$aActor = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aActor;		
		}
		
		public static function createAllReportActors()
		{		
			$aAllActor = self::allActor();
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
								<h3 align ="center">Relatorio de Todos Os Atores</h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="3" align="center">Atores</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center">Nome</td>
										<td  align="center">Descricao</td>
										
									</tr> ';
			foreach ($aAllActor as $aActor) 
			{
				$sHTML.= '
							<tr>
								<td align="center">'.$aActor['idAtor'].' </td>
								<td align="center">'.$aActor['nomeAtor'].'  </td>
								<td align="center">'.$aActor['descAtor'].' </td>	
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os Atores.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
	}