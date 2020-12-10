<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\ExchangeRateRisedEvent;
use App\Event\ExchangeRateDroppedEvent;
use App\Event\AbstractExchangeRateChangedEvent;
use App\Event\NewUserCreatedEvent;
use App\Service\NotificationService;
use App\Service\EmailSenderService;

/**
 * @author Karol Gancarczyk
 */
class EventSubscriber implements EventSubscriberInterface {

	private NotificationService $notificationService;
	private EmailSenderService $emailSenderService;

    public function __construct(NotificationService $notificationService, EmailSenderService $emailSenderService) {
        $this->notificationService = $notificationService;
		$this->emailSenderService = $emailSenderService;
    }

    public static function getSubscribedEvents() : array {
        return [
            ExchangeRateRisedEvent::class => 'onExchangeRateRisedEvent',
            ExchangeRateDroppedEvent::class => 'onExchangeRateDroppedEvent',
			NewUserCreatedEvent::class => 'onNewUserCreatedEvent',
        ];
    }


    public function onExchangeRateRisedEvent(ExchangeRateRisedEvent $event): void {
        $this->onExchangeRateChange($event);
    }

    public function onExchangeRateDroppedEvent(ExchangeRateDroppedEvent $event): void {
        $this->onExchangeRateChange($event);
    }
	
	private function onExchangeRateChange(AbstractExchangeRateChangedEvent $event) : void {

		$this->notificationService->notifyAllSubscribers($event);
	}
	
	public function onNewUserCreatedEvent(NewUserCreatedEvent $event) : void {
		$this->emailSenderService->sendUserRegistered($event->getUser());
	}
}