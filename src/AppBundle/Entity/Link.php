<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="links", indexes={
 *   @ORM\Index(name="code_idx", columns={"code"}),
 *   @ORM\Index(name="dest_idx", columns={"destination"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\LinkRepository")
 */
class Link
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=6, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=200, nullable=false)
     */
    private $destination;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set destination
     *
     * @param string $destination
     *
     * @return Links
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Link
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}