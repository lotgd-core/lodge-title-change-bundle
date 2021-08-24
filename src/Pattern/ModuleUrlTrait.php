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

namespace Lotgd\Bundle\LodgeTitleChangeBundle\Pattern;

use Lotgd\Bundle\LodgeTitleChangeBundle\Controller\LodgeTitleChangeController;

trait ModuleUrlTrait
{
    public function getModuleUrl(string $method, string $query = '')
    {
        return "runmodule.php?method={$method}&controller=".urlencode(LodgeTitleChangeController::class).$query;
    }
}
