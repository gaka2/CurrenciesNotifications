<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\CurrencyService;

/**
 * @author Karol Gancarczyk
 */
class UpdateExchangeRatesCommand extends Command {

    private CurrencyService $currencyService;
    
    protected static $defaultName = 'app:update-exchange-rates';

    public function __construct(CurrencyService $currencyService) {
        $this->currencyService = $currencyService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $this->currencyService->updateAllCurrencies();
        return 0;
    }
}