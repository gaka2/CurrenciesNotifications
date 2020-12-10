<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\NotificationSettings;
use App\Repository\UserRepository;
use App\Repository\CurrencyRepository;
use App\DataTransferObject\UserDto;
use App\DataTransferObject\ExistingUserDto;
use App\Domain\PhoneNumber;
use App\Domain\EmailAddress;
use App\Domain\DateTimeFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Event\NewUserCreatedEvent;


/**
 * @author Karol Gancarczyk
 */
class UserService {
	
	private UserRepository $userRepository;
	private CurrencyRepository $currencyRepository;
	private EventDispatcherInterface $eventDispatcher;


	private const EIGHTEEN_YEARS = 18;
	private const MINIMUM_REQUIRED_NOTIFICATIONS_SETTINGS_AMOUNT = 1;
	
    public function __construct(UserRepository $userRepository, CurrencyRepository $currencyRepository, EventDispatcherInterface $eventDispatcher) {
        $this->userRepository = $userRepository;
		$this->currencyRepository = $currencyRepository;
		$this->eventDispatcher = $eventDispatcher;
    }
		

	public function createUser(UserDto $userDto) : User  {

		
		$user = new User();
		$user->setName($userDto->getName());
		$user->setSurname($userDto->getSurname());
		$user->setHashCode(sha1($userDto->getName() . $userDto->getSurname()));
		$user->setActive(false);
		$user->setPhoneNumber((string) (new PhoneNumber($userDto->getPhoneNumber())));
		$user->setEmail((string) (new EmailAddress($userDto->getEmail())));
		
		$birthDate = DateTimeFactory::createDate($userDto->getBirthDate());

		if ($birthDate->diff(new \DateTimeImmutable())->y < self::EIGHTEEN_YEARS) {
			throw new \InvalidArgumentException('User should be at least 18 years old');
		}
		
		$user->setBirthDate($birthDate);		
		
		if (count($userDto->getNotificationsSettings()) < self::MINIMUM_REQUIRED_NOTIFICATIONS_SETTINGS_AMOUNT) {
			throw new \InvalidArgumentException('User should subscribe notifications for at least one currency');
		}
		
		foreach ($userDto->getNotificationsSettings() as $notificationSettingsDto) {			
			
			$code = $notificationSettingsDto->getCurrencyCode();
			$currency = $this->currencyRepository->findOneByCode($code);
			if ($currency === null) {
				throw new \Exception("Currency with code {$code} not found");
			}
			
			$notificationsettings = new NotificationSettings();
			$notificationsettings->setCurrency($currency);
			$notificationsettings->setMinimumRateThreshold($notificationSettingsDto->getMinimumRateThreshold());
			$notificationsettings->setMaximumRateThreshold($notificationSettingsDto->getMaximumRateThreshold());
			$user->addNotificationsSettng($notificationsettings);
		}
		
		$this->userRepository->save($user);
		
		$this->notifyOnUserCreated($user);
		
		return $user;
	}
	
	private function notifyOnUserCreated(User $user) : void {
		$this->eventDispatcher->dispatch(new NewUserCreatedEvent($user));
	}
	

	public function activateUser(ExistingUserDto $existingUserDto) : User {
		
		$user = $this->getExistingUserFromDto($existingUserDto);
		
		if ($user->getActive() === true) {
			throw new \InvalidArgumentException('User is already activated');
		}
		
		$user->setActive(true);
		$this->userRepository->save($user);
		return $user;
	}
	
	public function unsubscribe(ExistingUserDto $existingUserDto) : void {
		$user = $this->getExistingUserFromDto($existingUserDto);
		$user->setActive(false);
		$this->userRepository->save($user);
	}
	

	private function getExistingUserFromDto(ExistingUserDto $existingUserDto) : User {

		$user = $this->userRepository->findOneByEmail($existingUserDto->getEmail());

		if ($user === null) {
			throw new \InvalidArgumentException('Wrong e-mail address');
		}
		
		if ($user->getHashCode() !== $existingUserDto->getHashCode()) {
			throw new \InvalidArgumentException('Wrong hashcode');
		}
		
		return $user;
	}

}