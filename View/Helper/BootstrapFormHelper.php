<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * Licensed under The MIT License
 *
 * Copyright (c) La Pâtisserie, Inc. (http://patisserie.keensoftware.com/)
 * @license     MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('FormHelper', 'View/Helper');

class BootstrapFormHelper extends FormHelper {

/**
 * Default input values with bootstrap classes
 * Changed order of error and after to be able to display validation error messages inline
 */
	protected $_inputDefaults = array(
		'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
		'div' => 'control-group',
		'label' => array('class' => 'control-label'),
		'between' => '<div class="controls">',
		'after' => '</div>',
		'class' => 'input-xxlarge',
		'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))
	);

/**
 * Added an array_merge_recursive for labels to combine $_inputDefaults with specific view markup for labels like custom text.
 * Also removed null array for options existing in $_inputDefaults.
 */
	protected function _parseOptions($options) {
		if (!empty($options['label'])) {
			//manage case 'label' => 'your label' as well as 'label' => array('text' => 'your label') before array_merge()
			if (!is_array($options['label'])) {
				$options['label'] = array('text' => $options['label']);
			}
			$options['label'] = array_merge_recursive($options['label'], $this->_inputDefaults['label']);
		}
		$options = array_merge(
			array('before' => null),
			$this->_inputDefaults,
			$options
		);
		return parent::_parseOptions($options);
	}

/**
 * adds the default class 'form-horizontal to the <form>
 * 
 */
	public function create($model = null, $options = array()) {
		$class = array(
			'class' => 'form-horizontal',
		);
		$options = array_merge($class, $options);
		return parent::create($model, $options);
	}

/**
 * modified the first condition with a more general empty() otherwise if $default is an empty array
 * !is_null() returns true and $this->_inputDefaults is erased
 */
	public function inputDefaults($defaults = null, $merge = false) {
		if (!empty($defaults)) {
			if ($merge) {
				$this->_inputDefaults = array_merge($this->_inputDefaults, (array)$defaults);
			} else {
				$this->_inputDefaults = (array)$defaults;
			}
		}
		return $this->_inputDefaults;
	}

}

