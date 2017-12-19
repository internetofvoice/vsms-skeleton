<?php

namespace Acme\Skill\Controller;

use \InternetOfVoice\VSMS\Core\Controller\AbstractController;
use \Interop\Container\Exception\ContainerException;
use \Slim\Container;

/**
 * Class HomeController
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 * @license http://opensource.org/licenses/MIT
 */
class HomeController extends AbstractController {
    /**
     * Constructor
     *
     * @param   \Slim\Container     $container
     * @access	public
     * @throws  ContainerException
     * @author	a.schmidt@internet-of-voice.de
     */
    public function __construct(Container $container) {
        parent::__construct($container);

	    $this->translator->addTranslation($this->settings['translation_path'], 'home');
    }

    /**
     * Home
     *
     * @param   \Slim\Http\Request   $request    Slim request
     * @param   \Slim\Http\Response  $response   Slim response
     * @return  \Slim\Http\Response
     * @access  public
     * @throws  ContainerException
     * @author  a.schmidt@internet-of-voice.de
     */
    public function home($request, $response) {
        $this->logger->logRequest($request);

        return $this->container->get('renderer')->render($response, 'home/home.twig', [
	        'translator' => $this->translator,
	        'page_title' => $this->translator->t('page_title'),
	        'page_description' => $this->translator->t('page_description'),
	        'page_keywords' => $this->translator->t('page_keywords'),
        ]);
    }
}
