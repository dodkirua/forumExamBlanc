<?php

namespace Dodkirua\Forum\Model\Entity;

class Category extends Entity implements Interfaces\EntityInterface{
    private ?string $name;
    private ?bool $archived;
    private ?string $description;

    public function __construct(int $id = null, string $name = null, bool $archived = null,
        string $description = null)    {
        parent::__construct($id);
        $this->setName($name)
            ->setArchived($archived)
            ->setDescription($description);
    }

    /**
     * get the Name
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * set the Name
     * @param string|null $name
     * @return Category
     */
    public function setName(?string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    /**
     * get the Archived
     * @return bool|null
     */
    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    /**
     * set the Archived
     * @param bool|null $archived
     * @return Category
     */
    public function setArchived(?bool $archived): Category
    {
        $this->archived = $archived;
        return $this;
    }

    /**
     * get the Description
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * set the Description
     * @param string|null $description
     * @return Category
     */
    public function setDescription(?string $description): Category
    {
        $this->description = $description;
        return $this;
    }



    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['name'] = $this->getName();
        $array['archived'] = $this->getArchived();
        $array['description'] = $this->getDescription();
        return $array;
    }
}