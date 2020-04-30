<?php
namespace Dragon\Component\Directory;

class Directory 
{
	const DIRECTORY_APP_BASE		= __DIR__ . DS . ".." . DS . ".." . DS . ".." . DS . ".." . DS . ".." . DS . ".." . DS;

	/**
	 * Path of the Project "config" directory
	 */
	const DIRECTORY_APP_CONFIG		= self::DIRECTORY_APP_BASE . "config" . DS ;
	const DIRECTORY_CORE_CONFIG		= __DIR__ . DS . ".." . DS . "Config" . DS . "Resources" . DS;

	/**
	 * Path of the Project "src" directory
	 */
	const DIRECTORY_APP_SRC			= self::DIRECTORY_APP_BASE . "src" . DS;

	/**
	 * Path of the Project "src/Templates" directory
	 */
	const DIRECTORY_APP_TEMPLATES	= self::DIRECTORY_APP_SRC . "Templates" . DS;
	const DIRECTORY_CORE_TEMPLATES 	= __DIR__ . DS . ".." . DS . "Templates" . DS;

	/**
	 * Path of the Project "src/Extension" directory
	 */
	const DIRECTORY_APP_EXTENSIONS	= self::DIRECTORY_APP_SRC . "Extensions" . DS;
	const DIRECTORY_CORE_EXTENSIONS	= __DIR__ . DS . ".." . DS . "Extensions" . DS;

	/**
	 * Path of the Project "public" directory
	 */
	const DIRECTORY_APP_ROOT    	= self::DIRECTORY_APP_BASE . "public" . DS;
	
	const DIRECTORY_DOC				= __DIR__ . DS . ".." . DS . ".." . DS . ".." . DS . "doc" . DS;

}