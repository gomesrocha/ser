<?php
abstract class AbstractController{

	private $POST = array();
	private $GET = array();
	private $FILES = array();
	private $SESSION = array();

	public function setGetData($aData){
		foreach($aData as $key => $value){
			$this->GET[$key] = $value;
		}
	}

	public function setPostData($aData){
		foreach($aData as $key => $value){
			$this->POST[$key] = $value;
		}
	}

	public function setFilesData($aData){
		foreach($aData as $key => $value){
			$this->FILES[$key] = $value;
		}
	}
	
	public function setSessionData($aData)
	{
		foreach($aData as $key => $value)
		{
			$this->SESSION[$key] = $value;
		}
	}

	public function get($sKey){
		return $this->GET[$sKey];
	}
	
	public function post($sKey){
		return $this->POST[$sKey];
	}

	public function files($sKey){
		return $this->FILES[$sKey];
	}

	public function session($sKey)
	{
		return $this->SESSION[$sKey];
	}
	
	public function pageLogin()
	{
		include 'view/Login.php';
	}
	
	public function pageAbout()
	{
		include 'view/pageAbout.php';
	}
	
	public function pageAcess()
	{
		include 'view/pageAcess.php';
	}
	
	public function pageChangePassword()
	{
		include 'view/pageChangePassword.php';	
	}
	
