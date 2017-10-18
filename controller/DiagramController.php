<?php

	class DiagramController extends AbstractController
	{

		public function redirect($sPagina)
		{
			header ('Location:/ser/login/'.$sPagina);
		}

		public function addDiagram()
		{
			if( !empty($this->post("sProjectId")) && !empty($this->post("iActorId")) 
				&& !empty($this->post("sDiagramName")) && !empty($this->post("sDiagramImagePath")) )
			{ 	
				$oDiagram  = new Diagram($this->post("sProjectId"),$this->post("iActorId"),
										 $this->post("sDiagramName"),$this->post("sDiagramImagePath") );
				Diagram::addDiagram($oDiagram);
			}
			else
			{
				echo "<script> 
						alert('Dados Devem Ser Preenchidos !!!');
						window.location.href = '/ser/login/pageadddiagram';
			     </script>";
			}
		}
		
		public function editDiagram()
		{
			$iEditDiagram = new Sessao("editDiagram",$this->get("id"));
			$this->redirect("pageeditdiagram");	
		}
		
		public function updateDiagram()
		{
			if( !empty($this->post("sProjectId")) && !empty($this->post("iActorId")) 
				&& !empty($this->post("sDiagramName")) && !empty($this->post("sDiagramImagePath")) )
			{			
				$oDiagram  = new Diagram($this->post("sProjectId"),$this->post("iActorId"),
										 $this->post("sDiagramName"),$this->post("sDiagramImagePath") );
				Diagram::updateDiagram($oDiagram);	
			}
			else
			{
				echo "<script> 
						alert('Dados Devem Ser Preenchidos !!!');
						window.location.href = '/ser/login/pageditdiagram';
			     </script>";
			}
		}
		
		public function removeDiagram()
		{
			$iIdDiagram = $this->get("id");
			Diagram::removeDiagram($iIdDiagram);
		}
		
		public function createAllReportDiagram()
		{	
			Diagram::createAllReportDiagram();
		}
		
		public function createAllReportDiagramProject()
		{	
			Diagram::createAllReportDiagramProject($this->post("iIdProject"));
		}
	}