<?php
namespace Kitsunet\Themeloper\TypoScript;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Kitsunet.Themeloper".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\TypoScript\TypoScriptObjects\AbstractTypoScriptObject;

/**
 * A TypoScript Object that takes a given TypoScript path and returns true or false depending if that path seems renderable.
 *
 * Usage::
 *
 *   condition = Kitsunet.Themeloper:CanRender {
 *     path = '/some/path'
 *   }
 */
class CanRenderImplementation extends AbstractTypoScriptObject {

	/**
	 * The path to be checked
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->tsValue('path');
	}

	/**
	 * Convert URIs matching a supported scheme with generated URIs
	 *
	 * If the workspace of the current node context is not live, no replacement will be done. This is needed to show
	 * the editable links with metadata in the content module.
	 *
	 * @return string
	 */
	public function evaluate() {
		$path = $this->getPath();
		if (!is_string($path) || $path === '') {
			return FALSE;
		}

		if ($path{0} === '/') {
			$canRender = $this->tsRuntime->canRender(substr($path, 1));
		} else {
			$basePath = $this->path;
			if (substr($path, 0, 2) === '..') {
				$pathElements = explode('/', $path);
				$thisPathElements = explode('/', $this->path);
				foreach ($pathElements as $pathElement) {
					if ($pathElement === '..') {
						array_pop($thisPathElements);
					} else {
						break;
					}
				}

				$basePath = implode('/', $thisPathElements);
			}

			$canRender = $this->tsRuntime->render($basePath . '/' . str_replace('.', '/', $path));
		}

		return $canRender;
	}

}
