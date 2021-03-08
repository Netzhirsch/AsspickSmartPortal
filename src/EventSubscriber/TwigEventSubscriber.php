<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private Environment $twig;

    public function __construct(Environment $twig) {
        $this->twig = $twig;
    }

    public function onKernelController() {

        $this->twig->addGlobal(
            'damageCaseRoutes',[
                'damageCase_liability_index',
                'damageCase_car_index',
                'damageCase_generalDamage_index',
            ]
        );

        $this->twig->addGlobal(
            'userRoutes',[
                'user_index',
                'fibo_index',
            ]
        );

        $this->twig->addGlobal(
            'downloadCenterRoutes',[
                'download_center_folder_index',
                'download_center_folder_new',
                'download_center_folder_edit',
                'download_center_user_view',
            ]
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }

}
