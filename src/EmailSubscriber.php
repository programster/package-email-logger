<?php

/*
 * A subscriber object for subscribing to email logs.
 */

declare(strict_types = 1);

namespace Programster\EmailLogger;

use Programster\EmailLogger\Exceptions\ExceptionInvalidEmail;

final class EmailSubscriber
{
    private string $m_name;
    private string $m_email;


    /**
     * @param string $name
     * @param string $email
     * @throws ExceptionInvalidEmail - if an invalid email address was provided.
     */
    public function __construct(string $name, string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
        {
            throw new ExceptionInvalidEmail("Invalid email provided: {$email}");
        }

        $this->m_name = $name;
        $this->m_email = $email;
    }


    # accessors
    public function getName() : string { return $this->m_name; }
    public function getEmail() : string { return $this->m_email; }
}

