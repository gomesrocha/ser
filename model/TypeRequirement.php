<?php
	
	class TypeRequirement
	{
		private $iIdTypeRequirement;
		private $sTypeRequirementName;
		private $sObsTypeRequirement;
		
		function __construct($sTypeRequirementName,$sObsTypeRequirement)
		{
			$this->sTypeRequirementName = $sTypeRequirementName;
			$this->sObsTypeRequirement  = $sObsTypeRequirement;
		}
		
		public function getTypeIdRequirement()
		{
			return $this->iIdTypeRequirement;
		}
	
		public function getTypeRequirementName()
		{
			return $this->sTypeRequirementName;
		}
		
		public function getObsTypeRequirement()
		{
			return $this->sObsTypeRequirement;
		}
		
		public function setTypeIdRequirement($iIdTypeRequirement)
		{
			$this->iIdTypeRequirement = $iIdTypeRequirement;
		}

		public function setTypeRequirementName($sTypeRequirementName)
		{
			$this->sTypeRequirementName = $sTypeRequirementName;
		}

		public function setObsTypeRequirement($sObsTypeRequirement)
		{
			$this->sObsTypeRequirement = $sObsTypeRequirement;
		}
		
		public static function researchTypeRequirementExist($oAddTypeRequirement)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM tipoRequisito WHERE nomeTipoRequisito = ? ";
				$aArrayParam = [$oAddTypeRequirement->getTypeRequirementName()];
				$aExistTypeRequirement = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (!empty($aExistTypeRequirement))
				{
					echo "<script> 
									alert('Tipo de Requisito Ja Foi Cadastrado !!!');
									window.location.href = '/ser/login/pageaddtyperequirement';
						 </script>";
				}
			}
			catch(PDOException $e)
			{
				echo "Erro: ".$e->getMessage();
			}
		
		}
		
		public static function addTypeRequirement($oTypeRequirement)
		{
			self::researchTypeRequirementExist($oTypeRequirement);
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "INSERT INTO tipoRequisito(nomeTipoRequisito,obsTipoRequisito) 
							VALUES (?,?) ";
				$aArrayParam = [$oTypeRequirement->getTypeRequirementName(),$oTypeRequirement->getObsTypeRequirement()];
				$rDatabaseHandler->add($sQuery,$rConnection,$aArrayParam);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				echo "<script> 
							alert('Cadastro Feito Com Sucesso !!!');
							window.location.href = '/ser/login/pageaddtyperequirement';
					  </script>";
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Cadastrar: ".$e->getMessage();
			}
		}
		
		public static function updateTypeRequirement($oTypeRequirement)
		{
			try
			{   
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editTypeRequirement"); 
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "UPDATE tipoRequisito SET 
									   nomeTipoRequisito = ?,
									   obsTipoRequisito = ?    
							WHERE idTipoRequisito = ? ";
				$aArrayParam = [$oTypeRequirement->getTypeRequirementName(),$oTypeRequirement->getObsTypeRequirement()];
				$aArrayCondicao = [$iId];
				$rDatabaseHandler->update($sQuery,$rConnection,$aArrayParam,$aArrayCondicao);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				echo "<script> 
						alert('Tipo de Requisito Alterado Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizetyperequirement';
					</script>";		
			}	
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Atualizar: ".$e->getMessage();
			}	
		}
	
		public static function removeTypeRequirement($iIdTypeRequirement)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "DELETE FROM tipoRequisito WHERE idTipoRequisito = ? ";
				$aArrayParam = [$iIdTypeRequirement];
				$lDeleted = $rDatabaseHandler->deleteDate($sQuery,$rConnection,$aArrayParam);
				if($lDeleted)
				{
					$rDatabaseHandler->commit($rConnection);
					$rConnection = $rDatabaseHandler->close($rConnection);
					echo "<script> 
						alert('Tipo de Requisito Deletado Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizetyperequirement';
					</script>";
				}	
			}
			catch(PDOException $e)
			{
				echo "Erro ao Deletar: ".$e->getMessage();
			}	
		}
		
		public static function allTypeRequirement()
		{	
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM tipoRequisito";
			$aAllTypeRequirement = $rDatabaseHandler->query($sQuery,$rConnection,null,true);	
			return $aAllTypeRequirement;
		}
		
		public static function findTypeRequirement($iIdRequirement)
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM tipoRequisito where idTipoRequisito = ?  ";
			$aArrayParam = [$iIdRequirement];
			$aTypeRequirement = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aTypeRequirement;		
		}
		
		public static function findEditTypeRequirement()
		{
			$iEdit = new Sessao();
			$iId = $iEdit->getSessao("editTypeRequirement");
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM tipoRequisito where idTipoRequisito = ?  ";
			$aArrayParam = [$iId];
			$aTypeRequirement = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aTypeRequirement;		
		}
		
		public static function createAllReportTypeRequirement()
		{		
			$aAllTypeRequirement = self::allTypeRequirement();
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
								<h3 align ="center">Relatorio de Todos Os Tipos De Requisito</h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="3" align="center">Tipos De Requisito</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center">Nome</td>
										<td  align="center">Descricao</td>
										
									</tr> ';
			foreach ($aAllTypeRequirement as $aTypeRequirement) 
			{
				$sHTML.= '
							<tr>
								<td align="center">'.$aTypeRequirement['idTipoRequisito'].' </td>
								<td align="center">'.$aTypeRequirement['nomeTipoRequisito'].'  </td>
								<td align="center">'.$aTypeRequirement['obsTipoRequisito'].' </td>	
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os Tipos De Requisito.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
	}