<?php

namespace App\Service;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use App\DataTransferObject\CurrencyDto;
use App\Service\ExternalApiClient\ExternalApiClientService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Event\ExchangeRateRisedEvent;
use App\Event\ExchangeRateDroppedEvent;


/**
 * @author Karol Gancarczyk
 */
class CurrencyService {
	
	
	private CurrencyRepository $currencyRepository;
	private EventDispatcherInterface $eventDispatcher;
	private ExternalApiClientService $apiClient;
    
    public function __construct(CurrencyRepository $currencyRepository, EventDispatcherInterface $eventDispatcher, ExternalApiClientService $apiClient) {
        $this->currencyRepository = $currencyRepository;
		$this->eventDispatcher = $eventDispatcher;
		$this->apiClient = $apiClient;
    }

	private function updateExchangeRate(Currency $currency, float $exchangeRate): Currency {

		$previousRate = $currency->getExchangeRate();
		$currency->setExchangeRate((string) $exchangeRate); 
		$currency->setUpdatedAt(new \DateTimeImmutable()); 

		$this->currencyRepository->save($currency); 

		$this->notifyOnRateChanged($currency, (float) $previousRate);
		
		return $currency; 
	}
	

	private function notifyOnRateChanged(Currency $currency, float $previousRate) : void {
		
		$currentRate = $currency->getExchangeRate();
		
		if ($currentRate > $previousRate) {
			$this->eventDispatcher->dispatch(new ExchangeRateRisedEvent($currency));
		}
		
		if ($currentRate < $previousRate) {
			$this->eventDispatcher->dispatch(new ExchangeRateDroppedEvent($currency));
		}

	}
	

	public function createCurrency(CurrencyDto $currencyDto) : Currency {
		
		$currency = new Currency();
		$currency->setCode($currencyDto->getCode());
		$currency->setExchangeRate((string) $currencyDto->getRate());
		$currency->setUpdatedAt(new \DateTimeImmutable());		
		
		$this->currencyRepository->save($currency);
		return $currency;
	}
	

	public function updateCurrency(CurrencyDto $currencyDto) : Currency {
		$currency = $this->currencyRepository->findOneByCode($currencyDto->getCode());

		if ($currency === null) {
			return $this->createCurrency($currencyDto);
		}

		return $this->updateExchangeRate($currency, $currencyDto->getRate());
	}
	
	public function updateAllCurrencies() : void {
		foreach ($this->apiClient->getCurrentExchangeRates() as $currencyDto) {
			$this->updateCurrency($currencyDto);
		}
	}

}