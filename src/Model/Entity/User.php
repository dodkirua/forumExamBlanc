<?php

namespace Dodkirua\Forum\Model\Entity;



class User extends Entity implements Interfaces\EntityInterface{
    private ?string $username;
    private ?string $mail;
    private ?string $pass;
    private ?int $checked_date;
    private ?Role $role;

    public function __construct(int $id = null, string $username = null, string $mail = null,
        string $pass = null, int $checked_date = null, Role $role = null)    {
        parent::__construct($id);
        $this->setUsername($username)
            ->setMail($mail)
            ->setPass($pass)
            ->setCheckedDate($checked_date)
            ->setRole($role);
    }

    /**
     * get the Username
     * @return string|null
     */
    public function getUsername(): ?string    {
        return $this->username;
    }

    /**
     * set the Username
     * @param string|null $username
     * @return User
     */
    public function setUsername(?string $username): User    {
        $this->username = $username;
        return $this;
    }

    /**
     * get the Mail
     * @return string|null
     */
    public function getMail(): ?string    {
        return $this->mail;
    }

    /**
     * set the Mail
     * @param string|null $mail
     * @return User
     */
    public function setMail(?string $mail): User    {
        $this->mail = $mail;
        return $this;
    }

    /**
     * get the Pass
     * @return string|null
     */
    public function getPass(): ?string    {
        return $this->pass;
    }

    /**
     * set the Pass
     * @param string|null $pass
     * @return User
     */
    public function setPass(?string $pass): User    {
        $this->pass = $pass;
        return $this;
    }

    /**
     * get the CheckedDate
     * @return int|null
     */
    public function getCheckedDate(): ?int    {
        return $this->checked_date;
    }

    /**
     * set the CheckedDate
     * @param int|null $checked_date
     * @return User
     */
    public function setCheckedDate(?int $checked_date): User    {
        $this->checked_date = $checked_date;
        return $this;
    }

    /**
     * get the Role
     * @return Role|null
     */
    public function getRole(): ?Role  {
        return $this->role;
    }

    /**
     * set the Role
     * @param Role|null $role
     * @return User
     */
    public function setRole(?Role $role): User    {
        $this->role = $role;
        return $this;
    }

    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['username'] = $this->getUsername();
        $array['mail'] = $this->getMail();
        $array['pass'] = $this->getPass();
        $array['checked_date'] = $this->getCheckedDate();
        $array['role'] = $this->getRole()->getAllData();
        return $array;
    }
}