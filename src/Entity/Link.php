<?php

namespace App\Entity;

class Link
{
    private $id;
    protected $code;
    protected $destination;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $code
     * @return Link
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param string $destination
     * @return Link
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return (bool) (isset($this->id) && !empty($this->id));
    }
}
