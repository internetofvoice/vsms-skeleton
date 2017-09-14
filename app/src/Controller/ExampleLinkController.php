<?php

namespace Acme\Skill\Controller;

use InternetOfVoice\VSMS\Core\Controller\AbstractLinkController;
use Slim\Container;

/**
 * ExampleLinkController
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */
final class ExampleLinkController extends AbstractLinkController
{
    /**
     * Constructor
     *
     * @param   \Slim\Container     $container
     * @access	public
     * @author	a.schmidt@internet-of-voice.de
     */
    public function __construct(Container $container) {
        parent::__construct($container);

        $this->translator->addTranslation($this->settings['translation_path'], 'example');
    }

    /**
     * Invocation
     *
     * Handles account linking process
     *
     * @param 	\Slim\Http\Request      $request 	Slim request
     * @param 	\Slim\Http\Response		$response 	Slim response
     * @return  \Slim\Http\Response
     * @access	public
     * @author	a.schmidt@internet-of-voice.de
     */
    public function __invoke($request, $response) {
        $this->logger->logRequest($request);

	    // Get request parameters
        try {
            $parameters = $this->validateRequestParameters($request, 'example');
        } catch (\Exception $e) {
            $notFoundHandler = $this->container->get('notFoundHandler');
            return $notFoundHandler($request, $response);
        }

        $username = '';
        $password = '';
        $errors   = array();

        // Form handling
        if($request->isPost()) {
            $username = $request->getParam('username', '');
            $password = $request->getParam('password', '');

            // Credentials given?
            if(empty($username) or empty($password)) {
                $errors['credentials'] = true;
            } else {
                // Check credentials - just for educational purposes
                $result = ($username = "test" && $password == "test");

                // Redirect to Amazon when succeeded, else set form error
                if($result === false) {
                    $errors['credentials'] = true;
                } else {
                    $token    = bin2hex(openssl_random_pseudo_bytes(16));
                    $location = $this->getRedirectLocation($parameters, $token);
                    return $response->withStatus(303)->withHeader('Location', $location);
                }
            }
        }

        return $this->container->get('renderer')->render($response, 'example/link-account.twig', [
            'translator' => $this->translator,
            'page_title' => $this->translator->t('Login'),
            'skill_name' => $this->translator->t('Capitals Skill'),
            'uri'        => $request->getUri()->getPath(),
            'username'   => $username,
            'password'   => $password,
            'errors'     => $errors,
            'hidden'     => $parameters
        ]);
    }

    /**
     * Privacy
     *
     * Show privacy policy
     *
     * @param 	\Slim\Http\Request      $request 	Slim request
     * @param 	\Slim\Http\Response		$response 	Slim response
     * @return  \Slim\Http\Response
     * @access	public
     * @author	a.schmidt@internet-of-voice.de
     */
    public function privacy($request, $response) {
        $this->logger->logRequest($request);

        return $this->container->get('renderer')->render($response, 'example/privacy.twig', [
            'translator' => $this->translator,
            'page_title' => $this->translator->t('Privacy policy'),
            'skill_name' => $this->translator->t('Capitals Skill'),
        ]);
    }
}
