<?php

namespace App\Entity;

class LinkRepository
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @return Link
     */
    public function create()
    {
        return new Link();
    }

    /**
     * @param Link $link
     */
    public function persist(Link $link)
    {
        $values = array(
            ':code'        => $link->getCode(),
            ':destination' => $link->getDestination(),
        );

        if ($link->exists()) {
            $values[':id'] = $link->getId();
            $sql = 'UPDATE links SET code = :code, destination = :destination WHERE id = :id';
        } else {
            $sql = 'INSERT INTO links (code, destination) VALUES (:code, :destination)';

        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
    }

    /**
     * @param string $field
     * @param string $value
     * @return Link|null
     */
    public function findOneBy($field, $value)
    {
        $stmt = $this->db->prepare(sprintf('SELECT * FROM links WHERE %s = :value LIMIT 1', $field));
        $stmt->bindParam(':value', $value);
        $stmt->execute();

        return $stmt->fetchObject(Link::class);
    }
}
