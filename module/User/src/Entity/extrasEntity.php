<?php

 
namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered prueba.
 * @ORM\Entity(repositoryClass="\User\Repository\extrasRepository")
 * @ORM\Table(name="extras")
 */

class extrasEntity 
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(name="id_entity")
     */
    protected $id_entity;

    /**
     * @ORM\Column(name="dataExtra")
     */
    protected $dataExtra;



    /**
     * Returns id.
     * @return  integer
     */
    public function getid(){ return $this->id;}

     /**
     * Returns id_entity.
     * @return  string 
     */
    public function getId_entity(){return $this->id_entity;}

    /**
     * Returns dataExtra.
     * @return  string 
     */
    public function getdataextra(){return $this->dataExtra;}

     /**
     * Sets id
     * @param int $id
     */
    public function setid($id){$this->id = $id;}


    /**
     * Sets id_entity
     * @param string $id_entity
     */
    public function setid_entity($id_entity){$this->id_entity = $id_entity;}


    /**
     * Sets dataExtra
     * @param string $dataExtra
     */
    public function setDataExtra($dataExtra){$this->dataExtra = $dataExtra;}

    


}
