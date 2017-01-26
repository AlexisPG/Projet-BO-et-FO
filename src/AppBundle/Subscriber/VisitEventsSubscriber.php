<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 26/01/17
 * Time: 09:57
 */

namespace AppBundle\Subscriber;


use AppBundle\Event\VisitContactEvent;
use AppBundle\Event\VisitEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class VisitEventsSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return[
            VisitEvents::CONTACT => 'visitContact'
        ];
    }

    public function visitContact(VisitContactEvent $event)
    {
        // ILM s'affichera dans le debuggeur
        //dump('message provenemant de visit event subscriber');

        $ip = $event->getIp();
        $date = new \DateTime();

        // Par défaut, cela est stocker dans le dossier web
        /*file_put_contents('contactFormLogs.csv');*/

        // Pour le sotocker dans le dossier logs
        file_put_contents('../var/logs/contactFormLogs.csv',
            $ip . ';' . $date->format('d/m/Y H:i:s') . "\n",
            FILE_APPEND
        );
    }

}