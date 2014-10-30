<?php
namespace Kitsunet\Themeloper\Eel\Helper;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Kitsunet.Themeloper".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Eel\ProtectedContextAwareInterface;
use TYPO3\Flow\Annotations as Flow;

/**
 * Resource helpers for Eel contexts
 */
class ResourceHelper implements ProtectedContextAwareInterface {

	/**
	 * @param string $resourcePath
	 * @return boolean
	 */
	public function exists($resourcePath) {
		return file_exists($resourcePath);
	}

	/**
	 * All methods are considered safe
	 *
	 * @param string $methodName
	 * @return boolean
	 */
	public function allowsCallOfMethod($methodName) {
		return TRUE;
	}

}
