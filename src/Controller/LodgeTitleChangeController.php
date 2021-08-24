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

namespace Lotgd\Bundle\LodgeTitleChangeBundle\Controller;

use Lotgd\Bundle\LodgeTitleChangeBundle\Event\TitleChangeEvent;
use Lotgd\Bundle\LodgeTitleChangeBundle\Form\TitleChangeType;
use Lotgd\Bundle\LodgeTitleChangeBundle\LotgdLodgeTitleChangeBundle;
use Lotgd\Bundle\LodgeTitleChangeBundle\Pattern\ModuleUrlTrait;
use Lotgd\Core\Http\Request;
use Lotgd\Core\Http\Response as HttpResponse;
use Lotgd\Core\Log;
use Lotgd\Core\Navigation\Navigation;
use Lotgd\Core\Tool\Sanitize;
use Lotgd\Core\Tool\Tool;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class LodgeTitleChangeController extends AbstractController
{
    use ModuleUrlTrait;

    public const TRANSLATION_DOMAIN = LotgdLodgeTitleChangeBundle::TRANSLATION_DOMAIN;

    private $tool;
    private $response;
    private $navigation;
    private $translator;
    private $sanitize;
    private $parameter;
    private $dispatcher;
    private $log;

    public function __construct(
        Tool $tool,
        HttpResponse $response,
        Navigation $navigation,
        TranslatorInterface $translator,
        Sanitize $sanitize,
        ParameterBagInterface $parameter,
        EventDispatcherInterface $dispatcher,
        Log $log
    ) {
        $this->tool       = $tool;
        $this->response   = $response;
        $this->navigation = $navigation;
        $this->translator = $translator;
        $this->sanitize   = $sanitize;
        $this->parameter  = $parameter;
        $this->dispatcher = $dispatcher;
        $this->log        = $log;
    }

    public function enter(Request $request): Response
    {
        global $session;

        $otitle = $this->tool->getPlayerTitle();
        $otitle = '`0' == $otitle ? '' : $otitle;

        $form = $this->createForm(TitleChangeType::class, ['new_title' => $otitle], [
            'action' => $this->getModuleUrl('enter'),
        ]);

        $times = (int) get_module_pref('times_purchased', 'lodge_title_change');
        $cost  = $this->parameter->get('lotgd_bundle.lodge_title_change.cost.first');

        if ($times)
        {
            $cost = $this->parameter->get('lotgd_bundle.lodge_title_change.cost.other');
        }

        $params['cost']             = $cost;
        $params['is_preview']       = false;
        $params['is_title_changed'] = false;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data   = $form->getData();
            $ntitle = $data['new_title'];

            if ($form->get('button_preview')->isClicked())
            {
                $params['is_preview'] = true;

                $params['nname']  = $this->tool->getPlayerBasename();
                $params['ntitle'] = $ntitle;
            }
            elseif ($form->get('button_change')->isClicked())
            {
                $fromname = $session['user']['name'];
                $newname  = $this->tool->changePlayerCtitle($ntitle);

                $event = new TitleChangeEvent();
                $event->setTitle($ntitle)
                    ->setFromName($fromname)
                    ->setNewName($newname)
                ;

                $this->dispatcher->dispatch($event, TitleChangeEvent::TITLE_CHANGED);

                $ntitle  = $event->getTitle();
                $newname = $this->tool->changePlayerCtitle($ntitle);

                $session['user']['ctitle'] = $ntitle;
                $session['user']['name']   = $newname;

                $this->tool->addNews('news.changed', [
                    'from' => $fromname,
                    'new'  => $session['user']['name'],
                ], self::TRANSLATION_DOMAIN);

                $many = $times ? 'another' : 'first';
                $this->log->debug("bought {$many} custom title for {$cost} points");

                $session['user']['donationspent'] += $cost;

                set_module_pref('times_purchased', $times + 1, 'lodge_title_change');

                $params['is_title_changed'] = true;
                $otitle                     = $ntitle;
            }
        }

        $params['otitle'] = $otitle;
        $params['form']   = $form->createView();

        return $this->render('@LotgdLodgeTitleChange/enter.html.twig', $params);
    }

    protected function render(string $view, array $params = [], ?Response $response = null): Response
    {
        $this->response->pageTitle('title', [], self::TRANSLATION_DOMAIN);

        $this->navigation->addNav('navigation.nav.return', 'lodge.php', ['textDomain' => self::TRANSLATION_DOMAIN]);

        $params['translation_domain'] = self::TRANSLATION_DOMAIN;

        return parent::render($view, $params, $response);
    }
}
