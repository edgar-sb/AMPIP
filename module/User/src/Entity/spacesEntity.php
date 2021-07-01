<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a role.
 * @ORM\Entity(repositoryClass="\User\Repository\spaces")
 * @ORM\Table(name="space")
 */
class spacesEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="id_park")
     */
    protected $id_park;

    /**
     * @ORM\Column(name="espacio")
     */
    protected $espacio;

    /**
     * @ORM\Column(name="name")
     */
    protected $name;

    /**
     * @ORM\Column(name="lat")
     */
    protected $lat;

    /**
     * @ORM\Column(name="lng")
     */
    protected $lng;

    /**
     * @ORM\Column(name="filters")
     */
    protected $filters;

    /**
     * Returns role ID.
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Sets role ID.
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getid_park(){
        return $this->id_park;
    }
    public function setid_park($id_park){$this->id_park = $id_park;}
    public function getespacio(){
        return $this->espacio;
    }
    public function setespacio($espacio){
        $this->espacio = $espacio;
    }
    public function getlat(){return $this->lat;}
    public function setlat($lat){$this->lat =$lat;}
    public function getlng(){return $this->lng;}
    public function setlng($lng){$this->lng = $lng;}
    public function getfilters(){return $this->filters;}
    public function setfilters($filter){$this->filters = $filter;}
}