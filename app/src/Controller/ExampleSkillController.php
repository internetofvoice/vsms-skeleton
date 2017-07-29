<?php

namespace Acme\Skill\Controller;

use Acme\Skill\Service\ExampleService;
use InternetOfVoice\VSMS\Core\Controller\AbstractSkillController;
use Slim\Container;

/**
 * ExampleSkillController
 *
 * @author	Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */
final class ExampleSkillController extends AbstractSkillController
{
    protected $skillHandle = 'example';
    protected $askApplicationId = [
        'dev'   => 'amzn1.ask.skill.b5ec8cfa-d9e5-40c9-8325-c56927a2e42b',
        'test'  => 'amzn1.ask.skill.b5ec8cfa-d9e5-40c9-8325-c56927a2e42b',
        'stage' => 'amzn1.ask.skill.b5ec8cfa-d9e5-40c9-8325-c56927a2e42b',
        'prod'  => 'amzn1.ask.skill.b5ec8cfa-d9e5-40c9-8325-c56927a2e42b',
    ];

	protected $messages = [
        'default'       => "I'm afraid I did not understand you.",
        'welcome'       => "Welcome to Capitals Skill.",
        'stop'          => "Good bye.",
        'clue'          => "If you need help, please say help.",
        'help'          => "To find out the capital of a country, please ask: \"What is the capital of France?\"",
        'linkAccount'   => "Please link this skill to your user account in the companion app.",
        'noValue'       => "Sorry, I did not understand the country you mentioned.",
        'answerCapital' => "The capital of %s is %s.",
    ];

    protected $cards = [
        'help' => [
            'title'     => "Help",
            'content'   => "To find out the capital of a country, please ask: \"What is the capital of France?\"",
        ]
    ];

    /** @var ExampleService $service */
    protected $service;


    // --- Skill Bootstrap ----------------------------------------------------


    /**
     * Constructor
     *
     * @param   \Slim\Container     $container
     * @access	public
     * @author	a.schmidt@internet-of-voice.de
     */
    public function __construct(Container $container) {
        parent::__construct($container);

        $this->service = new ExampleService();
        $this->service->setSkillHelper($this->skillHelper);
    }

    /**
     * Invocation
     *
     * @param   \Slim\Http\Request      $request    Slim request
     * @param   \Slim\Http\Response     $response   Slim response
     * @param   array                   $args       Arguments
     * @return  \Slim\Http\Response
     * @access  public
     * @author  a.schmidt@internet-of-voice.de
     * @see     routing configuration
     */
    public function __invoke($request, $response, $args) {
        $this->createAlexaRequest($request);
        $this->translator->addTranslation($this->settings['translation_path'], 'example');

        return $this->dispatchAlexaRequest($response);
    }


    // --- Default Requests/Intents -------------------------------------------


    /**
	 * Launch request
	 *
	 * @access	protected
	 * @author	a.schmidt@internet-of-voice.de
	 */
	protected function launch() {
		$this->alexaResponse
			->respond($this->translator->t($this->messages['welcome']))
			->reprompt($this->translator->t($this->messages['clue']))
		;
	}

	/**
	 * AMAZON.HelpIntent request
	 *
	 * @access	protected
	 * @author	a.schmidt@internet-of-voice.de
	 */
	protected function intentAMAZONHelpIntent() {
		$this->alexaResponse
			->respond($this->translator->t($this->messages['help']))
			->withCard(
			    $this->translator->t($this->cards['help']['title']),
                $this->translator->t($this->cards['help']['content'])
            )
		;
	}

	/**
	 * AMAZON.StopIntent request
	 *
	 * @access	protected
	 * @author	a.schmidt@internet-of-voice.de
	 */
	protected function intentAMAZONStopIntent() {
		$this->alexaResponse
			->respond($this->translator->t($this->messages['stop']))
			->endSession(true)
		;
	}

    /**
     * AMAZON.CancelIntent request
     *
     * @access	protected
     * @author	a.schmidt@internet-of-voice.de
     */
    protected function intentAMAZONCancelIntent() {
        $this->intentAMAZONStopIntent();
    }

    /**
     * AMAZON.StartOverIntent request
     *
     * @access	protected
     * @author	a.schmidt@internet-of-voice.de
     */
    protected function intentAMAZONStartOverIntent() {
        $this->launch();
    }

	/**
	 * Session-ended request
	 *
	 * Does not include a response. Purpose: garbage collection, releasing resources etc.
	 *
	 * @access	protected
	 * @author	a.schmidt@internet-of-voice.de
	 */
	protected function sessionEnded() {
		// no response required
	}


    // --- Particular Intents -------------------------------------------------


    /**
     * CapitalIntent request
     *
     * @return  bool
     * @access	protected
     * @author	a.schmidt@internet-of-voice.de
     */
    protected function intentCapitalIntent() {
        // Log request
        $this->logger->logRequest($this->container->get('request'));

        // Check slots (parameters) sent along with the intent
        $slots = $this->alexaRequest->slots;
        if(!isset($slots['country'])) {
            $this->alexaResponse
                ->respond($this->translator->t($this->messages['noValue']))
                ->reprompt($this->translator->t($this->messages['clue']))
            ;

            return false;
        }

        // Check if account is linked already, otherwise start account linking
        // (for educational purposes, as our example service does not query any user-specific data)
		$token = $this->alexaRequest->session->user->accessToken;
		if($token === null) {
			$this->alexaResponse
				->respond($this->translator->t($this->messages['linkAccount']))
				->withLinkAccount()
				->endSession(true)
			;

			return false;
		}

        // Call service to obtain data
        $country = $slots['country'];
        $service = new ExampleService();
        $capital = $service->getCapital($this->translator->getLanguage(), $country);
        if($capital === false) {
            $this->alexaResponse
                ->respond($this->translator->t($this->messages['noValue']))
                ->reprompt($this->translator->t($this->messages['clue']))
            ;

            return false;
        } else {
            $this->alexaResponse
                ->respond($this->translator->t($this->messages['answerCapital'], $country, $capital))
            ;

            return true;
        }
    }
}
