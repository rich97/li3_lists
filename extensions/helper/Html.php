<?php

namespace li3_lists\extensions\helper;

class Html extends \lithium\template\helper\Html {

	public function nestedList($list, $liOptions = array(), $ulOptions = array()) {
		$content = '';
		foreach ($list as $item) {
			if (is_array($item)) {
				$item = $this->nestedList($item, $liOptions);
			}

			list($scope, $options) = $this->_options(array('escape' => true), $liOptions);
			$content .= $this->_render(
				__METHOD__, 'list-item', array('content' => $item) + compact('options'), $scope
			);
		}

		list($scope, $options) = $this->_options(array('escape' => false), $ulOptions);
		return $this->_render(__METHOD__, 'list', compact('content', 'options'), $scope);
	}

}
