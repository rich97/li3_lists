<?php

namespace li3_lists\extensions\helper;

class Lists extends \lithium\template\Helper {

    protected $_append = true;

    protected $_liOptions = array();

    protected $_ulOptions = array();

	protected $_list = array();

	public function __construct(array $config = array()) {
		parent::__construct($config);
		$this->_config($config);
	}

	public function __call($name, array $params) {
		$params = $params + array(null, array());
		list($data, $config) = $params;

		$this->_config($config);
		if ($data !== null) {
			$this->_add($name, $data);
		}

		return $this->_generate($name);
	}

	protected function _add($name, $data = array()) {
		if (empty($data)) {
			return false;
		}

		$data = (array) $data;
		if (array_key_exists($name, $this->_list)) {
			if (empty($this->_list)) {
				$this->_list[$name] = array();
			}

			if ($this->_append) {
				if ($this->_append === true || $this->_append === 'append') {
					foreach ($data as $item) {
						array_push($this->_list[$name], $item);
					}
				}

				if ($this->_append === 'prepend') {
					foreach ($data as $item) {
						array_unshift($this->_list[$name], $item);
					}
				}
			}
		} else {
			$this->_list[$name] = $data;
		}
	}

	protected function _generate($name, $data = null) {
		if ($data) {
			return $this->_context->html->nestedList(
				$data, $this->_liOptions, $this->_ulOptions
			);
		}

		if (array_key_exists($name, $this->_list)) {
			return $this->_context->html->nestedList(
				$this->_list[$name],
				$this->_liOptions,
				$this->_ulOptions
			);
		}
		return null;
	}

    protected function _config(array $config = array()) {
        if (empty($config['append'])) {
            $config['append'] = true;
        }
        $this->_append = $config['append'];

		$config += array('li' => array(), 'ul' => array());
		$this->_liOptions = $config['li'];
		$this->_ulOptions = $config['ul'];
    }

}
