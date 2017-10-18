<?php

	class LoginController extends AbstractController
	{

		

		public function redirect($sPagina)
		{
			header ('Location:/ser/login/'.$sPagina);
		}
	
		public function logged()
		{
			$bLogged = new Sessao();
			$bUser = new Sessao("bUser",false);
			if(!empty($this->post("sEmail")) && !empty($this->post("sPassword")) && $bLogged->getSessao("bLogged") == false) 
			{
				$aUser = (array)User::authenticate($this->post("sEmail"),$this->post("sPassword")); 
			    $sUserName = new Sessao("sUserName",$aUser["nomeUsuario"]);
				$iIdUser = new Sessao("iIdUser", $aUser["idUsuario"]);
				switch ($aUser["tipoUsuario"]) 
				{
					case "gerente":
						$bLogged->setSessao("bLogged",true);
						$bUser->setSessao("bManager",true);
						$this->pageDefaultManager();
						break;
					
					case "keyUser":
					
						$bLogged->setSessao("bLogged",true);
						$bUser->setSessao("bKeyUser",true);
						$this->pageDefaultKeyUser();
					    break;
					
					case "desenvolvedor":
					
						$bLogged->setSessao("bLogged",true);
						$bUser->setSessao("bDeveloper",true);
						$this->pageDefaultDeveloper();
						break;
					
					case "analista":
					
						$bLogged->setSessao("bLogged",true);						
						$bUser->setSessao("bAnalyst",true);
						$this->pageDefaultAnalyst();
						break;
						
					case "stakeholder":
					
						$bLogged->setSessao("bLogged",true);
						$bUser->setSessao("bStakeHolder",true);
						$this->pageDefaultStakeHolder();
						break;
					
					default:
					
						echo "<script> 
									alert('Login/Senha Invalidos !!!');
									window.location.href = '/ser/login/pagelogin';
							  </script>";
				}
			}
		}
		
	}
		
		
		
