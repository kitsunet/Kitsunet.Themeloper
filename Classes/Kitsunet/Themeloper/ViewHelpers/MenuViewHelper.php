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
use Kitsunet\Themeloper\TypoScript\ExtendedMenuImplementation;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

/**
 * ViewHelper to generate Menus in Themes.
 *
 * WARNING: This ViewHelpers code should not be seen as best practice and works only inside a Template rendered via TypoScript currently.
 *
 */
class MenuViewHelper extends AbstractViewHelper {

	/**
	 * @var boolean
	 */
	protected $escapingInterceptorEnabled = FALSE;

	/**
	 *
	 * @param NodeInterface $startingPoint
	 * @param integer $entryLevel
	 * @param integer $maximumLevels
	 * @param array $itemCollection
	 * @param string $filter
	 * @param boolean $renderHiddenInIndex
	 * @return string
	 */
	public function render($startingPoint, $entryLevel = 1, $maximumLevels = 1, $itemCollection = NULL, $filter = 'TYPO3.Neos:Document', $renderHiddenInIndex = FALSE, $currentNode = NULL) {
		$parentTypoScriptObject = $this->viewHelperVariableContainer->getView()->getTypoScriptObject();
		$typoScriptRuntime = $parentTypoScriptObject->getTsRuntime();

		$menuRenderer = new ExtendedMenuImplementation($typoScriptRuntime, '/themeloper/' . uniqid('menu-', true), 'Kitsunet.Themeloper:ViewHelperMenu');
		$menuRenderer->setStartingPoint($startingPoint);
		$menuRenderer->setEntryLevel($entryLevel);
		$menuRenderer->setMaximumLevels($maximumLevels);
		$menuRenderer->setItemCollection($itemCollection);
		$menuRenderer->setFilter($filter);
		$menuRenderer->setRenderHiddenInIndex($renderHiddenInIndex);
		$menuRenderer->setCurrentNode($currentNode);

		$this->templateVariableContainer->add('menuItems', $menuRenderer->getItems());
		$menuHtml = $this->renderChildren();
		$this->templateVariableContainer->remove('menuItems');

		return $menuHtml;
	}
}
