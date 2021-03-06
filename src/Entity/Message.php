<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    #[Assert\Email]
    #[Assert\NotBlank]
    private $email ;
    /**
     * @var string
     */
    #[Assert\NotBlank(message: 'ce champs est requis')]
    #[Assert\Length( max:1000, min: 10, maxMessage: 'trop long', minMessage: 'trop court')]
    private  $message;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Message
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Message
     */
    public function setEmail(string $email): Message
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function setMessage(string $message): Message
    {
        $this->message = $message;
        return $this;
    }

}