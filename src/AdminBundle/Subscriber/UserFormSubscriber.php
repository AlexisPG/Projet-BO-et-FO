<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 20/01/17
 * Time: 09:37
 */

namespace AdminBundle\Subscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            // Evenement              et le gestionnaire d'évenement
            FormEvents::POST_SET_DATA => 'postSetData'
        ];
    }
    public function postSetData(FormEvent $event)
    {
        $entity = $event->getData();
        $form = $event->getForm();

        // Pour voir si on est en mode création ou modification
        if($entity->getId())
        {
            $form->remove('birthday');
            $form->remove('password');

        }
    }



}