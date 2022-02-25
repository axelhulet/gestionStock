<?php

namespace App\Entity;


use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @var \DateTime
     */
    private $birthDate;
    /**
     * @var string
     */
    private $title;
    /**
     * @var UploadedFile
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
     * @return \DateTime
     */
    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     * @return User
     */
    public function setBirthDate(\DateTime $birthDate): User
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
     * @return UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     * @return User
     */
    public function setFile(UploadedFile $file): User
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