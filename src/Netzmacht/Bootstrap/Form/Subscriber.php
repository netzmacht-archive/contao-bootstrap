<?php

namespace Netzmacht\Bootstrap\Form;


use Netzmacht\Bootstrap\Bootstrap;
use Netzmacht\Bootstrap\Helper\Icons;
use Netzmacht\Contao\FormHelper\Element\StaticHtml;
use Netzmacht\Contao\FormHelper\Event\BuildElementEvent;
use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\FormHelper\Event\GenerateEvent;
use Netzmacht\FormHelper\Event\SelectLayoutEvent;
use Netzmacht\Contao\FormHelper\Partial\Label;
use Netzmacht\Html\CastsToString;
use Netzmacht\Html\Element;
use Netzmacht\Contao\FormHelper\Partial\Container;
use Netzmacht\Html\Element\Node;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class Subscriber implements EventSubscriberInterface
{

	/**
	 * Returns an array of event names this subscriber wants to listen to.
	 *
	 * The array keys are event names and the value can be:
	 *
	 *  * The method name to call (priority defaults to 0)
	 *  * An array composed of the method name to call and the priority
	 *  * An array of arrays composed of the method names to call and respective
	 *    priorities, or 0 if unset
	 *
	 * For instance:
	 *
	 *  * array('eventName' => 'methodName')
	 *  * array('eventName' => array('methodName', $priority))
	 *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
	 *
	 * @return array The event names to listen to
	 *
	 * @api
	 */
	public static function getSubscribedEvents()
	{
		return array(
			Events::BUILD_ELEMENT => 'buildElement',
			Events::SELECT_LAYOUT => 'selectLayout',
			Events::GENERATE => 'generate',
		);
	}


	/**
	 * @param \Netzmacht\Contao\FormHelper\Event\BuildElementEvent $event
	 */
	public function buildElement(BuildElementEvent $event)
	{
		$widget = $event->getWidget();

		if($widget->type == 'button') {
			$element = Element::create('button', array('type' => 'submit'));

			if($widget->imageSubmit) {
				$img = \Image::getHtml(\FilesModel::findByPk($widget->singleSRC)->path, $widget->slabel);
				$element->addChild($img);
			}
			else {
				$element->addChild($widget->slabel);
				$element
					->addClass('btn')
					->addClass($widget->class ?: 'btn-default');
			}

			if($widget->bootstrap_addIcon) {
				$icon = Icons::generateIcon($widget->bootstrap_icon);

				if($widget->bootstrap_iconPosition == 'left') {
					$element->addChild($icon . ' ', Node::POSITION_FIRST);
				}
				else {
					$element->addChild(' ' . $icon);
				}
			}

			$event->setElement($element);
		}
	}


	/**
	 * @param SelectLayoutEvent $event
	 */
	public function selectLayout(SelectLayoutEvent $event)
	{
		if(Bootstrap::isEnabled()) {
			$event->setLayout('bootstrap');
		}
	}


	/**
	 * @param GenerateEvent $event
	 */
	public function generate(GenerateEvent $event)
	{
		$container = $event->getContainer();
		$element   = $event->getContainer()->getElement();
		$widget    = $event->getWidget();
		$label     = $event->getLabel();
		$errors    = $event->getErrors();

		// add label class
		$label->addClass('control-label');
		$errors->addClass('help-block');

		if(!$widget->label || $this->getConfig($widget->type, 'noLabel')) {
			$label->hide();
		}

		$this->setColumnLayout($widget, $container, $label);
		$this->adjustElement($event, $element, $widget, $container);
		$this->addInputGroup($widget, $container, $element);

		// inject errors into container
		$container->addChild('errors', $errors);
	}


	/**
	 * @param Container $container
	 */
	protected function generateUpload(Container $container)
	{
		$config  = $GLOBALS['BOOTSTRAP']['form']['styledUpload'];
		$element = $container->getElement();

		/** @var Element $element */
		$element->addClass('sr-only');
		$element->setAttribute('onchange', sprintf($config['onchange'], $element->getId()));

		$input = Element::create('input', array('type' => 'text'))
			->setId($element->getId() . '_value')
			->addClass('form-control')
			->setAttribute('disabled', true)
			->setAttribute('name', $element->getAttribute('name') . '_value');

		if($element->hasAttribute('placeholder')) {
			$input->setAttribute('placeholder', $element->getAttribute('placeholder'));
		}

		$click = sprintf('$(%s).click();return false;', $element->getId());
		$submit = Element::create('button', array('type' => 'submit'))
			->addChild($config['label'])
			->addClass($config['class'])
			->setAttribute('onclick', $click);

		$inputGroup = new InputGroup();
		$inputGroup->setElement($input);

		if($config['position'] == 'left') {
			$inputGroup->setLeft($submit, $inputGroup::BUTTON);
		}
		else {
			$inputGroup->setRight($submit, $inputGroup::BUTTON);
		}

		$container->addChild('upload', $inputGroup);
	}


	/**
	 * @param $type
	 * @param $name
	 * @return mixed
	 */
	protected function getConfig($type, $name)
	{
		if(!isset($GLOBALS['BOOTSTRAP']['form']['widgets'][$type])) {
			return false;
		}

		if(isset($GLOBALS['BOOTSTRAP']['form']['widgets'][$type][$name])) {
			return $GLOBALS['BOOTSTRAP']['form']['widgets'][$type][$name];
		}

		return false;
	}

	/**
	 * @param GenerateEvent $event
	 * @param $element
	 * @param $widget
	 * @param $container
	 */
	private function adjustElement(GenerateEvent $event, $element, $widget, $container)
	{
		if($element instanceof Element) {
			// apply form control class to the element
			if(!$this->getConfig($widget->type, 'noFormControl')) {
				$element->addClass('form-control');
			}

			// enable styled select
			if($GLOBALS['BOOTSTRAP']['form']['styleSelect']['enabled'] && $this->getConfig($widget->type, 'styleSelect')) {
				$element->addClass($GLOBALS['BOOTSTRAP']['form']['styleSelect']['class']);
				$element->setAttribute('data-style', $GLOBALS['BOOTSTRAP']['form']['styleSelect']['style']);
			}

			if($event->getWidget()->type == 'upload' && $GLOBALS['BOOTSTRAP']['form']['styledUpload']['enabled']) {
				$this->generateUpload($container);
			}
		}
	}

	/**
	 * @param $widget
	 * @param $container
	 * @param $label
	 */
	private function setColumnLayout($widget, Container $container, Label $label)
	{
		if(!$widget->tableless) {
			$container->setRenderContainer(true);
			$container->addClass($GLOBALS['BOOTSTRAP']['form']['tableFormat']['control']);

			if(!$widget->label || $this->getConfig($widget->type, 'noLabel')) {
				$container->addClass($GLOBALS['BOOTSTRAP']['form']['tableFormat']['offset']);
			} else {
				$label->addClass($GLOBALS['BOOTSTRAP']['form']['tableFormat']['label']);
			}
		}
	}

	/**
	 * @param $widget
	 * @param $inputGroup
	 * @return string
	 */
	private function addIcon($widget, InputGroup $inputGroup)
	{
		if($widget->bootstrap_addIcon) {
			$icon = Icons::generateIcon($widget->bootstrap_icon);

			if($widget->bootstrap_iconPosition == 'right') {
				$inputGroup->setRight($icon);
			} else {
				$inputGroup->setLeft($icon);
			}
		}
	}

	/**
	 * @param $widget
	 * @param InputGroup $inputGroup
	 */
	private function addUnit($widget, InputGroup $inputGroup)
	{
		// add unit
		if($widget->bootstrap_addUnit) {
			if($widget->bootstrap_unitPosition == 'right') {
				$inputGroup->setRight($widget->bootstrap_unit);
			} else {
				$inputGroup->setLeft($widget->bootstrap_unit);
			}
		}
	}

	/**
	 * @param $container
	 * @param $widget
	 * @param $inputGroup
	 */
	private function adjustSubmitButton(Container $container, $widget, InputGroup $inputGroup)
	{
		if($container->hasChild('submit')) {
			/** @var Node $submit */
			$submit = $container->removeChild('submit');

			// recreate as button
			if($submit->getTag() != 'button') {
				$submit = Element::create('button');
				$submit->setAttribute('type', 'submit');
				$submit->addChild($widget->slabel);
			}

			$submit->addClass('btn');

			if($widget->bootstrap_addSubmitClass) {
				$submit->addClass($widget->bootstrap_addSubmitClass);
			}

			if($widget->bootstrap_addSubmitIcon) {
				$icon     = Icons::generateIcon($widget->bootstrap_addSubmitIcon);
				$position = null;

				if($widget->bootstrap_addSubmitIconPosition == 'left') {
					$position = Node::POSITION_FIRST;
					$icon .= ' ';
				} else {
					$icon = ' ' . $icon;
				}

				$submit->addChild(new StaticHtml($icon), $position);
			}

			$inputGroup->setRight($submit, $inputGroup::BUTTON);
		}
	}

	/**
	 * @param $widget
	 * @param $container
	 * @param $inputGroup
	 */
	private function adjustCaptcha($widget, Container $container, InputGroup $inputGroup)
	{
		if($widget instanceof \FormCaptcha) {
			$captcha = $container->removeChild('question');
			$inputGroup->setRight($captcha);
		}
	}

	/**
	 * @param $widget
	 * @param $container
	 * @param $element
	 */
	private function addInputGroup($widget, Container $container, CastsToString $element)
	{
		if($this->getConfig($widget->type, 'allowInputGroup') &&
			($widget->bootstrap_addIcon ||
				$widget->bootstrap_addUnit ||
				$container->hasChild('submit') ||
				$widget->type == 'captcha'
			)
		) {
			$inputGroup = new InputGroup();
			$inputGroup->setElement($element);
			$container->setWrapper($inputGroup);

			$this->addIcon($widget, $inputGroup);
			$this->addUnit($widget, $inputGroup);
			$this->adjustSubmitButton($container, $widget, $inputGroup);
			$this->adjustCaptcha($widget, $container, $inputGroup);
		}
	}

}