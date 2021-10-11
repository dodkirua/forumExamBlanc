<?php

namespace Model\Entity;

class Remark extends Entity implements Interfaces\EntityInterface{
    private ?int $date;
    private ?string $text;
    private ?int $topic_id;
    private ?int $user_id;

    public function __construct(int $id = null, int  $date = null, string $text = null,
        int $topic_id = null, int $user_id = null)    {
        parent::__construct($id);
        $this->setDate($date)
            ->setText($text)
            ->setTopicId($topic_id)
            ->setUserId($user_id);
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
     * get the TopicId
     * @return int|null
     */
    public function getTopicId(): ?int    {
        return $this->topic_id;
    }

    /**
     * set the TopicId
     * @param int|null $topic_id
     * @return Remark
     */
    public function setTopicId(?int $topic_id): Remark    {
        $this->topic_id = $topic_id;
        return $this;
    }

    /**
     * get the UserId
     * @return int|null
     */
    public function getUserId(): ?int    {
        return $this->user_id;
    }

    /**
     * set the UserId
     * @param int|null $user_id
     * @return Remark
     */
    public function setUserId(?int $user_id): Remark    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['date'] = $this->getDate();
        $array['text'] = $this->getText();
        $array['topic_id'] = $this->getTopicId();
        $array['user_id'] = $this->getUserId();
        return $array;
    }
}