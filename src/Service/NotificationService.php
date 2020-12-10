<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Event\ExchangeRateRisedEvent;
use App\Event\ExchangeRateDroppedEvent;
use App\Event\AbstractExchangeRateChangedEvent;
use App\Service\NotificationSenderInterface;


/**
 * @author Karol Gancarczyk
 */
class NotificationService {
	
	private UserRepository $userRepository;
	private NotificationSenderInterface $notificationSender;
	
    public function __construct(UserRepository $userRepository, NotificationSenderInterface $notificationSender) {
        $this->userRepository = $userRepository;
		$this->notificationSender = $notificationSender;
    }
	
	public function notifyAllSubscribers(AbstractExchangeRateChangedEvent $event) : void {
		$subscribers = $this->getAllSubscribers($event);
		foreach ($subscribers as $user) {
			$this->sendNotification($user, $event);
		}
	}
	
	public function getAllSubscribers(AbstractExchangeRateChangedEvent $event) : array {
		
		$currency = $event->getCurrency();		
		$subscribers = $this->userRepository->getUsersSubscribingCurrencyChanges($currency);
		
		$users = [];
		
		foreach ($subscribers as $user) {
			$notificationSetings = $user->getNotificationSettingsForCurrency($currency);

			if ($event instanceof ExchangeRateRisedEvent) {
				if ($currency->getExchangeRate() > $notificationSetings->getMaximumRateThreshold()) {
					$users[] = $user;
				}
			}

			if ($event instanceof ExchangeRateDroppedEvent) {
				if ($currency->getExchangeRate() < $notificationSetings->getMinimumRateThreshold()) {
					$users[] = $user;
				}
			}

		}
		
		return $users; 
	}
	

	public function sendNotification(User $user, AbstractExchangeRateChangedEvent $event) : void {
		$this->notificationSender->sendNotification($user, $event->getCurrency());
	}
	
}
