<?php


namespace Cocorico\CoreBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="TaxRate")
 */
class TaxRate
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $province;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $province_full;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $GST;


    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $PST;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $HST;

    /**
     * TaxRate constructor.
     * @param $province
     * @param $province_full
     * @param $GST
     * @param $PST
     * @param $HST
     */
    public function __construct($province)
    {
        $this->province = $province;
        $this->province_full;
        $this->GST;
        $this->PST;
        $this->HST;
    }


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province): void
    {
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function getProvinceFull()
    {
        return $this->province_full;
    }

    /**
     * @param string $province_full
     */
    public function setProvinceFull($province_full): void
    {
        $this->province_full = $province_full;
    }

    /**
     * @return float
     */
    public function getGST()
    {
        return $this->GST;
    }

    /**
     * @param float $GST
     */
    public function setGST($GST): void
    {
        $this->GST = $GST;
    }

    /**
     * @return float
     */
    public function getPST()
    {
        return $this->PST;
    }

    /**
     * @param float $PST
     */
    public function setPST($PST): void
    {
        $this->PST = $PST;
    }

    /**
     * @return float
     */
    public function getHST()
    {
        return $this->HST;
    }

    /**
     * @param float $HST
     */
    public function setHST($HST): void
    {
        $this->HST = $HST;
    }




}