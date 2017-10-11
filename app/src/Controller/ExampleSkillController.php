<?php

namespace Acme\Skill\Controller;

use Acme\Skill\Service\ExampleService;
use InternetOfVoice\VSMS\Core\Controller\AbstractSkillController;
use Slim\Container;

/**
 * Class ExampleSkillController
 *
 * @author	Alexander Schmidt <a.schmidt@internet-of-voice.de>
 * @license http://opensource.org/licenses/MIT
 */
class ExampleSkillController extends AbstractSkillController {
	/** @var string $skillHandle */
	protected $skillHandle = 'example';

	/** @var array $askApplicationIds */
    protected $askApplicationIds = [
        'dev'   => 'amzn1.ask.skill.b5ec8cfa-d9e5-40c9-8325-c56927a2e42b',
        'test'  => 'amzn1.ask.skill.b5ec8cfa-d9e5-40c9-8325-c56927a2e42b',
        'stage' => 'amzn1.ask.skill.b5ec8cfa-d9e5-40c9-8325-c56927a2e42b',
        'prod'  => 'amzn1.ask.skill.b5ec8cfa-d9e5-40c9-8325-c56927a2e42b',
    ];

	/** @var array $messages */
	protected $messages = [
        'default'       => "I'm afraid I did not understand you.",
        'welcome'       => "Welcome to Capitals Skill.",
        'stop'          => "Good bye.",
        'more'          => "Please ask another question or say stop.",
        'clue'          => "If you need help, please say help.",
        'help'          => "To find out the capital of a country, please ask: \"What is the capital of France?\"",
        'linkAccount'   => "Please link this skill to your user account in the companion app.",
        'noValue'       => "Sorry, I did not understand the country you mentioned.",
        'answerCapital' => "The capital of %s is %s.",
    ];

	/** @var array $pause */
	protected $pause = [
		'default' => '<break time="750ms" /> ',
		'short'   => '<break time="500ms" /> ',
	];

	/** @var array $cards */
    protected $cards = [
        'help' => [
            'title'     => "Help",
            'content'   => "To find out the capital of a country, please ask: \"What is the capital of France?\"",
        ]
    ];

    /** @var ExampleService $service */
    protected $service;


    /**
     * Constructor
     *
     * @param   \Slim\Container     $container
     * @access	public
     * @author	a.schmidt@internet-of-voice.de
     */
    public function __construct(Container $container) {
        parent::__construct($container);

	    // Use skill-specific logfile
	    $logfile = dirname($this->settings['logger']['file']) . '/' . $this->skillHandle . '.log';
	    $this->logger->handler(\Analog\Handler\Threshold::init (
		    \Analog\Handler\LevelName::init(
			    \Analog\Handler\File::init($logfile)
		    ),
		    $this->settings['logger']['threshold']
	    ));

	    // Initialize Service and inject SkillHelper
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
     * @see     routing configuration in app/config/routing.php
     */
    public function __invoke($request, $response, $args) {
	    try {
	    	// Create AlexaRequest
	        $this->createAlexaRequest($request);

	        // Add translation again, as AlexaRequest might come with a different locale
	        $this->translator->addTranslation($this->settings['translation_path'], 'example');

	        // Dispatch AlexaRequest to intent handlers
		    $reply = $this->dispatchAlexaRequest($response);
	    } catch(\Exception $e) {
		    return $response->withJson(['error' => 'Bad Request'], 400);
	    }

	    return $reply;
    }


    // --- Default Requests/Intents -------------------------------------------


    /**
	 * Launch request
	 *
	 * @access	protected
	 * @author	a.schmidt@internet-of-voice.de
	 */
	protected function launch() {
		$this->logger->debug('LaunchRequest');
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
		$this->logger->debug('HelpIntent');
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
		$this->logger->debug('StopIntent');
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
	    $this->logger->debug('CancelIntent -> StopIntent');
        $this->intentAMAZONStopIntent();
    }

    /**
     * AMAZON.StartOverIntent request
     *
     * @access	protected
     * @author	a.schmidt@internet-of-voice.de
     */
    protected function intentAMAZONStartOverIntent() {
	    $this->logger->debug('StartOverIntent -> LaunchRequest');
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
		$this->logger->debug('SessionEndedRequest');
		// No response
	}


	// --- Helper Functions --------------------------------------------------

	/**
	 * startAccountLinking
	 *
	 * @access  protected
	 * @author  a.schmidt@internet-of-voice.de
	 */
	protected function startAccountLinking() {
		$this->logger->debug('Start account linking');

		$this->alexaResponse
			->respond($this->translator->t($this->messages['linkAccount']))
			->withLinkAccount()
			->endSession(true)
		;
	}

	/**
	 * Continue or end session, depending on session 'new' flag; add a voice hint to message
	 *
	 * @return  string
	 * @access  protected
	 * @author  a.schmidt@internet-of-voice.de
	 */
	protected function continueOrEndSession() {
		$reply = '';

		if($this->alexaRequest->getSession()->isNew()) {
			$reply .= $this->pause['default'] . $this->translator->t($this->messages['stop']);
			$this->alexaResponse->endSession(true);
		} else {
			$reply .= $this->pause['default'] . $this->translator->t($this->messages['more']);
		}

		return $reply;
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

        // Check slots (parameters) sent along with the Intent
        // We don't need the full Slot objects and use a [key => val] representation provided by getSlotsAsArray()
        $slots = $this->alexaRequest->getIntent()->getSlotsAsArray();
        if(!isset($slots['country'])) {
	        $this->logger->info('CapitalIntent failed with slots: ' . json_encode($slots));
	        $this->alexaResponse
                ->respond($this->translator->t($this->messages['noValue']))
                ->reprompt($this->translator->t($this->messages['clue']))
            ;

            return false;
        }

        // Check if account is linked already, otherwise start account linking
        // (for educational purposes, as our example service does not query any user-specific data)
		$token = $this->alexaRequest->getUser()->getAccessToken();
		if($token === null) {
			$this->startAccountLinking();
			return false;
		}

        // Call service to obtain data
        $country = $slots['country'];
        $service = new ExampleService();
        $capital = $service->getCapital($this->translator->getLanguage(), $country);
        if($capital === false) {
	        $this->logger->debug('CapitalIntent: no result for slots: ' . json_encode($slots));
            $this->alexaResponse
                ->respond($this->translator->t($this->messages['noValue']))
                ->reprompt($this->translator->t($this->messages['clue']))
            ;

            return false;
        } else {
        	$message  = $this->translator->t($this->messages['answerCapital'], $country, $capital);
	        $message .= $this->continueOrEndSession();

	        $this->logger->debug('Response: ' . $message);
            $this->alexaResponse
	            ->respondSSML('<speak>' . $message . '</speak>')
            ;

            return true;
        }
    }
}
