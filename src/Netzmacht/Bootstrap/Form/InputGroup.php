<?php

namespace Netzmacht\Bootstrap\Form;

use Netzmacht\FormHelper\Component;
use Netzmacht\FormHelper\HasElement;
use Netzmacht\Html\Attributes;
use Netzmacht\Html\CastsToString;
use Netzmacht\Html\Element;

/**
 * Class InputGroup
 * @package Netzmacht\Bootstrap\Form
 */
class InputGroup extends Component implements HasElement
{

	const ADDON = 'input-group-addon';

	const BUTTON = 'input-group-btn';


	/**
	 * @var CastsToString|string
	 */
	protected $left;

	/**
	 * @var CastsToString|string
	 */
	protected $right;

	/**
	 * @var Element
	 */
	protected $element;


	/**
	 * @param array $attributes
	 */
	function __construct(array $attributes=array())
	{
		parent::__construct($attributes);
		$this->addClass('input-group');
	}


	/**
	 * @param $addon
	 * @param string $type
	 */
	public function setLeft($addon, $type=InputGroup::ADDON)
	{
		$this->left = array(
			'addon' => $addon,
			'type'  => $type,
		);
	}


	/**
	 * @return CastsToString|null
	 */
	public function getLeft()
	{
		if(is_array($this->left)) {
			return $this->left['addon'];
		}

		return null;
	}


	/**
	 * @param $addon
	 * @param string $type
	 */
	public function setRight($addon, $type=InputGroup::ADDON)
	{
		$this->right = array(
			'addon' => $addon,
			'type'  => $type,
		);
	}


	/**
	 * @return CastsToString|null
	 */
	public function getRight()
	{
		if(is_array($this->right)) {
			return $this->right['addon'];
		}

		return null;
	}


	/**
	 * @param $element
	 * @return $this
	 */
	public function setElement($element)
	{
		$this->element = $element;

		return $this;
	}


	/**
	 * @return \Netzmacht\Html\Element
	 */
	public function getElement()
	{
		return $this->element;
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		return sprintf(
			'<div %s>%s%s%s</div>',
			$this->attributes,
			$this->generateAddon($this->left),
			$this->element,
			$this->generateAddon($this->right)
		);
	}


	/**
	 * @param $addon
	 * @return string
	 */
	protected function generateAddon($addon)
	{
		if(!is_array($addon)) {
			return '';
		}

		return Element::create('div')
			->addClass($addon['type'])
			->addChild($addon['addon'])
			->generate();
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->generate();
	}

}