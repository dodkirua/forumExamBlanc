<?php

namespace Dodkirua\Forum\Model\Entity;

class Token extends Entity implements Interfaces\EntityInterface{
    private ?string $token;
    private ?int $validity;
    private ?User $user;

    public function __construct(int $id = null, string $token = null, int $validity = null,
        User $user = null)    {
        parent::__construct($id);
        $this->setToken($token)
            ->setValidity($validity)
            ->setUser($user);
    }

    /**
     * get the Token
     * @return string|null
     */
    public function getToken(): ?string    {
        return $this->token;
    }

    /**
     * set the Token
     * @param string|null $token
     * @return Token
     */
    public function setToken(?string $token): Token    {
        $this->token = $token;
        return $this;
    }

    /**
     * get the Validity
     * @return int|null
     */
    public function getValidity(): ?int    {
        return $this->validity;
    }

    /**
     * set the Validity
     * @param int|null $validity
     * @return Token
     */
    public function setValidity(?int $validity): Token    {
        $this->validity = $validity;
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
     * @return Token
     */
    public function setUserId(?User $user): Token    {
        $this->user_id = $user;
        return $this;
    }

    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['token'] = $this->getToken();
        $array['validity'] = $this->getValidity();
        $array['user'] = $this->getUser()->getAllData();
        return $array;
    }
}