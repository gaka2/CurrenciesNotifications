<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\Currency;

/**
 * @author Karol Gancarczyk
 */
abstract class AbstractExchangeRateChangedEvent extends Event {

    private Currency $currency;

    public function __construct(Currency $currency) {
        $this->currency = $currency;
    }

    public function getCurrency(): Currency {
        return $this->currency;
    }
}
