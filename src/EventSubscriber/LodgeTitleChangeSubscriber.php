<?php

/**
 * This file is part of "LoTGD Bundle Clan News".
 *
 * @see https://github.com/lotgd-core/clan-news-bundle
 *
 * @license https://github.com/lotgd-core/clan-news-bundle/blob/master/LICENSE.txt
 * @author IDMarinas
 *
 * @since 0.1.0
 */

namespace Lotgd\Bundle\LodgeTitleChangeBundle\EventSubscriber;

use Lotgd\Core\Events;
use Lotgd\Core\Navigation\Navigation;
use Lotgd\Bundle\LodgeTitleChangeBundle\LotgdLodgeTitleChangeBundle;
use Lotgd\Bundle\LodgeTitleChangeBundle\Pattern\ModuleUrlTrait;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class LodgeTitleChangeSubscriber implements EventSubscriberInterface
{
    use ModuleUrlTrait;

    public const TRANSLATION_DOMAIN = LotgdLodgeTitleChangeBundle::TRANSLATION_DOMAIN;

    private $navigation;
    private $parameter;

    public function __construct(ParameterBagInterface $parameter, Navigation $navigation)
    {
        $this->navigation = $navigation;
        $this->parameter  = $parameter;
    }

    public function lodgeDescriptionPoints(GenericEvent $event): void
    {
        $args = $event->getArguments();

        $args[] = ['points.description', [
            'initial' => $this->parameter->get('lotgd_bundle.lodge_title_change.cost.first'),
            'extra'   => $this->parameter->get('lotgd_bundle.lodge_title_change.cost.other'),
        ], self::TRANSLATION_DOMAIN];

        $event->setArguments($args);
    }

    public function lodge(): void
    {
        global $session;

        $times = (int) get_module_pref('times_purchased', 'lodge_title_change');
        $cost  = $this->parameter->get('lotgd_bundle.lodge_title_change.cost.first');

        if ($times)
        {
            $cost = $this->parameter->get('lotgd_bundle.lodge_title_change.cost.other');
        }

        //-- If they have less than what they need just ignore them
        if (($times * $cost) > $session['user']['donation'])
        {
            return;
        }

        $this->navigation->addNav('navigation.nav.change', $this->getModuleUrl('enter'), [
            'textDomain' => self::TRANSLATION_DOMAIN,
            'params'     => ['cost' => $cost],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Events::PAGE_LODGE => 'lodge',
            'pointsdesc'       => 'lodgeDescriptionPoints',
        ];
    }
}
