<?php

	class RequirementController extends AbstractController
	{

		public function redirect($sPagina)
		{
			header ('Location:/ser/login/'.$sPagina);
		}

		public function addRequirement()
		{
			
			if( !empty($this->post("sRequirementName")) && !empty($this->post("sRequirementDateFinish"))
				 && !empty($this->post("sDescriptionRequirement")) )
			{	
				$oRequirement = new Requirement($this->post("iRequirementTask"),$this->post("iRequirementProject"),
												$this->post("iRequirementType"),$this->post("sRequirementName"),
												$this->post("sImportanceRequirement"),$this->post("sRequirementDateStart"),
												$this->post("sRequirementDateFinish"),$this->post("sDescriptionRequirement"),$this->post("sRequirementSituation"));				
				Requirement::addRequirement($oRequirement);	
			}
			else
			{
				echo "<script> 
						alert('Visao Geral do Projeto Deve Ser Preenchida !!!');
						window.location.href = '/ser/login/pageaddrequirement';
			     </script>";
			}
		}
		
		public function addTypeRequirement()
		{
			
			if( !empty($this->post("sRequirementName")) && !empty($this->post("sRequirementObs")))
			{	
				$oTypeRequirement = new TypeRequirement($this->post("sRequirementName"),$this->post("sRequirementObs"));
				TypeRequirement::addTypeRequirement($oTypeRequirement);	
			}
			else
			{
				echo "<script> 
						alert('Campos Devem Ser Preenchidos !!!');
						window.location.href = '/ser/login/pageaddtyperequirement';
			     </script>";
			}
		}
		
		public function removeRequirement()
		{
			$iIdRequirement = $this->get("id");
			Requirement::removeRequirement($iIdRequirement);
		}
		
		public function removeTypeRequirement()
		{
			$iIdTypeRequirement = $this->get("id");
			TypeRequirement::removeTypeRequirement($iIdTypeRequirement);
		}
		
		public function editRequirement()
		{
			$iEditProject = new Sessao("editRequirement",$this->get("id"));
			$this->redirect("pageeditrequirement");		
		}
		
		public function editTypeRequirement()
		{
			$iEditProject = new Sessao("editTypeRequirement",$this->get("id"));
			$this->redirect("pageedittyperequirement");	
		}
		
		public function updateRequirement()
		{
			if( !empty($this->post("sRequirementName")) && !empty($this->post("sRequirementDateFinish"))
				 && !empty($this->post("sDescriptionRequirement")) )
			{	
				$oRequirement = new Requirement($this->post("iRequirementTask"),$this->post("iRequirementProject"),
												$this->post("iRequirementType"),$this->post("sRequirementName"),
												$this->post("sImportanceRequirement"),$this->post("sRequirementDateStart"),
												$this->post("sRequirementDateFinish"),$this->post("sDescriptionRequirement"),$this->post("sRequirementSituation"));				
				Requirement::updateRequirement($oRequirement);	
			}
			else
			{
				echo "<script> 
						alert('Dados Devem Ser Preenchidos !!!');
						window.location.href = '/ser/login/pageeditrequirement';
			     </script>";
			}
		}
		
		public function situationUpdateRequirement()
		{
			if( !empty($this->post("sSituationRequirement")) )
			{					
				Requirement::situationUpdateRequirement($this->post("sSituationRequirement"));	
			}
			else
			{
				echo "<script> 
						alert('O Requisito Deve Ser Aprovado ou Reprovado !!!');
						window.location.href = '/ser/login/pagekeyuservisualizerequirement';
			     </script>";
			}
		}
		
		public function updateTypeRequirement()
		{
			if( !empty($this->post("sRequirementName")) && !empty($this->post("sRequirementObs")))
			{	
				$oTypeRequirement = new TypeRequirement($this->post("sRequirementName"),$this->post("sRequirementObs"));
				TypeRequirement::updateTypeRequirement($oTypeRequirement);	
			}
			else
			{
				echo "<script> 
						alert('Dados Devem Ser Preenchidos !!!');
						window.location.href = '/ser/login/pageedittyperequirement';
			     </script>";
			}
		}
		
		public function findKeyUserRequirement()
		{
			$iRequirement = new Sessao("keyUserRequirement",$this->get("id"));
			$this->redirect("pagekeyuservisualizerequirement");		
		}
		
		public function findDeveloperRequirement()
		{
			$iRequirement = new Sessao("developerRequirement",$this->get("id"));
			$this->redirect("pagedevelopervisualizerequirement");		
		}
		
		public function createAllReportTypeRequirement()
		{	
			TypeRequirement::createAllReportTypeRequirement();
		}
		
		public function createAllReportRequirement()
		{	
			Requirement::createAllReportRequirement();
		}
		
		public function createAllReportProjectRequirement()
		{	
			Requirement::createAllReportProjectRequirement($this->post("iIdProject"));
		}
		
		public function createAllReportTaskRequirement()
		{	
			Requirement::createAllReportTaskRequirement($this->post("iIdTask"));
		}
		
		public function createAllReportRequirementTypeRequirement()
		{	
			Requirement::createAllReportRequirementTypeRequirement($this->post("iIdTypeRequirement"));
		}
		
		public function createAllReportStartDateRequirement()
		{	
			Requirement::createAllReportStartDateRequirement($this->post("sStartDateRequirement"));
		}
		
		public function createAllReportFinishDateRequirement()
		{	
			Requirement::createAllReportFinishDateRequirement($this->post("sFinishDateRequirement"));
		}
		
		public function createAllReportRequirementPeriod()
		{	
			Requirement::createAllReportRequirementPeriod($this->post("sStartDateRequirement"),$this->post("sFinishDateRequirement"));
		}
		
		public function createAllReportSituationRequirement()
		{	
			Requirement::createAllReportSituationRequirement($this->post("sSituationRequirement"));
		}
		
		public function createAllReportImportanceRequirement()
		{	
			Requirement::createAllReportImportanceRequirement($this->post("sImportanceRequirement"));
		}
		
		public function createAllReportApprovedProjectRequirement()
		{	
			Requirement::createAllReportApprovedProjectRequirement($this->post("iIdProject"));
		}
		
		public function createAllReportNotApprovedProjectRequirement()
		{	
			Requirement::createAllReportNotApprovedProjectRequirement($this->post("iIdProject"));
		}
	}