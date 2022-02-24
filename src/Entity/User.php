<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints\Date;

class User
{
    /**
     * @var string
     */
    private $lastName;
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var Date
     */
    private $birthDate;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $file;
    /**
     * @var boolean
     */
    private $condition;

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return Date
     */
    public function getBirthDate(): Date
    {
        return $this->birthDate;
    }

    /**
     * @param Date $birthDate
     * @return User
     */
    public function setBirthDate(Date $birthDate): User
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return User
     */
    public function setTitle(string $title): User
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     * @return User
     */
    public function setFile(string $file): User
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCondition(): bool
    {
        return $this->condition;
    }

    /**
     * @param bool $condition
     * @return User
     */
    public function setCondition(bool $condition): User
    {
        $this->condition = $condition;
        return $this;
    }
}