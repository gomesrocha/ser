<?php
	
	class CommonFunctions
	{
	

		public static function readJSON($sDatabaseName, $sClassName = null)
		{
			
			if (file_exists($sDatabaseName))
			{
				$oJSONFile = file_get_contents($sDatabaseName);
				$oJSONDecoded = json_decode($oJSONFile,true);

				switch (json_last_error())
				{
		        	case JSON_ERROR_NONE:
		      	//      echo ' - No errors';
		        	break;
		        	case JSON_ERROR_DEPTH:
		      //    	echo ' - Maximum stack depth exceeded';
		        	break;
		        	case JSON_ERROR_STATE_MISMATCH:
		      //    	echo ' - Underflow or the modes mismatch';
		        	break;
		        	case JSON_ERROR_CTRL_CHAR:
		       //     echo ' - Unexpected control character found';
		        	break;
		        	case JSON_ERROR_SYNTAX:
		       //     echo ' - Syntax error, malformed JSON';
		        	break;
		        	case JSON_ERROR_UTF8:
		       //     echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
		        	break;
		        	default:
		       //     echo ' - Unknown error';
		        	break;
				}		
				
				if($sClassName == null)
				{
					return $oJSONDecoded;
				}

				$aData = array();
				foreach ($oJSONDecoded as $oCurrentJSON)
				{
					$oActualData = new $sClassName();
					$oActualData->set($oCurrentJSON);
					$aData[] = $oActualData;	
				}
				return $aData;
			}
			else
			{
				return null;
			}
		}
	}