<?php

	class SerDatabaseHandler
	{
		private static $sUsuario ;
		private static $sHost;
		private static $sSenha; 
		private static $aInstance;
		private static $sBanco;

		public function __construct($aConfig)
		{

			$aInstance = array();
			
			if(isset($aConfig["host"]))
			{
				self::$sHost = $aConfig["host"];
			}

			if(isset($aConfig["banco"]))
			{
				self::$sBanco = $aConfig["banco"];

			}

			if(isset($aConfig["usuario"]))
			{
				self::$sUsuario = $aConfig["usuario"];
			}

			if(isset($aConfig["senha"]))
			{
				self::$sSenha = $aConfig["senha"];
			}

		}

		public static function getInstance()
		{
			if(!empty(self::$aInstance))
			{
				return self::$aInstance[0];
			} 
			
			try
			{
				self::$aInstance[0] = new PDO('mysql:host=mysql873.umbler.com;dbname=midasdb',self::$sUsuario,self::$sSenha);
				self::$aInstance[0]->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOException $e )
			{
				echo 'Erro ao se conectar '.$e->getMessage();
			}
			return self::$aInstance[0];
		}

		public static function getNewInstance()
		{
			try
			{
				$novaConexao = new PDO('mysql:host=mysql873.umbler.com;dbname=midasdb',self::$sUsuario,self::$sSenha);
				$novaConexao->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				self::$aInstance[] = $novaConexao;
			}
			catch(PDOException $e)
			{
				echo 'Erro ao se conectar: '.$e->getMessage();
			}
			return end(self::$aInstance);
		}

        public static function add($sSql,$rOtherConnection,$aArrayParams)
        {
            try
            {
                $sStm = $rOtherConnection->prepare($sSql);
                if (!empty($aArrayParams))
                {  
                    $iCont = 1;   
                    foreach ($aArrayParams as $sValor)
                    {   
                        $sStm->bindValue($iCont, $sValor);   
                        $iCont++;   
                    }   
                }
                $sStm->execute();  
            } 
            catch (PDOException $e)
            {
                echo "Erro Na Consulta: ".$e->getMessage();
            }
        }

        public static function deleteDate($sSql,$rOtherConnection,$aArrayParams)
        {
            try
            {
                $sStm = $rOtherConnection->prepare($sSql);
                if (!empty($aArrayParams))
                {  
                    $iCont = 1;   
                    foreach ($aArrayParams as $sValor)
                    {   
                        $sStm->bindValue($iCont, $sValor);   
                        $iCont++;   
                    }   
                }
                return $sStm->execute();  
            } 
            catch (PDOException $e)
            {
                echo "Impossivel Deletar. Registro É Referencia Em Outra Tabela !!! ".$e->getMessage();
            }
        }

        public static function update($sSql,$rOtherConnection,$aArrayParams,$aArrayCondicao)
        {

            try
            {

                $sStm = $rOtherConnection->prepare($sSql);
                $iCont = 1;   
				if(!empty($aArrayParams))
				{
					foreach ($aArrayParams as $sValor)
					{   
						$sStm->bindValue($iCont, $sValor);   
						$iCont++;   
					}
				}					
        
                foreach ($aArrayCondicao as $valor)
                {  
                    $sStm->bindValue($iCont, $valor);   
                    $iCont++;   
                }
    
                $sStm->execute();  
            
            } 
            catch (PDOException $e)
            {
                echo "Erro Na Consulta: ".$e->getMessage();
            }
        }

        public static function query($sSql,$rOtherConnection,$arrayParams,$fetchAll = true)
        {
            try
            {
                $sStm = $rOtherConnection->prepare($sSql);
                if (!empty($arrayParams))
                {  
                    $iCont = 1;   
                    foreach ($arrayParams as $sValor)
                    {   
                        $sStm->bindValue($iCont, $sValor);   
                        $iCont++;   
                    }   
                }
    
                $sStm->execute();   
                if($fetchAll)
                {  
                    $aDados = $sStm->fetchAll(PDO::FETCH_ASSOC);  
                } 
                else  
                {
                    $aDados = $sStm->fetch(PDO::FETCH_ASSOC);   
                }
          
                return $aDados;   
            }
            catch (PDOException $e)
            {
                echo "Erro Na Consulta: ".$e->getMessage();
            }
        }

		public function begin($rConnection)
		{
			$rConnection->beginTransaction();
			return $rConnection;

		}

		public function commit($rConnection)
		{
			$rConnection->commit();
		}
		
		public function roolBack($rConnection)
		{
			$rConnection->roolBack();
		}

		public function close($rConnection)
		{
			$rConnection = null;
			//self::$aInstance[0] = null;
			//return self::$aInstance[0];
		}

		public function closeAll()
		{
			foreach(self::$aInstance as &$aConexao)
			{
				$aConexao = null;
			}
			unset($aConexao);
			return self::$aInstance;
		}

		public  function execute($sSql)
		{	
			$sSql->execute();
		}
	
	}


