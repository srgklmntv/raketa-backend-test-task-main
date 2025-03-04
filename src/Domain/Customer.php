<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain;

final class Customer
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $middleName;
    private string $email;

    /**
     * Customer constructor.
     *
     * @param int $id Unique identifier of the customer.
     * @param string $firstName Customer's first name.
     * @param string $lastName Customer's last name.
     * @param string $middleName Customer's middle name.
     * @param string $email Customer's email address.
     */
    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $middleName,
        string $email
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
        $this->email = $email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}