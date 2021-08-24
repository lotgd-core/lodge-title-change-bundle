<?php

/**
 * This file is part of "LoTGD Bundle Lodge Title Change".
 *
 * @see https://github.com/lotgd-core/lodge-title-change-bundle
 *
 * @license https://github.com/lotgd-core/lodge-title-change-bundle/blob/master/LICENSE.txt
 * @author IDMarinas
 *
 * @since 0.1.0
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lotgd\Bundle\LodgeTitleChangeBundle\Controller\LodgeTitleChangeController;
use Lotgd\Bundle\LodgeTitleChangeBundle\EventSubscriber\LodgeTitleChangeSubscriber;
use Lotgd\Bundle\LodgeTitleChangeBundle\Form\TitleChangeType;
use Lotgd\Core\Http\Response;
use Lotgd\Core\Log;
use Lotgd\Core\Navigation\Navigation;
use Lotgd\Core\Tool\Sanitize;
use Lotgd\Core\Tool\Tool;

return static function (ContainerConfigurator $container)
{
    $container->services()
        //-- Controllers
        ->set(LodgeTitleChangeController::class)
            ->lazy()
            ->args([
                new ReferenceConfigurator(Tool::class),
                new ReferenceConfigurator(Response::class),
                new ReferenceConfigurator(Navigation::class),
                new ReferenceConfigurator('translator'),
                new ReferenceConfigurator(Sanitize::class),
                new ReferenceConfigurator('parameter_bag'),
                new ReferenceConfigurator('event_dispatcher'),
                new ReferenceConfigurator(Log::class)
            ])
            ->call('setContainer', [
                new ReferenceConfigurator('service_container')
            ])
            ->tag('controller.service_arguments')

        //-- Event Subscribers
        ->set(LodgeTitleChangeSubscriber::class)
            ->args([
                new ReferenceConfigurator('parameter_bag'),
                new ReferenceConfigurator(Navigation::class)
                ])
            ->tag('kernel.event_subscriber')

        //-- Forms
        ->set(TitleChangeType::class)
            ->lazy()
            ->args([
                new ReferenceConfigurator('parameter_bag'),
            ])
            ->tag('form.type')
    ;
};
