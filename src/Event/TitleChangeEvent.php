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

namespace Lotgd\Bundle\LodgeTitleChangeBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class TitleChangeEvent extends Event
{
    public const TITLE_CHANGED = 'lodge_title_change.changed';

    private $fromName;
    private $newName;
    private $title;

    /**
     * Get the value of fromName
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * Set the value of fromName
     *
     * @return  self
     */
    public function setFromName(string $fromName): self
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Get the value of newName
     */
    public function getNewName(): string
    {
        return $this->newName;
    }

    /**
     * Set the value of newName
     *
     * @return  self
     */
    public function setNewName(string $newName): self
    {
        $this->newName = $newName;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
