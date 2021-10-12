<?php

namespace Dodkirua\Forum\Model\Entity;

class Closed extends Entity implements Interfaces\EntityInterface{
    private ?int $date;
    private ?Topic $topic;
    private ?User $user;

    public function __construct(int $id = null, int $date = null, Topic $topic = null, User $user =null)   {
        parent::__construct($id);
        $this->setDate($date)
            ->setTopic($topic)
            ->setUser($user);
    }

    /**
     * get the Date
     * @return int|null
     */
    public function getDate(): ?int    {
        return $this->date;
    }

    /**
     * set the Date
     * @param int|null $date
     * @return Closed
     */
    public function setDate(?int $date): Closed    {
        $this->date = $date;
        return $this;
    }

    /**
     * get the Topic
     * @return Topic|null
     */
    public function getTopic(): ?Topic    {
        return $this->topic;
    }

    /**
     * set the Topic
     * @param Topic|null $topic
     * @return Closed
     */
    public function setTopic(?Topic $topic): Closed    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * get the User
     * @return User|null
     */
    public function getUser(): ?User    {
        return $this->user;
    }

    /**
     * set the User
     * @param User|null $user
     * @return Closed
     */
    public function setUser(?User $user): Closed    {
        $this->user = $user;
        return $this;
    }



    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['topic'] = $this->getTopic()->getAllData();
        $array['user'] = $this->getUser()->getAllData();
        return $array;
    }
}