<?php
/**
 * This file is part of the O2System PHP Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author         Steeve Andrian Salim
 * @copyright      Copyright (c) Steeve Andrian Salim
 */
// ------------------------------------------------------------------------

// Define SPL_PATH
define( 'SPL_PATH', __DIR__ . DIRECTORY_SEPARATOR );

/**
 * O2System Spl Autoload
 *
 * @param $className
 */
spl_autoload_register(
	function ( $className )
	{
		if ( strpos( $className, 'O2System\Spl\\' ) === FALSE )
		{
			return;
		}

		$className = ltrim( $className, '\\' );
		$filePath  = '';

		if ( $lastNsPos = strripos( $className, '\\' ) )
		{
			$namespace = substr( $className, 0, $lastNsPos );
			$className = substr( $className, $lastNsPos + 1 );
			$filePath  = str_replace( '\\', DIRECTORY_SEPARATOR, $namespace ) . DIRECTORY_SEPARATOR;
		}

		$filePath .= str_replace( '_', DIRECTORY_SEPARATOR, $className ) . '.php';

		// Fixed Path
		$filePath = str_replace( 'O2System\Spl\\', SPL_PATH, $filePath );

		if ( file_exists( $filePath ) )
		{
			require $filePath;
		}

	}, TRUE, TRUE );
