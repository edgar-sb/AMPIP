<?php


namespace User\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered prueba.
 * @ORM\Entity(repositoryClass="\User\Repository\corpRepository")
 * @ORM\Table(name="copomex")
 */

class copomexEntity {
     /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(name="colonia")
     */
    protected $colonia;
    /**
     * @ORM\Column(name="estado")
     */
    protected $estado;

    /**
     * @ORM\Column(name="municipio")
     */
    protected $municipio;

    /**
     * @ORM\Column(name="cp")
     */
    protected $cp;


    public function getId(){
        return $this->id;
    }

    public function getmunicipio(){
        return $this->municipio;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getColonia(){
        return $this->colonia;
    }

    public function getCp (){
        return $this->cp;
    }
}