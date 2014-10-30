<?php
namespace Kitsunet\Themeloper\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Kitsunet.Themeloper".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Kitsunet\Themeloper\Exception;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper to execute EEL expressions
 *
 */
class EelViewHelper extends AbstractViewHelper {

	/**
	 * @var boolean
	 */
	protected $escapingInterceptorEnabled = FALSE;

	/**
	 * @param string $expression
	 * @param array $context
	 * @param object $contextObject
	 * @return mixed
	 * @throws Exception
	 */
	public function render($expression = NULL, array $context = NULL, $contextObject = NULL) {
		if ($expression === NULL) {
			$expression = $this->renderChildren();
			if ($expression === NULL) {
				return '';
			}
		}

		if ($context === NULL) {
			try {
				$context = $this->viewHelperVariableContainer->getView()->getTypoScriptObject()->getTsRuntime()->getCurrentContext();
			} catch (\Exception $exception) {
				throw new Exception('The EelViewHelper either needs a context array or be invoked inside a TypoScript Template.', 1401564603);
			}
		}

		$output = $this->evaluateEelExpression($expression, $context, $contextObject);

		return $output;
	}

	/**
	 * @param string $expression
	 * @param array $contextVariables
	 * @param object $contextObject
	 * @return mixed
	 */
	protected function evaluateEelExpression($expression, array $contextVariables, $contextObject = NULL) {
		$typoScriptArray = array(
			'expression' => array(
				'__eelExpression' => $expression
			)
		);

		$temporaryRuntime = new \TYPO3\TypoScript\Core\Runtime($typoScriptArray, $this->controllerContext);
		$temporaryRuntime->pushContextArray($contextVariables);
		$result = $temporaryRuntime->evaluate('/expression', $contextObject);

		return $result;
	}
}
