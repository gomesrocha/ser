<?php

	class ActorController extends AbstractController
	{

		public function redirect($sPagina)
		{
			header ('Location:/ser/login/'.$sPagina);
		}

		public function addActor()
		{
			if( !empty($this->post("sActorName")) && !empty($this->post("sActorDescription")))
			{	
				$oActor  = new Actor($this->post("sActorName"),$this->post("sActorDescription"));
				Actor::addActor($oActor);	
			}
			else
			{
				echo "<script> 
						alert('Dados Devem Ser Preenchidos !!!');
						window.location.href = '/ser/login/pageaddactor';
			     </script>";
			}
		}
		
		public function editActor()
		{
			$iEditActor = new Sessao("editActor",$this->get("id"));
			$this->redirect("pageeditactor");	
		}
		
		public function updateActor()
		{
			if( !empty($this->post("sActorName")) && !empty($this->post("sActorDescription")))
			{			
				$oActor  = new Actor($this->post("sActorName"),$this->post("sActorDescription"));
				Actor::updateActor($oActor);	
			}
			else
			{
				echo "<script> 
						alert('Dados Devem Ser Preenchidos !!!');
						window.location.href = '/ser/login/pageeditactor';
			     </script>";
			}
		}
		
		public function removeActor()
		{
			$iIdActor = $this->get("id");
			Actor::removeActor($iIdActor);
		}
		
		public function createAllReportActors()
		{	
			Actor::createAllReportActors();
		}
	}