<?php

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Mink\Session;
use Behat\Step\Then;
use Behat\Step\When;
use Symfony\Component\Routing\RouterInterface;

class BaselinkerContext implements Context
{
    /** @var Session */
    private $session;

    /** @var RouterInterface */
    private $router;

    private string $logDir;

    public function __construct(Session $session, RouterInterface $router, string $logDir)
    {
        $this->session = $session;
        $this->router = $router;
        $this->logDir = $logDir;
    }

    #[When('I visit the Baselinker marketplace getOrder initialization page for :marketplace')]
    public function iVisitTheBaselinkerMarketplaceGetOrderInitializationPageFor(string $marketplace): void
    {
        $url = $this->router->generate('fetch_orders', ['marketplace' => $marketplace]);
        $this->session->visit($url);
    }

    #[Then('I should see a success message for :marketplace')]
    public function iShouldSeeASuccessMessageFor(string $marketplace): void
    {
        $page = $this->session->getPage();
        $pageText = $page->getContent();
        $message = 'Orders fetching initiated';
        if (!str_contains($pageText, $message)) {
            throw new \Exception(sprintf('Expected message "%s" not found in page text.', $message));
        }
        if (!str_contains($pageText, $marketplace)) {
            throw new \Exception(sprintf('Expected marketplace "%s" not found in page text.', $marketplace));
        }
    }

    #[Then('The logs should contain the order list')]
    public function theLogsShouldContainTheOrderList(): void
    {
        $logFile = sprintf('%s/baselinker_test.log', $this->logDir);
        if (!file_exists($logFile)) {
            throw new \Exception('Log file does not exist: '.$logFile);
        }

        $logContent = file_get_contents($logFile);
        if (empty($logContent)) {
            throw new \Exception('Log file is empty: '.$logFile);
        }

        if (!str_contains($logContent, 'order_id')) {
            throw new \Exception('Log file does not contain order information.');
        }
    }
}
