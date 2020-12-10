<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Currency;


/**
 * @author Karol Gancarczyk
 */
interface NotificationSenderInterface {
	function sendNotification(User $user, Currency $currency) : void;
}