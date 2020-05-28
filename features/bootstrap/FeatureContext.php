<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Driver\KernelDriver;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var MinkContext
     */
    private $minkContext;

    /**
     * @BeforeScenario
     *
     * @throws UnsupportedDriverActionException
     */
    public function login(BeforeScenarioScope $scope)
    {
        $this->minkContext = $scope->getEnvironment()->getContext(MinkContext::class);
    }

    /**
     * @Then I should see a pagination
     */
    public function iShouldSeeAPagination()
    {
        $elem = $this->getElement('.pagination');
        if (null === $elem) {
            throw new \Exception('Pagination element not found');
        }
    }

    /**
     * @When I :method a valid request to :uri the following data:
     */
    public function iPostToTheFollowingData(string $method, string $uri, PyStringNode $stringNode)
    {
        $client = $this->getClient();
        $data = json_decode($stringNode->getRaw(), true);

        $client->request(
            $method,
            $uri,
            $data
        );
    }

    private function getClient(): KernelBrowser
    {
        /** @var KernelDriver $driver */
        $driver = $this->minkContext->getMink()->getSession()->getDriver();

        return $driver->getClient();
    }

    private function getElement(string $selector): ?NodeElement
    {
        $container = $this->minkContext->getSession()->getPage();

        return $container->find('css', $selector);
    }
}
