<?php

	class Sessao
	{
		function __construct($key=null,$aValue=null)
		{
			$_SESSION[$key] = $aValue;
			
		}

		public function getSessao($key)
		{
			if (isset($_SESSION[$key]))
			{
				$sessao = $_SESSION[$key];
				return $sessao;
			}
		} 

		public function setSessao($key,$aValue)
		{
			$_SESSION[$key] = $aValue;
		}
		
		 public function existe( $key )
		{
			return isset($_SESSION[$key]);
		}
		
		public function destruir( $key )
		{
			unset( $_SESSION[$key] );
		}
		
	}