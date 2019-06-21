<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\CoreBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListingFile
 *
 * @ORM\MappedSuperclass
 */
abstract class BaseListingFile
{

    const IMAGE_DEFAULT = "default-listing.png";
    const FILE_FOLDER = "/images/pdf-40.png";

    /**
     * @Assert\NotBlank(message="assert.not_blank")
     *
     * @ORM\Column(type="string", length=255, name="name", nullable=false)
     *
     * @var string $name
     */
    protected $name;

    /**
     * @var int
     *
     * @Assert\NotBlank(message="assert.not_blank")
     *
     * @ORM\Column(name="position", type="smallint", nullable=false)
     */
    protected $position;

    /**
     * Sets name.
     *
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set position
     *
     * @param  boolean $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return boolean
     */
    public function getPosition()
    {
        return $this->position;
    }

    public function getWebPath()
    {
        return null === $this->name ? null : self::FILE_FOLDER;
    }

}
