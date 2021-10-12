<?php

namespace Dodkirua\Forum\Model\Entity;

class Remark extends Entity implements Interfaces\EntityInterface{
    private ?int $date;
    private ?string $text;
    private ?topic $topic;
    private ?User $user;

    public function __construct(int $id = null, int  $date = null, string $text = null,
        Topic $topic = null, User $user = null)    {
        parent::__construct($id);
        $this->setDate($date)
            ->setText($text)
            ->setTopicId($topic)
            ->setUserId($user);
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
     * @return Remark
     */
    public function setDate(?int $date): Remark    {
        $this->date = $date;
        return $this;
    }

    /**
     * get the Text
     * @return string|null
     */
    public function getText(): ?string    {
        return $this->text;
    }

    /**
     * set the Text
     * @param string|null $text
     * @return Remark
     */
    public function setText(?string $text): Remark    {
        $this->text = $text;
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
     * @return Remark
     */
    public function setTopicId(?Topic $topic): Remark    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * get the User
     * @return User|null
     */
    public function getUser(): ?User   {
        return $this->user;
    }

    /**
     * set the User
     * @param User|null $user
     * @return Remark
     */
    public function setUserId(?User $user): Remark    {
        $this->user = $user;
        return $this;
    }

    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['date'] = $this->getDate();
        $array['text'] = $this->getText();
        $array['topic'] = $this->getTopic()->getAllData();
        $array['user'] = $this->getUser()->getAllData();
        return $array;
    }
}