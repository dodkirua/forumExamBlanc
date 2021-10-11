<?php

namespace Model\Entity;

class Moderated extends Entity implements Interfaces\EntityInterface{
    private ?int $date;
    private ?Remark $remark;
    private ?string $reason;
    private ?User $user;

    public function __construct(int $id = null, int $date = null, Remark $remark = null,
    string $reason= null, User $user = null)    {
        parent::__construct($id);
        $this->setDate($date)
            ->setRemark($remark)
            ->setReason($reason)
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
     * @return Moderated
     */
    public function setDate(?int $date): Moderated    {
        $this->date = $date;
        return $this;
    }

    /**
     * get the RemarkId
     * @return Remark|null
     */
    public function getRemark(): ?Remark    {
        return $this->remark;
    }

    /**
     * set the RemarkId
     * @param Remark|null $remark
     * @return Moderated
     */
    public function setRemark(?Remark $remark): Moderated    {
        $this->remark = $remark;
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
     * @return User|null
     */
    public function getUser(): ?User    {
        return $this->user;
    }

    /**
     * set the UserId
     * @param User|null $user
     * @return Moderated
     */
    public function setUser(?User $user): Moderated    {
        $this->user = $user;
        return $this;
    }

    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['date'] = $this->getDate();
        $array['remark'] = $this->getRemark()->getAllData();
        $array['user'] = $this->getUser()->getAllData();
        return $array;
    }
}