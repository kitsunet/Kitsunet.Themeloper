<?php


namespace Kitsunet\Themeloper\TypoScript;


class ExtendedMenuImplementation extends \TYPO3\Neos\TypoScript\MenuImplementation {

	/**
	 * @var integer
	 */
	protected $entryLevel;

	/**
	 * @var string
	 */
	protected $filter;

	/**
	 * @var array
	 */
	protected $itemCollection;

	/**
	 * The last navigation level which should be rendered.
	 *
	 * 1 = first level of the site
	 * 2 = second level of the site
	 * ...
	 * 0  = same level as the current page
	 * -1 = one level above the current page
	 * -2 = two levels above the current page
	 * ...
	 *
	 * @return integer
	 */
	public function getEntryLevel() {
		if ($this->entryLevel === NULL) {
			$this->entryLevel = $this->tsValue('entryLevel');
		}

		return $this->entryLevel;
	}

	/**
	 * NodeType filter for nodes displayed in menu
	 *
	 * @return string
	 */
	public function getFilter() {
		if ($this->filter === NULL) {
			$this->filter = $this->tsValue('filter');
		}


		if ($this->filter === NULL) {
			return 'TYPO3.Neos:Document';
		}

		return $this->filter;
	}

	/**
	 * @return array
	 */
	public function getItemCollection() {
		if ($this->itemCollection === NULL) {
			$this->itemCollection = $this->tsValue('itemCollection');
		}

		return $this->itemCollection;
	}

	/**
	 * @return \TYPO3\TYPO3CR\Domain\Model\NodeInterface
	 */
	public function getCurrentNode() {
		if ($this->currentNode === NULL) {
			$this->currentNode = $this->tsValue('currentNode');

			if ($this->currentNode === NULL) {
				$typoScriptContext = $this->tsRuntime->getCurrentContext();
				$this->currentNode = isset($typoScriptContext['activeNode']) ? $typoScriptContext['activeNode'] : $typoScriptContext['documentNode'];
			}
		}

		return $this->currentNode;
	}

	/**
	 * @param int $lastLevel
	 */
	public function setLastLevel($lastLevel) {
		$this->lastLevel = $lastLevel;
	}

	/**
	 * @param int $maximumLevels
	 */
	public function setMaximumLevels($maximumLevels) {
		$this->maximumLevels = $maximumLevels;
	}

	/**
	 * @param boolean $renderHiddenInIndex
	 */
	public function setRenderHiddenInIndex($renderHiddenInIndex) {
		$this->renderHiddenInIndex = $renderHiddenInIndex;
	}

	/**
	 * @param \TYPO3\TYPO3CR\Domain\Model\NodeInterface $startingPoint
	 */
	public function setStartingPoint($startingPoint) {
		$this->startingPoint = $startingPoint;
	}

	/**
	 * @param integer $entryLevel
	 */
	public function setEntryLevel($entryLevel) {
		$this->entryLevel = $entryLevel;
	}

	/**
	 * @param string $filter
	 */
	public function setFilter($filter) {
		$this->filter = $filter;
	}

	/**
	 * @param array $itemCollection
	 */
	public function setItemCollection($itemCollection) {
		$this->itemCollection = $itemCollection;
	}

	/**
	 * @param \TYPO3\TYPO3CR\Domain\Model\NodeInterface $currentNode
	 */
	public function setCurrentNode($currentNode) {
		$this->currentNode = $currentNode;
	}

	/**
	 * @return array
	 */
	public function getItems() {
		if ($this->items === NULL) {
			$this->getCurrentNode();
			$this->currentLevel = 1;
			$this->items = $this->buildItems();
		}

		return $this->items;
	}
}