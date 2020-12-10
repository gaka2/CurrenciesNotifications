<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Currency;

use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * @author Karol Gancarczyk
 */
class EmailSenderService implements NotificationSenderInterface {
	
	
	private const SENDER_EMAIL_ADDRESS = 'notifications@company_name.pl';

	private MailerInterface $mailer;
	
	public function __construct(MailerInterface $mailer) {
		$this->mailer = $mailer;
	}
	
	public function sendUserRegistered(User $user) : void {

		$email = (new TemplatedEmail())
			->from(new Address(self::SENDER_EMAIL_ADDRESS))
			->to(new Address($user->getEmail()))
			->subject('Rejestracja w systemie')
			->htmlTemplate('emails/signup.html.twig')
			->context([
				'user' => $user,
			])
		;		
	
		$this->mailer->send($email);
	}
	
	public function sendNotification(User $user, Currency $currency) : void {

		$email = (new TemplatedEmail())
			->from(new Address(self::SENDER_EMAIL_ADDRESS))
			->to(new Address($user->getEmail()))
			->subject('Zmiana kursu waluty')
			->htmlTemplate('emails/notification.html.twig')
			->context([
				'user' => $user,
				'currency' =>  $currency,
			])
		;

		$this->mailer->send($email);
	}
}