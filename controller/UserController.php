<?php

	class UserController extends AbstractController
	{

		public function redirect($sPagina)
		{
			header ('Location:/ser/login/'.$sPagina);
		}
		
		public function addUser()
		{
			if( !empty($this->post("sUserName")) && !empty($this->post("sUserType")) && !empty($this->post("sUserCpf"))
				 && !empty($this->post("sUserEmail")) && !empty($this->post("sUserPassword")) )
			{
				$oUser = new User($this->post("sUserCpf"),$this->post("sUserName"),$this->post("sUserEmail"),
									$this->post("sUserType"),$this->post("sUserPassword"));
			
				User::addUser($oUser);
			}
			else
			{
				echo "<script> 
						alert('Dados Devem Ser Preenchidos !!!');
						window.location.href = '/ser/login/pageadduser';
			     </script>";
			}
		}
		
		public function addLink()
		{
			$iLinkProject = new Sessao("linkUser",$this->get("id"));
			User::addLinkProject();	
		}
		
		public function editUser()
		{
			$iEditUser = new Sessao("editUser",$this->get("id"));
			$this->redirect("pageedituser");
		}
		
		public function linkProject()
		{
			$iLinkProject = new Sessao("linkProject",$this->get("id"));
			$this->redirect("pagelinkuser");
		}
		
		public function removeLinkProject()
		{
			$iLinkProject = new Sessao("linkProject",$this->get("id"));
			$this->redirect("pageremovelinkuser");
		}
		
		public function removeLinkUser()
		{
			$iIdUser = $this->get("id");
			User::removeLinkUser($iIdUser);
		}
		
		public function updateUser()
		{
			if( !empty($this->post("sUserName")) && !empty($this->post("sUserType")) && !empty($this->post("sUserCpf"))
				 && !empty($this->post("sUserEmail")) && !empty($this->post("sUserPassword")) )
			{
				$oUser = new User($this->post("sUserCpf"),$this->post("sUserName"),$this->post("sUserEmail"),
									$this->post("sUserType"),$this->post("sUserPassword"));	
				User::updateUser($oUser);
			}	
			else
			{
				echo "<script> 
						alert('Dados Devem Ser Preenchidos !!!');
						window.location.href = '/ser/login/pageedituser';
			     </script>";
			}			
		}
		
		public function removeUser()
		{
			$iIdUser = $this->get("id");
			User::removeUser($iIdUser);
		}
		
		public function Password()
		{
			User::Password($this->post("sEmail"),$this->post("sUserCpf"),$this->post("sUserPassword"));
		}	
		
		public function createAllReportUsers()
		{	
			User::createAllReportUsers();
		}
		
		public function createAllReportUsersType()
		{	
			User::createAllReportUsersType($this->post("sUserType"));
		}
		
		public function createAllReportNotLinkUsers()
		{	
			User::createAllReportNotLinkUsers();
		}
		
		public function createAllReportLinkUsers()
		{	
			User::createAllReportLinkUsers();
		}
		
		public function createAllReportLinkUsersProject()
		{	
			User::createAllReportLinkUsersProject($this->post("iIdProject"));
		}
		
		public function createReportDateInclusionUsers()
		{	
			User::createReportDateInclusionUsers($this->post("sDateInclusionUsers"));
		}
		
	}