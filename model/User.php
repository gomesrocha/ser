<?php
	
	class User
	{
		private $iIdUser;
		private $sCpf;
		private $sUserName;
		private $sUserEmail;
		private $dDateInclusionUser;
		private $sUserType;
		private $sUserPassword;
		
		function __construct($sCpf,$sUserName,$sUserEmail,$sUserType,$sUserPassword)
		{
			$this->sCpf 				= $sCpf;
			$this->sUserName 			= $sUserName;
			$this->sUserEmail	 		= $sUserEmail;
			$this->dDateInclusionUser	= date('d/m/Y');
			$this->sUserType			= $sUserType;
			$this->sUserPassword		= $sUserPassword;
		}
		
		public function getIdUser()
		{
			return $this->iIdUser;
		}
		
		public function getCpf()
		{
			return $this->sCpf;
		}
		
		public function getUserName()
		{
			return $this->sUserName;
		}
		
		public function getEmail()
		{
			return $this->sUserEmail;
		}
		
		public function getDateInclusion()
		{
			return $this->dDateInclusionUser;
		}
		
		public function getUserType()
		{
			return $this->sUserType;
		}
		
		public function getPassword()
		{
			return $this->sUserPassword;
		}

		public function setCpf($sCpf)
		{
			$this->sCpf = $sCpf;
		}
		
		public function setIdUser($iIdUser)
		{
			$this->iIdUser = $iIdUser;
		}
	
		public function setUserName($sUserName)
		{
			$this->sUserName = $sUserName;
		}
		
		public function setEmail($sUserEmail)
		{
			$this->sUserEmail = $sUserEmail;
		}
		
		public function setDateInclusion($dDateInclusionUser)
		{
			$this->dDateInclusionUser = $dDateInclusionUser;
		}
		
		public function setUserType($sUserType)
		{
			$this->sUserType = $sUserType;
		}
		
		public function setPassword($sUserPassword)
		{
			$this->sUserPassword = $sUserPassword;
		}
		
		public static function authenticate($sUserEmail,$sUserPassword)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM usuario WHERE emailusuario = ? AND senhausuario = ?";
				$aArrayParam = [$sUserEmail,md5($sUserPassword)];
				$aLogado = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (empty($aLogado))
				{
					echo "<script> 
								alert('Login/Senha Invalidos !!!');
								window.location.href = '/ser/login/pagelogin';
						 </script>";
				}
				return $aLogado;
			}
			catch (PDOException $e)
			{
				echo "Erro ao tentar autenticar: ".$e;
			}
		}
		
		public static function researchUserExist($oAddUser)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM usuario WHERE cpfusuario = ? ";
				$aArrayParam = [$oAddUser->getCpf()];
				$aExistUser = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (!empty($aExistUser))
				{
					echo "<script> 
								alert('Usuario Ja Foi Cadastrado !!!');
								window.location.href = '/ser/login/pageadduser';
						  </script>";
				}
			}
			catch(PDOException $e)
			{
				echo "Erro: ".$e->getMessage();
			}
		}
		
		public static function findUserName($sUserName)
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM usuario WHERE nomeusuario = ?  ";
			$aArrayParam = [$sUserName];
			$aManager = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aManager;		
		}
		
		public static function addLinkProject()
		{
			try
			{
				$iIdLinkProject = new Sessao();
				$iIdLinkUser = new Sessao();
				$sUserName = new Sessao();
				$iIdLinkUser = $iIdLinkUser->getSessao("linkUser"); 
				$iIdLinkProject = $iIdLinkProject->getSessao("linkProject"); 
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "INSERT INTO linkarProjeto(usuario_idusuario,projeto_idProjeto) 
						VALUES (?,?) ";	
				$aArrayParam = [$iIdLinkUser,$iIdLinkProject];
				$rDatabaseHandler->add($sQuery,$rConnection,$aArrayParam);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				$aUser = self::findUser($iIdLinkUser);
				self::sendEmail($$aUser["emailUsuario"],$sUserName->getSessao("sUserName"),"Vinculo de Usuario Ao Projeto","Olá !!! Você acaba de ser vinculado a um projeto por ".$sUserName->getSessao("sUserName")." .Por favor, confira sua conta. Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)");
				echo "<script> 
							alert('Usuario Linkado ao Projeto Com Sucesso !!!');
							window.location.href = '/ser/login/pagelinkproject';
					  </script>";
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Cadastrar: ".$e->getMessage();
			}
		}
		
		public static function findLinkProject($iIdUser)
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM linkarProjeto WHERE usuario_idusuario = ?  ";
			$aArrayParam = [$iIdUser];
			$aUser = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aUser;		
		}
		
		public static function userTask($iIdUser)
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM tarefa WHERE usuario_idUsuario = ?  ";
			$aArrayParam = [$iIdUser];
			$aUser = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aUser;	
		}
		
		public static function removeLinkUser($iIdUser)
		{
			$aUser = self::userTask($iIdUser);
			try
			{
				if(empty($aUser))
				{
					$iId = new Sessao();
					$sUserName = new Sessao();
					$iIdProject = $iId->getSessao("linkProject");
					$aJson = CommonFunctions::readJSON("database/.config.json");
					$rDatabaseHandler = new SerDatabaseHandler($aJson);
					$rConnection = $rDatabaseHandler->getInstance();
					$rDatabaseHandler->begin($rConnection);
					$sQuery = "DELETE FROM linkarProjeto 
							WHERE usuario_idusuario = ? AND projeto_idProjeto = ? ";	
					$aArrayParam = [$iIdUser,$iIdProject];
					$rDatabaseHandler->deleteDate($sQuery,$rConnection,$aArrayParam);
					$rDatabaseHandler->commit($rConnection);
					$rConnection = $rDatabaseHandler->close($rConnection);
					$aUser = self::findUser($iIdUser);
					self::sendEmail($aUser["emailUsuario"],$sUserName->getSessao("sUserName"),"Desvinculo de Usuario Ao Projeto","Olá !!! Você acaba de ser desvinculado a um projeto por ".$sUserName->getSessao("sUserName")." . Por favor, confira sua conta. Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)");
					echo "<script> 
							alert('Usuario Desvinculado Com Sucesso !!!');
							window.location.href = '/ser/login/pageremovelinkproject';
					</script>";
				}
				else
				{
					echo "<script> 
							alert('Usuario Não Pode Ser Desvinculado do Projeto, pois há tarefas vinculadas a ele !!!');
							window.location.href = '/ser/login/pageremovelinkproject';
					</script>";	
				}	
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Cadastrar: ".$e->getMessage();
			}
		}
		
		public static function addUser($oUser)
		{
			self::researchUserExist($oUser);
			try
			{
				$sUserName = new Sessao();
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "INSERT INTO usuario(cpfusuario,
											   nomeusuario,
											   senhausuario,
											   tipousuario,
											   dataInclusaousuario,
											   emailusuario) 
						   VALUES (?,?,?,?,?,?) ";
				$aArrayParam = [$oUser->getCpf(),$oUser->getUserName(),
								md5($oUser->getPassword()),$oUser->getUserType(),
								$oUser->getDateInclusion(),$oUser->getEmail()];				
				$rDatabaseHandler->add($sQuery,$rConnection,$aArrayParam);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				self::sendEmail($oUser->getEmail(),$sUserName->getSessao("sUserName"),"Cadastro de Usuario","Olá !!! Você acaba de ser cadastrado no SER (Sistema de Engenharia de Requisitos) e estamos muito felizes de você ser mais um usuario do nosso sistema. Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)");
				echo "<script> 
			    			alert('Cadastro Feito Com Sucesso !!!');
							window.location.href = '/ser/login/pageadduser';
					 </script>";
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Cadastrar: ".$e->getMessage();
			}
		}
		
		public static function firstAcess($oUser)
		{
			self::researchUserExist($oUser);
			try
			{
				$sUserName = new Sessao();
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "INSERT INTO usuario(cpfusuario,
											   nomeusuario,
											   senhausuario,
											   tipousuario,
											   dataInclusaousuario,
											   emailusuario) 
						   VALUES (?,?,?,?,?,?) ";
				$aArrayParam = [$oUser->getCpf(),$oUser->getUserName(),
								md5($oUser->getPassword()),$oUser->getUserType(),
								$oUser->getDateInclusion(),$oUser->getEmail()];				
				$rDatabaseHandler->add($sQuery,$rConnection,$aArrayParam);
				$rDatabaseHandler->commit($rConnection);
				$rConnection = $rDatabaseHandler->close($rConnection);
				self::sendEmail($oUser->getEmail(),$sUserName->getSessao("sUserName"),"Cadastro de Usuario","Olá !!! Você acaba de ser cadastrado no SER (Sistema de Engenharia de Requisitos) e estamos muito felizes de você ser mais um usuario do nosso sistema. Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)");
				echo "<script> 
			    			alert('Cadastro Feito Com Sucesso !!!');
							window.location.href = '/ser/login/pageacess';
					 </script>";
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Cadastrar: ".$e->getMessage();
			}
		}
		
		public static function updateUser($oUser)
		{
			$iEdit = new Sessao();
			$sUserName = new Sessao();
			$iIdUser =  $iEdit->getSessao("editUser"); 
			$aManager = Project::findManager($iIdUser);
			if((empty($aManager)) || ($aManager["tipoUsuario"] == $oUser->getUserType()))
			{
				try
				{ 
					$aJson = CommonFunctions::readJSON("database/.config.json");
					$rDatabaseHandler = new SerDatabaseHandler($aJson);
					$rConnection = $rDatabaseHandler->getInstance();
					$rDatabaseHandler->begin($rConnection);
					$sQuery = "UPDATE usuario SET 
											cpfusuario  = ?,
											nomeusuario = ?,
											senhausuario = ?,
											tipousuario = ?,
											datainclusaousuario = ?,
											emailusuario = ?
									WHERE idUsuario = ? ";				
					$aArrayParam = [$oUser->getCpf(),$oUser->getUserName(),
									md5($oUser->getPassword()),$oUser->getUserType(),
									$oUser->getDateInclusion(),$oUser->getEmail()];
					$aArrayCondicao = [$iIdUser];
					$rDatabaseHandler->update($sQuery,$rConnection,$aArrayParam,$aArrayCondicao);
					$rDatabaseHandler->commit($rConnection);
					self::sendEmail($oUser->getEmail(),$sUserName->getSessao("sUserName"),"Update de Usuario","Olá !!! Seu cadastro acaba de ser alterado.");
					echo "<script> 
								alert('Atualizacao Feita Com Sucesso !!!');
								window.location.href = '/ser/login/pagevisualizeuser';
						</script>";
				}
				catch(PDOException $e)
				{
					$rDatabaseHandler->roolBack($rConnection);
					echo "Erro ao Cadastrar: ".$e->getMessage();
				}
			}
			else
			{
				echo "<script> 
								alert('Usuario Está Vinculado Como Gerente A Um Projeto. Nao Foi Possivel a Atualizacao !!!');
								window.location.href = '/ser/login/pagevisualizeuser';
						</script>";
			}
		}
		
		public static function viewAllManager()
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM usuario WHERE tipoUsuario = ? order by idUsuario ";
			$aArrayParam = ["gerente"];
			$aAllManager = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
			return $aAllManager;
		}
		
		public static function removeUser($iIdUser)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$sUserName = new Sessao();
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "DELETE FROM usuario WHERE idUsuario = ? ";
				$aArrayParam = [$iIdUser];
				$aUser = self::findUser($iIdUser);
				$lDeleted = $rDatabaseHandler->deleteDate($sQuery,$rConnection,$aArrayParam);
				if($lDeleted)
				{
					$rDatabaseHandler->commit($rConnection);
					$rConnection = $rDatabaseHandler->close($rConnection);
					self::sendEmail($aUser['emailUsuario'] ,$sUserName->getSessao("sUserName"),"Remoção de Usuario ","Olá !!! Você acaba de ser removido do SER por ".$sUserName->getSessao("sUserName")." . Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)");
					echo "<script> 
						alert('Usuario Deletado Com Sucesso !!!');
						window.location.href = '/ser/login/pagevisualizeuser';
					</script>";
				}	
			}
			catch(PDOException $e)
			{
				echo "Erro ao Deletar: ".$e->getMessage();
			}
		}

		public static function findUser($iIdUser)
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM usuario WHERE idUsuario = ?  ";
			$aArrayParam = [$iIdUser];
			$aUser = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
			return $aUser;		
		}
		
		public static function findAllUserType($sType)
		{
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM usuario WHERE tipousuario = ?  ";
			$aArrayParam = [$sType];
			$aAllUserType = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
			return $aAllUserType;		
		}
	
		public static function findEditUser()
		{
			try
			{
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editUser");
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM usuario WHERE idUsuario = ? ";
				$aArrayParam = [$iId];
				$aUserEdit = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (empty($aUserEdit))
				{
					echo "<script> 
							alert('Usuario Nao Encontrado !!!');
							window.location.href = '/ser/login/pageVisualizeProject';
					</script>";			
				}
				return $aUserEdit;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}	
	
		public static function findEditManager()
		{
			try
			{
				$iEdit = new Sessao();
				$iId = $iEdit->getSessao("editManager");
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM usuario WHERE idUsuario = ? ";
				$aArrayParam = [$iId];
				$aUserEdit = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				if (empty($aUserEdit))
				{
					echo "<script> 
							alert('usuario Nao Encontrado !!!');
							window.location.href = '/ser/login/pagevisualizeproject';
					</script>";
				
				}
				return $aUserEdit;	
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}	
		
		public static function allUser()
		{		
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "SELECT * FROM usuario order by idUsuario ";
			$aAllUser = $rDatabaseHandler->query($sQuery,$rConnection,null,true);
			return $aAllUser;		
		}
	
		public static function allUserLink()
		{		
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "select * from usuario u
							WHERE u.idUsuario  in ( select usuario_idUsuario
															from linkarProjeto l
                                ) and u.tipoUsuario <> 'gerente' ";
			$aAllUser = $rDatabaseHandler->query($sQuery,$rConnection,null,true);
			return $aAllUser;		
		}
		
		public static function allUserNotLink()
		{		
			$aUserNotLink = new Sessao();
			$iIdUser = $aUserNotLink->getSessao("linkProject");
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "select * from usuario u
							WHERE u.idUsuario not in ( select usuario_idUsuario
															from linkarProjeto l WHERE l.Projeto_idProjeto = ".$iIdUser."
                               ) and u.tipoUsuario <> 'gerente' ";
			$aAllUser = $rDatabaseHandler->query($sQuery,$rConnection,null,true);
			return $aAllUser;		
		}
		
		public static function allUserLinkProject($iIdProject)
		{		
			$aJson = CommonFunctions::readJSON("database/.config.json");
			$rDatabaseHandler = new SerDatabaseHandler($aJson);
			$rConnection = $rDatabaseHandler->getInstance();
			$sQuery = "select * from usuario u
							WHERE u.idUsuario  in ( select usuario_idUsuario
															from linkarProjeto l
                                WHERE l.projeto_idProjeto = ? ) ";
			$aArrayParam = [$iIdProject];					
			$aAllUser = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);
			return $aAllUser;		
		}
		
		public static function updatePassword($iIdUser,$sUserPassword)
		{
			try
			{ 
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$rDatabaseHandler->begin($rConnection);
				$sQuery = "UPDATE usuario SET 
										senhaUsuario = ?
								WHERE idUsuario = ? ";				
				$aArrayParam = [md5($sUserPassword)];
				$aArrayCondicao = [$iIdUser];
				$rDatabaseHandler->update($sQuery,$rConnection,$aArrayParam,$aArrayCondicao);
				$rDatabaseHandler->commit($rConnection);
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro ao Cadastrar: ".$e->getMessage();
			}
		}
		
		public static function Password($sUserEmail,$sUserCpf,$sUserPassword)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM usuario WHERE emailUsuario = ? AND cpfUsuario = ?  ";
				$aArrayParam = [$sUserEmail,$sUserCpf];
				$aUser = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,false);
				
				if(!empty($aUser))
				{
					self::updatePassword($aUser["idUsuario"],$sUserPassword);
					self::sendEmail($aUser["emailUsuario"],$aUser["nomeUsuario"],"Trocar Senha",'Olá !!! Sua nova senha é "'.$sUserPassword.'". Atenciosamente grupo GPITIC(Grupo de Pesquisa Interdisciplinar em Tecnologia da Informação e Comunicação)');
					echo "<script> 
							alert('Email Enviado Com Sucesso !!!');
							window.location.href = '/ser/login/pagechangepassword';
					</script>";
				}
				else
				{
					echo "<script> 
							alert('Email Nao Encontrado !!!');
							window.location.href = '/ser/login/pagechangepassword';
					</script>";
				}
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		
		public static function consultDateInclusionUsers($sDateInclusionUsers)
		{
			try
			{
				$aJson = CommonFunctions::readJSON("database/.config.json");
				$rDatabaseHandler = new SerDatabaseHandler($aJson);
				$rConnection = $rDatabaseHandler->getInstance();
				$sQuery = "SELECT * FROM usuario WHERE  str_to_date(dataInclusaoUsuario,'%d/%m/%Y') >= ? order by dataInclusaoUsuario";
				$aArrayParam = [$sDateInclusionUsers];
				$aReport = $rDatabaseHandler->query($sQuery,$rConnection,$aArrayParam,true);		
				if (!empty($aReport))
				{
					return $aReport;
				}
				else
				{
					echo "<script> 
							alert('Não Há Usuarios Inclusos a Partir Desta Data !!!');
							window.location.href = '/ser/login/pagereportdateinclusionusers';
					</script>";
				}
			}
			catch(PDOException $e)
			{
				$rDatabaseHandler->roolBack($rConnection);
				echo "Erro : ".$e->getMessage();
			}
		}
		
		public static function createAllReportUsers()
		{		
			$aAllUser = self::allUser();
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
								<h3 align ="center">Relatorio de Todos Os usuarios</h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="6" align="center">Usuarios</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center">Nome</td>
										<td  align="center">CPF</td>
										<td  align="center">Tipo de usuario</td>
										<td  align="center">Email</td>
										<td  align="center">Data de Inclusao </td>
				
									</tr> ';
			foreach ($aAllUser as $oUser) 
			{
				$sHTML.= '
							<tr>
								<td align="center">'.$oUser['idUsuario'].' </td>
								<td align="center">'.$oUser['nomeUsuario'].'  </td>
								<td align="center">'.$oUser['cpfUsuario'].' </td>
								<td align="center">'.$oUser['tipoUsuario'].' </td>
								<td align="center">'.$oUser['emailUsuario'].' </td>
								<td align="center">'.$oUser['dataInclusaoUsuario'].' </td>	
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os Usuarios.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportUsersType($sUserType)
		{		
			$aAllUserType = self::findAllUserType($sUserType);
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
								<h3 align ="center">Relatorio de Todos Os usuarios Por Tipo</h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="6" align="center">Usuarios</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center">Nome</td>
										<td  align="center">CPF</td>
										<td  align="center">Tipo de usuario</td>
										<td  align="center">Email</td>
										<td  align="center">Data de Inclusao </td>
				
									</tr> ';
			foreach ($aAllUserType as $oUser) 
			{
				$sHTML.= '
							<tr>
								<td align="center">'.$oUser['idUsuario'].' </td>
								<td align="center">'.$oUser['nomeUsuario'].'  </td>
								<td align="center">'.$oUser['cpfUsuario'].' </td>
								<td align="center">'.$oUser['tipoUsuario'].' </td>
								<td align="center">'.$oUser['emailUsuario'].' </td>
								<td align="center">'.$oUser['dataInclusaoUsuario'].' </td>	
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os usuarios.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportNotLinkUsers()
		{		
			$aAllNotLinkUser = self::allUserNotLink();
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
								<h3 align ="center">Relatorio de Todos Os usuarios Não Vinculados</h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="6" align="center">Usuarios</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center">Nome</td>
										<td  align="center">CPF</td>
										<td  align="center">Tipo de usuario</td>
										<td  align="center">Email</td>
										<td  align="center">Data de Inclusao </td>
				
									</tr> ';
			foreach ($aAllNotLinkUser as $oUser) 
			{
				$sHTML.= '
							<tr>
								<td align="center">'.$oUser['idUsuario'].' </td>
								<td align="center">'.$oUser['nomeUsuario'].'  </td>
								<td align="center">'.$oUser['cpfUsuario'].' </td>
								<td align="center">'.$oUser['tipoUsuario'].' </td>
								<td align="center">'.$oUser['emailUsuario'].' </td>
								<td align="center">'.$oUser['dataInclusaoUsuario'].' </td>	
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os usuarios.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportLinkUsersProject($iIdProject)
		{		
			$aAllLinkUsersProject = self::allUserLinkProject($iIdProject);
		
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
								<h3 align ="center">Relatorio de Todos Os usuarios Por projeto</h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="6" align="center">Usuarios</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center">Nome</td>
										<td  align="center">CPF</td>
										<td  align="center">Tipo de usuario</td>
										<td  align="center">Email</td>
										<td  align="center">Data de Inclusao </td>
				
									</tr> ';
			foreach ($aAllLinkUsersProject as $oUser) 
			{
				$sHTML.= '
							<tr>
								<td align="center">'.$oUser['idUsuario'].' </td>
								<td align="center">'.$oUser['nomeUsuario'].'  </td>
								<td align="center">'.$oUser['cpfUsuario'].' </td>
								<td align="center">'.$oUser['tipoUsuario'].' </td>
								<td align="center">'.$oUser['emailUsuario'].' </td>
								<td align="center">'.$oUser['dataInclusaoUsuario'].' </td>	
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os usuarios.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createAllReportLinkUsers()
		{		
			$aAllLinkUsers = self::allUserLink();
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
								<h3 align ="center">Relatorio de Todos Os usuarios Por Projeto</h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="6" align="center">Usuarios</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center">Nome</td>
										<td  align="center">CPF</td>
										<td  align="center">Tipo de usuario</td>
										<td  align="center">Email</td>
										<td  align="center">Data de Inclusao </td>
				
									</tr> ';
			foreach ($aAllLinkUsers as $oUser) 
			{
				$sHTML.= '
							<tr>
								<td align="center">'.$oUser['idUsuario'].' </td>
								<td align="center">'.$oUser['nomeUsuario'].'  </td>
								<td align="center">'.$oUser['cpfUsuario'].' </td>
								<td align="center">'.$oUser['tipoUsuario'].' </td>
								<td align="center">'.$oUser['emailUsuario'].' </td>
								<td align="center">'.$oUser['dataInclusaoUsuario'].' </td>	
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os usuarios.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function createReportDateInclusionUsers($sDateInclusionUsers)
		{		
			$aAllUsers = self::consultDateInclusionUsers($sDateInclusionUsers);
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
								<h3 align ="center">Relatorio de Todos Os usuarios Por Projeto</h3>
                           
                                <table border="1" align="center" class="table">

									<tr>
										<th colspan="6" align="center">Usuarios</th>
									</tr>
											
									<tr>
										<td  align="center">ID</td>
										<td  align="center">Nome</td>
										<td  align="center">CPF</td>
										<td  align="center">Tipo de usuario</td>
										<td  align="center">Email</td>
										<td  align="center">Data de Inclusao </td>
				
									</tr> ';
			foreach ($aAllUsers as $oUser) 
			{
				$sHTML.= '
							<tr>
								<td align="center">'.$oUser['idUsuario'].' </td>
								<td align="center">'.$oUser['nomeUsuario'].'  </td>
								<td align="center">'.$oUser['cpfUsuario'].' </td>
								<td align="center">'.$oUser['tipoUsuario'].' </td>
								<td align="center">'.$oUser['emailUsuario'].' </td>
								<td align="center">'.$oUser['dataInclusaoUsuario'].' </td>	
							</tr>
						';
			}
			$sHTML.=' 		</table>
						</body>
					</html>';
			$arquivo = "Relatorio de Todos Os usuarios.pdf";
			$mpdf = new mPDF();
			$mpdf->WriteHTML($sHTML);	
			$mpdf->Output($arquivo,'I');
		}
		
		public static function sendEmail($sEmail,$sUserName,$sCorpo,$sMsg)
		{
			$sEnviarEmail = "ser@midasprocesses.com";
			$sDestino = $sEmail;
			$sAssunto = $sCorpo;

			// É necessário indicar que o formato do e-mail é html
			$sHeaders  = 'MIME-Version: 1.0' . "\r\n";
			$sHeaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"."\r\n";
			$sHeaders .= 'Usuario:'.$sUserName."\r\n"."\r\n";
			$sHeaders .= $sMsg; 
			//$headers .= "Bcc: $EmailPadrao\r\n";
			$sEnviarEmail = mail($sDestino, $sAssunto, $sHeaders);
		}
	}