<?php

namespace Model\Entity;

class Token extends Entity implements Interfaces\EntityInterface{
    private ?string $token;
    private ?int $validity;
    private ?int $user_id;

    public function __construct(int $id = null, string $token = null, int $validity = null,
        int $user_id = null)    {
        parent::__construct($id);
        $this->setToken($token)
            ->setValidity($validity)
            ->setUserId($user_id);
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
     * get the UserId
     * @return int|null
     */
    public function getUserId(): ?int    {
        return $this->user_id;
    }

    /**
     * set the UserId
     * @param int|null $user_id
     * @return Token
     */
    public function setUserId(?int $user_id): Token    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getAllData(): array    {
        $array['id'] = $this->getId();
        $array['token'] = $this->getToken();
        $array['validity'] = $this->getValidity();
        $array['user_id'] = $this->getUserId();
        return $array;
    }
}