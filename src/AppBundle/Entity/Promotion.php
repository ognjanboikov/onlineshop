<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="promotions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromotionRepository")
 */
class Promotion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="isActive", type="smallint", nullable=true)
     */
    private $isActive;

    /**
     * @var string
     *
     * @ORM\Column(name="percent", type="integer", nullable=true)
     */
    private $percent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="activeFrom", type="datetime")
     */
    private $activeFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="activeTo", type="datetime")
     */
    private $activeTo;

    /**
     * @var int
     *
     * @ORM\Column(name="madeFor", type="integer", nullable=true)
     */
    private $madeFor;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Promotion
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set isActive
     *
     * @param integer $isActive
     *
     * @return Promotion
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return int
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set percent
     *
     * @param string $percent
     *
     * @return Promotion
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * @return string
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * Set activeFrom
     *
     * @param \DateTime $activeFrom
     *
     * @return Promotion
     */
    public function setActiveFrom($activeFrom)
    {
        $this->activeFrom = $activeFrom;

        return $this;
    }

    /**
     * Get activeFrom
     *
     * @return \DateTime
     */
    public function getActiveFrom()
    {
        return $this->activeFrom;
    }

    /**
     * Set activeTo
     *
     * @param \DateTime $activeTo
     *
     * @return Promotion
     */
    public function setActiveTo($activeTo)
    {
        $this->activeTo = $activeTo;

        return $this;
    }

    /**
     * Get activeTo
     *
     * @return \DateTime
     */
    public function getActiveTo()
    {
        return $this->activeTo;
    }

    /**
     * Set madeFor
     *
     * @param integer $madeFor
     *
     * @return Promotion
     */
    public function setMadeFor($madeFor)
    {
        $this->madeFor = $madeFor;

        return $this;
    }

    /**
     * Get madeFor
     *
     * @return int
     */
    public function getMadeFor()
    {
        return $this->madeFor;
    }
}

