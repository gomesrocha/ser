<?php

	class ProjectController extends AbstractController
	{

		public function redirect($sPagina)
		{
			header ('Location:/ser/login/'.$sPagina);
		}

		public function addProject()
		{
			
			if( !empty($this->post("sProjectName")) && !empty($this->post("sProjectDateConclusion"))
				 && !empty($this->post("sProjectStatus"))  && !empty($this->post("sProjectOverview"))  )
			{	
				$timeZone = new DateTimeZone('UTC');
				$dDateStart = DateTime::createFromFormat ('d/m/Y', date('d/m/Y'), $timeZone);
				$dDateFinish = DateTime::createFromFormat ('d/m/Y', $this->post("sProjectDateConclusion"), $timeZone);
				if (($dDateFinish > $dDateStart ))
				{
					$oProject = new Project($this->post("sProjectName"),$this->post("iManager"),$this->post("sProjectDateStart"),$this->post("sProjectDateConclusion"),
										$this->post("sProjectOverview"),$this->post("sQuestionnaireProject"),$this->post("sProjectStatus"));
					Project::addProject($oProject);	
				}
				else
				{
					echo "<script> 
								alert('Data De Conclusao Não Deve Ser Menor Que A Data Inicial Do Projeto !!!');
								window.location.href = '/ser/login/pageaddproject';
						  </script>";
				}
			}
			else
			{
				echo "<script> 
						alert('Visao Geral do Projeto Deve Ser Preenchida !!!');
						window.location.href = '/ser/login/pageaddproject';
			     </script>";
			}
		}
		
		public function removeProject()
		{
			$iIdProject = $this->get("id");
			Project::removeProject($iIdProject);
		}
		
		public function editProject()
		{
			$iEditProject = new Sessao("editProject",$this->get("id"));
			$this->redirect("pageeditproject");
			
		}
		
		public function updateProject()
		{
			if( !empty($this->post("sProjectName")) && !empty($this->post("sProjectDateConclusion"))
				 && !empty($this->post("sProjectStatus"))  && !empty($this->post("sProjectOverview"))  )
			{	
				$timeZone = new DateTimeZone('UTC');
				$dDateStart = DateTime::createFromFormat ('d/m/Y', date('d/m/Y'), $timeZone);
				$dDateFinish = DateTime::createFromFormat ('d/m/Y', $this->post("sProjectDateConclusion"), $timeZone);
				$dDateLimit = DateTime::createFromFormat ('d/m/Y', '31/12/2100', $timeZone);
				if (($dDateFinish > $dDateStart ) && ($dDateFinish < $dDateLimit))
				{
					$oProject = new Project($this->post("sProjectName"),$this->post("iManager"),$this->post("sProjectDateStart"),
											$this->post("sProjectDateConclusion"),$this->post("sProjectOverview"),$this->post("sQuestionnaireProject"),
											$this->post("sProjectStatus"));
					Project::updateProject($oProject);	
				}
				else
				{
					echo "<script> 
								alert('Data De Conclusao Não Deve Ser Menor Ou Muito Maior Que A Data Inicial Do Projeto !!!');
								window.location.href = '/ser/login/pageeditproject';
						</script>";
				}
			}
			else
			{
				echo "<script> 
						alert('Visao Geral do Projeto Deve Ser Preenchida !!!');
						window.location.href = '/ser/login/pageaddproject';
			     </script>";
			}
		}
		
		public function allStakeHolderRequirementsProject()
		{  
			$iIdProject = $this->get("id");
			$aAllRequirementsProject = Project::findRequirements($iIdProject);
			if(empty($aAllRequirementsProject))
			{
				echo "<script> 
						alert('Nenhum Requisito Vinculado ao Projeto !!!');
						window.location.href = '/ser/login/pagevisualizeliftingstakeholder';
					</script>";	
			}
			else
			{
				$aAllRequirements = new Sessao("allRequirements",$aAllRequirementsProject);
				$this->pageStakeHolderVisualizeAllRequirementsProject();
			}
		}
		
		public function allStakeHolderRequirementsProjectApproved()
		{  
			try
			{
				$iIdProject = $this->get("id");
				$aAllRequirementsProject = Project::findRequirements($iIdProject);
				if(empty($aAllRequirementsProject))
				{
					echo "<script> 
						alert('Nenhum Requisito Aprovado no Projeto !!!');
						window.location.href = '/ser/login/pagestakeholdervisualizeproject';
					</script>";		
				}
				else
				{
					$aAllRequirements = new Sessao("allRequirements",$aAllRequirementsProject);
					$this->pageManagerVisualizeAllRequirementsProject();
				}
			}
			catch(PDOException $e)
			{
				echo "Erro: ".$e->getMessage();
			}
		}
		
		public function allKeyUserProjectRequirements()
		{
			try
			{
				$iIdProject = $this->get("id");
				$aAllRequirementsProject = Project::findNotApprovedRequirements($iIdProject);
				if(empty($aAllRequirementsProject))
				{
					echo "<script> 
						alert('Nenhum Requisito Aprovado no Projeto !!!');
						window.location.href = '/ser/login/pagekeyuservisualizeproject';
					</script>";	
				}
				else
				{
					$aAllRequirements = new Sessao("allRequirements",$aAllRequirementsProject);
					$this->pageKeyUserVisualizeAllRequirementsProject();
				}
			}
			catch(PDOException $e)
			{
				echo "Erro: ".$e->getMessage();
			}
		}
		
		public function AllDeveloperProjectRequirementsApproved()
		{
			try
			{
				$iIdProject = $this->get("id");
				$aAllApprovedRequirementsProject = Project::findApprovedRequirements($iIdProject);
				$aAllRequirements = new Sessao("allApprovedRequirements",$aAllApprovedRequirementsProject);
				$this->pageDeveloperVisualizeAllRequirementsProject();
			}
			catch(PDOException $e)
			{
				echo "Erro: ".$e->getMessage();
			}
		}
		
		public function createReportStatusProjects()
		{	
			Project::createReportStatusProjects($this->post("sProjectStatus"));
		}
		
		public function createAllReportProjects()
		{	
			Project::createAllReportProjects();
		}
		
		public function createReportManagerProjects()
		{	
			Project::createReportManagerProjects($this->post("iManager"));
		}
		
		public function createReportProjectDateStart()
		{	
			Project::createReportProjectDateStart($this->post("sProjectDateStart"));
		}
		
		public function createReportProjectDateFinish()
		{	
			Project::createReportProjectDateFinish($this->post("sProjectDateFinish"));
		}
		
		public function createReportProjectPeriod()
		{	
			Project::createReportProjectPeriod($this->post("sProjectDateStart"),$this->post("sProjectDateFinish"));
		}	
	}