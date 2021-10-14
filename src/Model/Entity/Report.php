<?php

namespace Dodkirua\Forum\Model\Entity;

class Report extends Entity implements Interfaces\EntityInterface{
    private ?int $date;
    private ?string $reason;
    private ?User $user;
    private ?Remark $remark;

    public function __construct(int $id = null, int $date= null, string $reason = null,
                                User $user = null, Remark $remark)    {
        parent::__construct($id);
        $this->setDate($date)
            ->setReason($reason)
            ->setUser($user)
            ->setRemark($remark);
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
     * @return Report
     */
    public function setDate(?int $date): Report    {
        $this->date = $date;
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
     * @return Report
     */
    public function setReason(?string $reason): Report    {
        $this->reason = $reason;
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
     * @return Report
     */
    public function setUser(?User $user): Report    {
        $this->user = $user;
        return $this;
    }

    /**
     * get the Remark
     * @return Remark|null
     */
    public function getRemark(): ?Remark    {
        return $this->remark;
    }

    /**
     * set the Remark
     * @param Remark|null $remark
     * @return Report
     */
    public function setRemark(?Remark $remark): Report    {
        $this->remark = $remark;
        return $this;
    }



    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['date'] = $this->getDate();
        $array['reason'] = $this->getReason();
        $array['user'] = $this->getUser()->getAllData();
        $array['remark'] = $this->getRemark()->getAllData();
        return $array;
    }
}