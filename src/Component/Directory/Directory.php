<?php
namespace Dragon\Component\Directory;

class Directory 
{
	const DIRECTORY_APP_BASE	= __DIR__ . "/../../../../../../";

	/**
	 * Path of the Project "config" directory
	 */
	const DIRECTORY_APP_CONFIG	= self::DIRECTORY_APP_BASE . "config/" ;

	/**
	 * Path of the Project "src" directory
	 */
	const DIRECTORY_APP_SRC		= self::DIRECTORY_APP_BASE . "src/";

	/**
	 * Path of the Project "src/Themes" directory
	 */
	const DIRECTORY_APP_THEMES	= self::DIRECTORY_APP_SRC . "Themes/";

	/**
	 * Path of the Project "src/Extension" directory
	 */
	const DIRECTORY_APP_EXTENSIONS	= self::DIRECTORY_APP_SRC . "Extension/";
	const DIRECTORY_CORE_EXTENSIONS	= self::DIRECTORY_APP_SRC . "Extension/";

	/**
	 * Path of the Project "public" directory
	 */
    const DIRECTORY_APP_ROOT    = self::DIRECTORY_APP_BASE . "public/";
}