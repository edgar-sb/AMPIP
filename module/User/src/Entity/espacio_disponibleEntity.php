<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered prueba.
 * @ORM\Entity(repositoryClass="\User\Repository\espacioDisponibleRepository")
 * @ORM\Table(name="espacio_disponible")
 */

class espacio_disponibleEntity
{


    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(name="corporativo")
     */
    protected $corporativo;
    /**
     * @ORM\Column(name="tipo")
     */
    protected $tipo;
    /**
     * @ORM\Column(name="uso")
     */
    protected $uso;
    /**
     * @ORM\Column(name="precioPromedio")
     */
    protected $precioPromedio;
    /**
     * @ORM\Column(name="id_parque")
     */
    protected $id_parque;
    /**
     * @ORM\Column(name="extras")
     */
    protected $extras;


    /**
     * Returns id.
     * @return integer
     */
    public function getid()
    {
        return $this->id;
    }


    /**
     * Returns corporativo.
     * @return string 
     */
    public function getcorporativo()
    {
        return $this->corporativo;
    }


    /**
     * Returns extras.
     * @return string
     */

    function getextras(){return $this->extras;}


    /**
     * Returns tipo.
     * @return string 
     */
    public function gettipo()
    {
        return $this->tipo;
    }


    /**
     * Returns uso.
     * @return string 
     */
    public function getuso()
    {
        return $this->uso;
    }




    /**
     * Returns precioPromedio.
     * @return integer 
     */
    public function getprecioPromedio()
    {
        return $this->precioPromedio;
    }




    /**
     * Returns id_parque.
     * @return integer
     */
    public function getid_parque()
    {
        return $this->id_parque;
    }




    /**
     * Sets id
     * @param int $id
     */
    public function setid($id)
    {
        $this->id = $id;
    }

    /**
     * Sets corporativo
     * @param int $corporativo
     */
    public function setcorporativo($corporativo)
    {
        $this->corporativo = $corporativo;
    }

    /**
     * Sets tipo
     * @param int $tipo
     */
    public function settipo($tipo)
    {
        $this->tipo = $tipo;
    }


    /**
     * Sets uso
     * @param int $uso
     */
    public function setuso($uso)
    {
        $this->uso = $uso;
    }


    /**
     * Sets precioPromedio
     * @param int $precioPromedio
     */
    public function setprecioPromedio($precioPromedio)
    {
        $this->precioPromedio = $precioPromedio;
    }

    /**
     * Sets id_parque
     * @param int $id_parque
     */
    public function setid_parque($id_parque)
    {
        $this->id_parque = $id_parque;
    }

    /**
     * Sets extras
     * @param string $extra
     */
    public function setextras($extra){ $this->extras = $extra; }
}
