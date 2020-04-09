<?php
namespace Dragon\Component\Directory;

class Directory 
{
	const DIRECTORY_APP_BASE	= __DIR__ . DS . ".." . DS . ".." . DS . ".." . DS . ".." . DS . ".." . DS . ".." . DS;

	/**
	 * Path of the Project "config" directory
	 */
	const DIRECTORY_APP_CONFIG	= self::DIRECTORY_APP_BASE . "config" . DS ;

	/**
	 * Path of the Project "src" directory
	 */
	const DIRECTORY_APP_SRC		= self::DIRECTORY_APP_BASE . "src" . DS;

	/**
	 * Path of the Project "src/Themes" directory
	 */
	const DIRECTORY_APP_THEMES	= self::DIRECTORY_APP_SRC . "Themes" . DS;

	/**
	 * Path of the Project "src/Extension" directory
	 */
	const DIRECTORY_APP_EXTENSIONS	= self::DIRECTORY_APP_SRC . "Extensions" . DS;
	const DIRECTORY_CORE_EXTENSIONS	= __DIR__ . DS . ".." . DS . "Extensions" . DS;

	/**
	 * Path of the Project "public" directory
	 */
    const DIRECTORY_APP_ROOT    = self::DIRECTORY_APP_BASE . "public" . DS;
}