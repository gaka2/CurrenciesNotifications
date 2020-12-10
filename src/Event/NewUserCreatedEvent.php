<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\User;

/**
 * @author Karol Gancarczyk
 */
class NewUserCreatedEvent extends Event {

    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function getUser(): User {
        return $this->user;
    }
}