	public function pageDefaultManager()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageDefaultManager.php';
		}
	}
	
	public function pageRemoveLinkUser()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageRemoveLinkUser.php';
		}
	}
	
	public function pageRemoveLinkProject()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageRemoveLinkProject.php';
		}
	}
	
	public function pageDefaultStakeHolder()
	{  
		$bLogged = new Sessao();
		$bStakeHolder = new Sessao();
		if($bLogged->getSessao("bLogged") && $bStakeHolder->getSessao("bStakeHolder"))
		{
			include 'view/pageDefaultStakeHolder.php';
		}
	}
	
	public function pageDefaultKeyUser()
	{  
		$bLogged = new Sessao();
		$bKeyUser = new Sessao();
		if($bLogged->getSessao("bLogged") && $bKeyUser->getSessao("bKeyUser"))
		{
			include 'view/pageDefaultKeyUser.php';
		}
	}
	
	public function pageDefaultDeveloper()
	{  
		$bLogged = new Sessao();
		$bDeveloper = new Sessao();
		if($bLogged->getSessao("bLogged") && $bDeveloper->getSessao("bDeveloper"))
		{
			include 'view/pageDefaultDeveloper.php';
		}
	}
	
	public function pageDefaultAnalyst()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageDefaultAnalyst.php';
		}
	}
	
	public function pageKeyUserVisualizeProject()
	{  
		$bLogged = new Sessao();
		$bKeyUser = new Sessao();
		if($bLogged->getSessao("bLogged") && $bKeyUser->getSessao("bKeyUser"))
		{
			include 'view/pageKeyUserVisualizeProject.php';
		}
	}
	
	public function pageDeveloperVisualizeProject()
	{  
		$bLogged = new Sessao();
		$bDeveloper = new Sessao();
		if($bLogged->getSessao("bLogged") && $bDeveloper->getSessao("bDeveloper"))
		{
			include 'view/pageDeveloperVisualizeProject.php';
		}
	}
	
	public function pageKeyUserVisualizeRequirement()
	{  
		$bLogged = new Sessao();
		$bKeyUser = new Sessao();
		if($bLogged->getSessao("bLogged") && $bKeyUser->getSessao("bKeyUser"))
		{
			include 'view/pageKeyUserVisualizeRequirement.php';
		}
	}
	
	public function pageDeveloperVisualizeRequirement()
	{  
		$bLogged = new Sessao();
		$bDeveloper = new Sessao();
		if($bLogged->getSessao("bLogged") && $bDeveloper->getSessao("bDeveloper"))
		{
			include 'view/pageDeveloperVisualizeRequirement.php';
		}
	}
	
	public function pageAddTypeRequirement()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageAddTypeRequirement.php';
		}
	}
	
	public function pageAddDiagram()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageAddDiagram.php';
		}
	}
	
	public function pageLinkProject()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageLinkProject.php';
		}
	}
	
	public function pageLinkUser()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageLinkUser.php';
		}
	}
	
	public function pageVisualizeTypeRequirement()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageVisualizeTypeRequirement.php';
		}
	}
	
	public function pageVisualizeRequirement()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageVisualizeRequirement.php';
		}
	}
	
	public function pageVisualizeLiftingStakeHolder()
	{  
		$bLogged = new Sessao();
		$bStakeHolder = new Sessao();
		if($bLogged->getSessao("bLogged") && ($bStakeHolder->getSessao("bStakeHolder")) )
		{
			include 'view/pageVisualizeLiftingStakeHolder.php';
		}
	}
	
	public function pageVisualizeLiftingManager()
	{  
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && ($bManager->getSessao("bManager")) )
		{
			include 'view/pageVisualizeLiftingManager.php';
		}
	}
	
	public function pageStakeHolderVisualizeAllRequirementsProject()
	{  
		$bLogged = new Sessao();
		$bStakeHolder = new Sessao();
		if($bLogged->getSessao("bLogged") && ($bStakeHolder->getSessao("bStakeHolder")) )
		{
			include 'view/pageStakeHolderVisualizeAllRequirementsProject.php';
		}
	}
	
	public function pageManagerVisualizeAllRequirementsProject()
	{  
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && ($bManager->getSessao("bManager")) )
		{
			include 'view/pageManagerVisualizeAllRequirementsProject.php';
		}
	}
	
	public function pageDeveloperVisualizeAllRequirementsProject()
	{  
		$bLogged = new Sessao();
		$bDeveloper = new Sessao();
		if($bLogged->getSessao("bLogged") && $bDeveloper->getSessao("bDeveloper"))
		{
			include 'view/pageDeveloperVisualizeAllRequirementsProject.php';
		}
	}
	
	public function pageKeyUserVisualizeAllRequirementsProject()
	{  
		$bLogged = new Sessao();
		$bKeyUser = new Sessao();
		if($bLogged->getSessao("bLogged") && $bKeyUser->getSessao("bKeyUser"))
		{
			include 'view/pageKeyUserVisualizeAllRequirementsProject.php';
		}
	}
	
	public function pageEditTypeRequirement()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageEditTypeRequirement.php';
		}
	}
	
	public function pageEditDiagram()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageEditDiagram.php';
		}
	}
	
	public function pageEditUseCase()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageEditUseCase.php';
		}
	}
	
	public function pageEditActor()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageEditActor.php';
		}
	}
	
	public function pageEditRequirement()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageEditRequirement.php';
		}
	}
	
	public function pageAddRequirement()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
		
			include 'view/pageAddRequirement.php';
		}
	}
	
	public function pageAddActor()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageAddActor.php';
		}
	}
	
	public function pageAddUseCase()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageAddUseCase.php';
		}
	}
	
	public function pageAddUser()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
		
			include 'view/pageAddUser.php';
		}
	}
	
	public function pageAddProject()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageAddProject.php';
		}
	}
	
	public function pageVisualizeProject()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageVisualizeProject.php';
		}
	}
	
	public function pageVisualizeDiagram()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageVisualizeDiagram.php';
		}
	}
	
	public function pageVisualizeActor()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageVisualizeActor.php';
		}
	}
	
	public function pageVisualizeUseCase()
	{
		$bLogged = new Sessao();
		$bAnalyst = new Sessao();
		if($bLogged->getSessao("bLogged") && $bAnalyst->getSessao("bAnalyst"))
		{
			include 'view/pageVisualizeUseCase.php';
		}
	
	}
	
	public function pageEditProject()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageEditProject.php';
		}
	}
	
	public function pageAddTask()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
		
			include 'view/pageAddTask.php';
		}
	}
	
	public function pageVisualizeTask()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageVisualizeTask.php';
		}
	}

	public function pageEditTask()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageEditTask.php';
		}
		else
		{
			$sMessage = new Sessao();
			$sMessage->setSessao("sMessage","Tentando Acessar Sem Estar Logado? Logue-se imediatamente !!! ");
			$this->redirect('pagelogin');
		}
	}
	
	public function pageVisualizeUser()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageVisualizeUser.php';
		}
	}
	
	public function pageEditUser()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageEditUser.php';
		}
	}
	
	public function pageReportStatusProjects()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportStatusProjects.php';
		}
	}
	
	public function pageReportManagerProjects()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportManagerProjects.php';
		}
	}
	
	public function pageReportUserType()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportUserType.php';
		}
	}
	
	public function pageReportNotLinkUsers()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportUserType.php';
		}
	}
	
	public function pageReportLinkUsersProject()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportLinkUsersProject.php';
		}
	}
	
	public function pageReportProjectDateStart()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportProjectDateStart.php';
		}
	}
	
	public function pageReportProjectDateFinish()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportProjectDateFinish.php';
		}
	}
	
	public function pageReportProjectPeriod()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportProjectPeriod.php';
		}
	}
	
	public function pageReportDateInclusionUsers()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportDateInclusionUsers.php';
		}
	}
	
	public function pageReportTaskDateStart()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportTaskDateStart.php';
		}
	}
	
	public function pageReportTaskDateFinish()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportTaskDateFinish.php';
		}
	}
	
	public function pageReportTaskUsers()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportTaskUsers.php';
		}
	}
	
	public function pageReportTaskProjects()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportTaskProject.php';
		}
	}
	
	public function pageReportTaskPeriod()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportTaskPeriod.php';
		}
	}
	
	public function pageReportDiagramProject()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bAnalyst"))
		{
			include 'view/pageReportDiagramProject.php';
		}
	}
	
	public function pageReportUseCaseDiagram()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bAnalyst"))
		{
			include 'view/pageReportUseCaseDiagram.php';
		}
	}
		
	public function pageReportProjectRequirement()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bAnalyst"))
		{
			include 'view/pageReportProjectRequirement.php';
		}
	}
	
	public function pageReportTaskRequirement()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bManager"))
		{
			include 'view/pageReportTaskRequirement.php';
		}
	}
	
	public function pageReportRequirementTypeRequirement()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bAnalyst"))
		{
			include 'view/pageReportRequirementTypeRequirement.php';
		}
	}
	
	public function pageReportStartDateRequirement()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bAnalyst"))
		{
			include 'view/pageReportStartDateRequirement.php';
		}
	}
	
	public function pageReportFinishDateRequirement()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bAnalyst"))
		{
			include 'view/pageReportFinishDateRequirement.php';
		}
	}
	
	public function pageReportRequirementPeriod()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bAnalyst"))
		{
			include 'view/pageReportRequirementPeriod.php';
		}
	}
	
	public function pageReportSituationRequirement()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bAnalyst"))
		{
			include 'view/pageReportSituationRequirement.php';
		}
	}

	public function pageReportImportanceRequirement()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bAnalyst"))
		{
			include 'view/pageReportImportanceRequirement.php';
		}
	}
	
	public function pageReportApprovedRequirement()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bDeveloper"))
		{
			include 'view/pageReportApprovedRequirement.php';
		}
	}
	
	public function pageReportNotApprovedRequirement()
	{
		$bLogged = new Sessao();
		$bManager = new Sessao();
		if($bLogged->getSessao("bLogged") && $bManager->getSessao("bKeyUser"))
		{
			include 'view/pageReportNotApprovedRequirement.php';
		}
	}
	
	public function deslogar()
	{
	//	$bLogado = new Sessao();
	//	$bAdministrador = new Sessao();
		session_destroy();
		$this->redirectLogin('pagelogin');
	}
	
	public function redirectLogin($sPagina)
	{
		header ('Location:/ser/login/'.$sPagina);
	}
	
}
