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

namespace Lotgd\Bundle\LodgeTitleChangeBundle;

use Lotgd\Bundle\Contract\LotgdBundleInterface;
use Lotgd\Bundle\Contract\LotgdBundleTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LotgdLodgeTitleChangeBundle extends Bundle implements LotgdBundleInterface
{
    use LotgdBundleTrait;

    public const TRANSLATION_DOMAIN = 'lodge_title_change';

    /**
     * {@inheritDoc}
     */
    public function getLotgdName(): string
    {
        return 'Lodge Title Change';
    }

    /**
     * {@inheritDoc}
     */
    public function getLotgdVersion(): string
    {
        return '0.1.2';
    }

    /**
     * {@inheritDoc}
     */
    public function getLotgdIcon(): ?string
    {
        return 'exchange alternate';
    }

    /**
     * {@inheritDoc}
     */
    public function getLotgdDescription(): string
    {
        return 'Use donator points to change Title in Lodge.';
    }

    /**
     * {@inheritDoc}
     */
    public function getLotgdDownload(): ?string
    {
        return 'https://github.com/lotgd-core/lodge-title-change-bundle';
    }
}
