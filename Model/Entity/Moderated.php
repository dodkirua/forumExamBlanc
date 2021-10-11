<?php

namespace Model\Entity;

class Moderated extends Entity implements Interfaces\EntityInterface{
    private ?int $date;
    private ?int $remark_id;
    private ?string $reason;
    private ?int $user_id;

    public function __construct(int $id = null, int $date = null, int $remark_id = null,
    string $reason, int $user_id = null)    {
        parent::__construct($id);
        $this->setDate($date)
            ->setRemarkId($remark_id)
            ->setReason($reason)
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
     * @return Moderated
     */
    public function setDate(?int $date): Moderated    {
        $this->date = $date;
        return $this;
    }

    /**
     * get the RemarkId
     * @return int|null
     */
    public function getRemarkId(): ?int    {
        return $this->remark_id;
    }

    /**
     * set the RemarkId
     * @param int|null $remark_id
     * @return Moderated
     */
    public function setRemarkId(?int $remark_id): Moderated    {
        $this->remark_id = $remark_id;
        return $this;
    }

    /**
     * get the Reason
     * @return string|null
     */
    public function getReason(): ?string    {
        return $this->reason;
    }

    /**
     * set the Reason
     * @param string|null $reason
     * @return Moderated
     */
    public function setReason(?string $reason): Moderated    {
        $this->reason = $reason;
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
     * @return Moderated
     */
    public function setUserId(?int $user_id): Moderated    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['date'] = $this->getDate();
        $array['remark_id'] = $this->getRemarkId();
        $array['user_id'] = $this->getUserId();
        return $array;
    }
}