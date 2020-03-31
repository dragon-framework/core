<?php
namespace Dragon\Component\Directory;

class Directory 
{
	const DIRECTORY_BASE	= __DIR__ . "/../../../../../../";

	/**
	 * Path of the Project "config" directory
	 */
	const DIRECTORY_CONFIG	= self::DIRECTORY_BASE . "config/" ;

	/**
	 * Path of the Project "src" directory
	 */
	const DIRECTORY_SRC		= self::DIRECTORY_BASE . "src/";

	/**
	 * Path of the Project "src/Themes" directory
	 */
	const DIRECTORY_THEMES	= self::DIRECTORY_SRC . "Themes/";

	/**
	 * Path of the Project "public" directory
	 */
    const DIRECTORY_ROOT    = self::DIRECTORY_BASE . "public/";
}