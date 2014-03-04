<?php

namespace Netzmacht\Bootstrap\Form;

use Netzmacht\FormHelper\ElementContainerInterface;
use Netzmacht\FormHelper\GenerateInterface;
use Netzmacht\FormHelper\Html\AttributesTrait;
use Netzmacht\FormHelper\Html\Element;

/**
 * Class InputGroup
 * @package Netzmacht\Bootstrap\Form
 */
class InputGroup implements GenerateInterface, ElementContainerInterface
{
	use AttributesTrait;

	const ADDON = 'input-group-addon';

	const BUTTON = 'input-group-button';


	/**
	 * @var GenerateInterface|string
	 */
	protected $left;

	/**
	 * @var GenerateInterface|string
	 */
	protected $right;

	/**
	 * @var Element
	 */
	protected $element;


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
	 * @return GenerateInterface|string|null
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
	 * @return GenerateInterface|string|null
	 */
	public function getRight()
	{
		if(is_array($this->right)) {
			return $this->right['addon'];
		}

		return null;
	}


	/**
	 * @param Element $element
	 */
	public function setElement(Element $element)
	{
		$this->element = $element;
	}


	/**
	 * @return \Netzmacht\FormHelper\Html\Element
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
			'<div class="input-group">%s%s%s</div>',
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

		return Element::createElement('div')
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