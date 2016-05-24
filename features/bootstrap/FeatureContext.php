<?php

    require 'vendor/autoload.php';

    use Carbon\Carbon;

    use Behat\Behat\Context\ClosuredContextInterface,
        Behat\Behat\Context\TranslatedContextInterface,
        Behat\Behat\Context\BehatContext,
        Behat\Behat\Exception\PendingException;
    use Behat\Gherkin\Node\PyStringNode,
        Behat\Gherkin\Node\TableNode;

    use Behat\MinkExtension\Context\MinkContext;

    use Behat\Behat\Context\Step\Given;
    use Behat\Behat\Context\Step\When;
    use Behat\Behat\Context\Step\Then;

    require_once 'vendor/autoload.php';

    //
    // Require 3rd-party libraries here:
    //
      // require_once 'PHPUnit/Autoload.php';
    //   require_once 'PHPUnit/Framework/Assert/Functions.php';
    //



    /**
     * Features context.
     */
    class FeatureContext extends BehatContext
    {

        private $session;

        /**
         * Initializes context.
         * Every scenario gets it's own context object.
         *
         * @param array $parameters context parameters (set them up through behat.yml)
         */
        public function __construct(array $parameters)
        {
            $driver = new \Behat\Mink\Driver\Selenium2Driver('chrome');
            $this->session = new \Behat\Mink\Session($driver);
            $this->session->start();
            $this->session->resizeWindow(1270, 700, 'current');
        }

    //
    // Place your definition and hook methods here:
    //


        /**
         * @Given /^I am signed in to Chrome with email "([^"]*)" and password "([^"]*)"$/
         */
        public function iAmSignedInToChromeWithEmailAndPassword($username, $pw)
        {        
            $this->session->visit('https://accounts.google.com/login#identifier');

            $form = $this->session->getPage()->findById('gaia_loginform');

            $form->findField('Email')->setValue($username);

            $form->findButton('signIn')->click();

            $this->session->wait(2000);


            // $form = $this->session->getPage()->findById('gaia_loginform');

            $form->findField('Passwd')->setValue($pw);

            $form->findById('signIn')->click();

            $this->session->wait(2000);
        }



        /**
         * @Given /^I am on "([^"]*)"$/
         */
        public function iAmOn($url)
        {
            $this->session->visit($url);
        }

        /**
         * @Then /^I wait for the page to load$/
         */
        public function iWaitForThePageToLoad()
        {
            $this->session->wait(5000);
        }


        /**
         * @Given /^I enter username "([^"]*)" and password "([^"]*)"$/
         */
        public function iEnterUsernameAndPassword($username, $pw)
        {
            $this->session->getPage()->findField('usr_name_home')->setValue($username);

            $this->session->getPage()->findField('usr_password_home')->setValue($pw);
        }

        /**
         * @When /^I click sign in$/
         */
        public function iClickSignIn()
        {
            $loginForm = $this->session->getPage()->find('css', 'form.chase-home-login');

            if (null === $loginForm) {
                throw new \Exception('The element is not found');
            }

            $loginForm->findLink('Sign in')->click();
        }

        /**
         * @Then /^I should be on "([^"]*)"$/
         */
        public function iShouldBeOn($trueUrl)
        {
            if ($this->session->getCurrentUrl() !== $trueUrl) {

                // $this->checkSecureAuth();
                throw new Exception('Actual url is: ' + $this->session->getCurrentUrl());
            }


        }

        //NextButton


        /**
        * @AfterScenario
        */
        // public function tearDown()
        // {
        //     $this->session->stop();
        // }

    }
