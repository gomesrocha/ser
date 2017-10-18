<?php

	class CaseController extends AbstractController
	{

		public function redirect($sPagina)
		{
			header ('Location:/ser/login/'.$sPagina);
		}

		public function addUseCase()
		{
			if( !empty($this->post("iIdDiagram")) && !empty($this->post("sUseCaseName")) 
				&& !empty($this->post("sUseCaseFlow")) && !empty($this->post("sUseCaseResume"))
				&& !empty($this->post("sUseCasePrecondition")) && !empty($this->post("sUseCaseAlternativeFlow")) ) 
			{ 	
				$oUseCase  = new UseCase($this->post("iIdDiagram"),$this->post("sUseCaseName"),
										 $this->post("sUseCaseFlow"),$this->post("sUseCaseResume"),
										 $this->post("sUseCasePrecondition"), $this->post("sUseCasePoscondition"),
										 $this->post("sUseCaseAlternativeFlow"),$this->post("sUseCaseException"),
										 $this->post("sUseCaseBusinessRule"));
				UseCase::addUseCase($oUseCase);
			}
			else
			{
			//	echo "<script> 
					//	alert('Dados Devem Ser Preenchidos !!!');
				//		window.location.href = '/ser/login/pageaddusecase';
			  //   </script>";
			}
		}
		
		public function editUseCase()
		{
			$iEditUseCase = new Sessao("editUseCase",$this->get("id"));
			$this->redirect("pageeditusecase");	
		}
		
		public function updateUseCase()
		{
			if( !empty($this->post("iIdDiagram")) && !empty($this->post("sUseCaseName")) 
				&& !empty($this->post("sUseCaseFlow")) && !empty($this->post("sUseCaseResume"))
				&& !empty($this->post("sUseCasePrecondition")) && !empty($this->post("sUseCaseAlternativeFlow")) )
			{
				$oUseCase  = new UseCase($this->post("iIdDiagram"),$this->post("sUseCaseName"),
										 $this->post("sUseCaseFlow"),$this->post("sUseCaseResume"),
										 $this->post("sUseCasePrecondition"), $this->post("sUseCasePoscondition"),
										 $this->post("sUseCaseAlternativeFlow"),$this->post("sUseCaseException"),
										 $this->post("sUseCaseBusinessRule"));
				UseCase::updateUseCase($oUseCase);
			}
			else
			{
				echo "<script> 
						alert('Dados Devem Ser Preenchidos !!!');
						window.location.href = '/ser/login/pageeditusecase';
			     </script>";
			}
		}
		
		public function removeUseCase()
		{
			$iIdUseCase = $this->get("id");
			UseCase::removeUseCase($iIdUseCase);
		}
		
		public function createAllReportUseCase()
		{	
			UseCase::createAllReportUseCase();
		}
		
		public function createAllReportUseCaseDiagram()
		{	
			UseCase::createAllReportUseCaseDiagram($this->post("iIdDiagram"));
		}
	}