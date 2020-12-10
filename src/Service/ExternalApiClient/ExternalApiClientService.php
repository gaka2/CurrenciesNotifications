<?php

namespace App\Service\ExternalApiClient;

use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use App\DataTransferObject\CurrencyDto;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\Exception\NoSuchIndexException;


/**
 * @author Karol Gancarczyk
 */
class ExternalApiClientService {

    private ClientInterface $client;
    private LoggerInterface $logger;


    private const API_URL_FOR_CURRENT_RATES = 'https://api.nbp.pl/api/exchangerates/tables/A/?format=json';

    public function __construct(ClientInterface $client, LoggerInterface $logger) {
        $this->client = $client;
        $this->logger = $logger;
    }

    private function getDataFromExternalApi(string $url) : array {
        try {
            $request = $this->client->createRequest('GET', $url);
            $response = $this->client->sendRequest($request);

            $dataFromApi = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
            return $this->mapDataFromApi($dataFromApi);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $this->logger->error($e->getTraceAsString());

            throw new \RuntimeException($e->getMessage());
        }
    }

    public function getCurrentExchangeRates(): array {
        return $this->getDataFromExternalApi(self::API_URL_FOR_CURRENT_RATES);
    }


    private function mapDataFromApi(array $data): array {
        try {
            $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()->enableExceptionOnInvalidIndex()->getPropertyAccessor();

            $rates = [];

            foreach ($data as $row) {
                foreach($propertyAccessor->getValue($row, '[rates]') as $exchangeRateData) {
					$exchangeRate = new CurrencyDto($propertyAccessor->getValue($exchangeRateData, '[code]'), $propertyAccessor->getValue($exchangeRateData, '[mid]'));
                    $rates[] = $exchangeRate;
                }
            }

            return $rates;
        } catch (NoSuchIndexException $e) {
            throw new \InvalidArgumentException('Invalid data passed to ' . __FUNCTION__ . ': ' . var_export($data, true));
        }
    }
}
