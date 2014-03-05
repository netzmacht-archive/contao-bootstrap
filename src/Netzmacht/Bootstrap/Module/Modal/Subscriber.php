<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 05.03.14
 * Time: 16:45
 */

namespace Netzmacht\Bootstrap\Module\Modal;


use Netzmacht\FormHelper\Event\Events;
use Netzmacht\FormHelper\Event\GenerateEvent;
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
		return array (
			Events::GENERATE => 'createModalFooter'
		);
	}


	/**
	 * @param GenerateEvent $event
	 */
	public function createModalFooter(GenerateEvent $event)
	{
		$widget  = $event->getWidget();
		$element = $event->getContainer()->getElement();

		if($this->isModal($widget)) {
			// create copy for footer
			$copy = clone $element;
			$copy->setAttribute('onclick', sprintf('$(\'#ctrl_%s\').click();', $widget->id));
			$copy->setId('md_' . $element->getId());
			$copy->addClass('btn');

			$GLOBALS['bootstrapModalForm'] .= $copy->generate();
			$event->setVisible(false);
		}
	}


	/**
	 * @param \Widget $widget
	 * @return bool
	 */
	protected function isModal(\Widget $widget)
	{
		$isModal = isset($GLOBALS['bootstrapModalForm']) &&
			$GLOBALS['BOOTSTRAP']['modal']['adjustForm'] &&
			$GLOBALS['BOOTSTRAP']['form']['widgets'][$widget->type]['modalFooter'];

		return $isModal;
	}

} 