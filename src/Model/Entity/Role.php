<?php

namespace Dodkirua\Forum\Model\Entity;

class Role extends Entity implements Interfaces\EntityInterface{
    private ?string $name;

    public function __construct(int $id = null, string $name = null)    {
        parent::__construct($id);
        $this->setName($name);
    }

    /**
     * get the Name
     * @return string|null
     */
    public function getName(): ?string    {
        return $this->name;
    }

    /**
     * set the Name
     * @param string|null $name
     * @return Role
     */
    public function setName(?string $name): Role    {
        $this->name = $name;
        return $this;
    }

    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['name'] = $this->getName();
        return $array;
    }
}