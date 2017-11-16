<?php

	class TaskController extends AbstractController
	{

		public function redirect($sPagina)
		{
			header ('Location:/ser/task/'.$sPagina);
		}

		public function addTask()
		{
			if( !empty($this->post("iProjectId")) && !empty($this->post("iUserId")) && !empty($this->post("sTaskName"))
				 && !empty($this->post("sTaskDateConclusion"))   )
			{	
				$timeZone = new DateTimeZone('UTC');
				$dDateStart = DateTime::createFromFormat ('d/m/Y', date('d/m/Y'), $timeZone);
				$dDateFinish = DateTime::createFromFormat ('d/m/Y', $this->post("sTaskDateConclusion"), $timeZone);
				if($dDateFinish > $dDateStart )
				{
					$oTask  = new Task($this->post("iProjectId"),$this->post("iUserId"),$this->post("iRequirementId"),$this->post("sTaskDateStart"),
									$this->post("sTaskName"),$this->post("sTaskDateConclusion"),$this->post("sTaskObs"),$this->post("sTaskNameDepend"));
					Task::addTask($oTask);	
				}
				else
				{
					echo "<script> 
								alert('Data De Conclusao Não Deve Ser Menor Que A Data Inicial Da Tarefa !!!');
								window.location.href = '/ser/login/pageaddtask';
						</script>";
				}
			}
			else
			{
				echo "<script> 
								alert('Dados Não Foram Preenchidos !!!');
								window.location.href = '/ser/login/pageaddtask';
						</script>";
			}
		}
		
		public function editTask()
		{
			$iEditTask = new Sessao("editTask",$this->get("id"));
			$this->redirect("pageedittask");
			
		}
		
		public function updateTask()
		{
		
			if( !empty($this->post("iProjectId")) && !empty($this->post("iUserId")) && !empty($this->post("sTaskName"))
				 && !empty($this->post("sTaskDateConclusion"))   )
			{	
				$timeZone = new DateTimeZone('UTC');
				$dDateStart = DateTime::createFromFormat ('d/m/Y', date('d/m/Y'), $timeZone);
				$dDateFinish = DateTime::createFromFormat ('d/m/Y', $this->post("sTaskDateConclusion"), $timeZone);
				if($dDateFinish > $dDateStart )
				{
					$oTask  = new Task($this->post("iProjectId"),$this->post("iUserId"),$this->post("iRequirementId"),$this->post("sTaskDateStart"),
									$this->post("sTaskName"),$this->post("sTaskDateConclusion"),$this->post("sTaskObs"),$this->post("sTaskNameDepend"));
					Task::updateTask($oTask);	
				}
				else
				{
					echo "<script> 
								alert('Data De Conclusao Não Deve Ser Menor Que A Data Inicial Da Tarefa !!!');
								window.location.href = '/ser/login/pagevisualizetask';
						</script>";
				}
			}
			else
			{
				echo "<script> 
								alert('Dados Não Foram Preenchidos !!!');
								window.location.href = '/ser/login/pageupdatetask';
						</script>";
			}
		}
		
		public function removeTask()
		{
			$iIdTask = $this->get("id");
			Task::removeTask($iIdTask);
		}
		
		public function createAllReportTasks()
		{	
			Task::createAllReportTasks();
		}
		
		public function createReportTaskDateStart()
		{	
			Task::createReportTaskDateStart($this->post("sTaskDateStart"));
		}
		
		public function createReportTaskDateFinish()
		{	
			Task::createReportTaskDateFinish($this->post("sTaskDateFinish"));
		}
		
		public function createReportTaskPeriod()
		{	
			Task::createReportTaskPeriod($this->post("sTaskDateStart"),$this->post("sTaskDateFinish"));
		}
		
		public function createReportTaskUser()
		{	
			Task::createReportTaskUser($this->post("iUserId"));
		}
		
		public function createReportTaskProject()
		{	
			Task::createReportTaskProjects($this->post("iProjectId"));
		}
	}