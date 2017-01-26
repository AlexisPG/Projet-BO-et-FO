<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 23/01/17
 * Time: 12:07
 */

namespace AdminBundle\Subscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelEventsSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $session;

    public function __construct(\Twig_Environment $twig, Session $session)
    {
        $this->twig = $twig;
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::REQUEST => "kernelRequest",
            KernelEvents::REQUEST => "blockCountry",
            KernelEvents::RESPONSE => 'addCookieBlock'
        ];
    }
    public function addCookieBlock(FilterResponseEvent $event)
    {
        $content = $event->getResponse()->getContent();

        if(!$this->session->has('disclaimer'))
        {
            $content = str_replace('<body>', '
            <body>
                <div class="Cookies col-lg-12">
                Ce site utilise des cookies.
                    <a href="#" class="btn btn-primary">J\'ai compris</a>
                </div>', $content);
        }

        $responce = new Response($content);
        $event->setResponse($responce);
    }

    public function blockCountry(GetResponseEvent $event)
    {
        // Récupération de l'ip et de géolocalisation
        /*        $ip = $event->getResponse()->getClientIp();*/
        $ip = '89.227.222.139';
        $ipService = file_get_contents("http://www.webservicex.net/geoipservice.asmx/GetGeoIP?IPAddress=$ip");
        $xml = simplexml_load_string($ipService);

        if($xml->CountryName != 'France')
        {
            $view = $this->twig->render('Public/Maintenance/index.html.twig');
            $responce = new Response($view, 503);
            $event->setResponse($responce);
        }

        //$event->setResponse($responce);

    }
    public function kernelRequest(GetResponseEvent $event)
    {
        /*  die(dump('kernel request'));*/
        $request = $event->getRequest();
        $content = $event->getResponse();

        $view = $this->twig->render('Public/Maintenance/index.html.twig');

        // Les evenemnt doivent retourner une réponse'
        $responce = new Response($view, 503);
        $event->setResponse($responce);
        /*
                die(dump($request));*/
    }
}