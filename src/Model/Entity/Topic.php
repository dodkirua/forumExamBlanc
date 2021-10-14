<?php

namespace Dodkirua\Forum\Model\Entity;

class Topic extends Entity implements Interfaces\EntityInterface{
    private ?string $name;
    private ?string $description;
    private ?Category $cat;

    public function __construct(int $id = null, string $name = null,string $description = null,
                                Category $cat = null)    {
        parent::__construct($id);
        $this->setName($name)
            ->setDescription($description)
            ->setCat($cat);
    }

    /**
     * get the Description
     * @return string|null
     */
    public function getDescription(): ?string    {
        return $this->description;
    }

    /**
     * set the Description
     * @param string|null $description
     * @return Topic
     */
    public function setDescription(?string $description): Topic    {
        $this->description = $description;
        return $this;
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
     * @return Topic
     */
    public function setName(?string $name): Topic    {
        $this->name = $name;
        return $this;
    }

    /**
     * get the Cat
     * @return Category|null
     */
    public function getCat(): ?Category    {
        return $this->cat;
    }

    /**
     * set the Cat
     * @param Category|null $cat
     * @return Topic
     */
    public function setCat(?Category $cat): Topic    {
        $this->cat = $cat;
        return $this;
    }

    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['name'] = $this->getName();
        $array['description'] = $this->getDescription();
        $array['cat'] = $this->getCat()->getAllData();
        return $array;
    }
}