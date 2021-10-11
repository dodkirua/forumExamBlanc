<?php

namespace Model\Entity;

class Topic extends Entity implements Interfaces\EntityInterface{
    private ?string $name;
    private ?int $cat_id;

    public function __construct(int $id = null, string $name = null, int $cat_id = null)    {
        parent::__construct($id);
        $this->setName($name);
        $this->setCatId($cat_id);
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
     * get the CatId
     * @return int|null
     */
    public function getCatId(): ?int    {
        return $this->cat_id;
    }

    /**
     * set the CatId
     * @param int|null $cat_id
     * @return Topic
     */
    public function setCatId(?int $cat_id): Topic    {
        $this->cat_id = $cat_id;
        return $this;
    }

    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['name'] = $this->getName();
        $array['cat_id'] = $this->getCatId();
        return $array;
    }
}