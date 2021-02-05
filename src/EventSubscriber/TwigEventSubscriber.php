<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;

    public function __construct(Environment $twig) {
        $this->twig = $twig;
    }

    public function onKernelController() {

        $damageCases = [
            'damageCase_liability_index'
        ];
        $this->twig->addGlobal(
            'damageCaseRoutes',$damageCases
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }

}
