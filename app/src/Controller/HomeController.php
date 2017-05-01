<?php

namespace Acme\Skill\Controller;

use \InternetOfVoice\VSMS\Core\Controller\AbstractController;

/**
 * HomeController
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */
final class HomeController extends AbstractController
{
    /**
     * Home
     *
     * @param  \Slim\Http\Request   $request    Slim request
     * @param  \Slim\Http\Response  $response   Slim response
     * @return \Slim\Http\Response
     * @access public
     * @author a.schmidt@internet-of-voice.de
     */
    public function home($request, $response) {
        return $this->container->get('renderer')->render($response, 'home/home.twig', [
            'i18n'       => $this->i18n,
            'page_title' => 'Home',
            'hostname'   => $request->getUri()->getHost(),
        ]);
    }
}
