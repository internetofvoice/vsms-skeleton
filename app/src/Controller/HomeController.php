<?php

namespace Acme\VSMS\Controller;

use \InternetOfVoice\VSMS\Core\Controller\AbstractController;

/**
 * HomeController
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */
final class HomeController extends AbstractController
{
    /**
     * Home method
     *
     * @param  \Slim\Http\Request   $request    Slim request
     * @param  \Slim\Http\Response  $response   Slim response
     * @param  array                $args       Arguments
     * @return \Slim\Http\Response
     * @access public
     * @author a.schmidt@internet-of-voice.de
     */
    public function home($request, $response, $args)
    {
        return $this->container->get('renderer')->render($response, 'home/home.twig', [
            'language'   => $this->language,
            'page_title' => 'Home',
            'hostname'   => $request->getUri()->getHost(),
        ]);
    }
}
