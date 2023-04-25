<?php

/*
 * This class is a logger which logs to a mysqli database connection.
 * Requires a database table with at LEAST the following fields
 *  - message - (varchar/text)
 *  - priority - (int)
 *  - context - (full text for json)
 */

declare(strict_types = 1);

namespace Programster\EmailLogger;

use Programster\Emailers\EmailerInterface;
use Programster\Log\AbstractLogger;

final class EmailLogger extends AbstractLogger
{
    private EmailerInterface $m_emailer;
    private array $m_subscribers;
    private string $m_serviceName;


    /**
     * Creates a logger that logs to email addresses
     * @param EmailerInterface $emailer - an emailer to send through
     * @param string $serviceName - the name of the service that is triggering the logs
     * @param EmailSubscriber ...$subscribers - any number of people to recieve the logs.
     */
    public function __construct(
        EmailerInterface $emailer,
        string $serviceName,
        EmailSubscriber ...$subscribers
    )
    {
        $this->m_emailer = $emailer;
        $this->m_subscribers = $subscribers;
        $this->m_serviceName = $serviceName;
    }


    /**
     * Logs with an arbitrary level.
     * @param $level - the log level.
     * @param string|\Stringable $message -  the message of the error, e.g "failed to connect to db"
     * @param array $context - name value pairs providing context to error, e.g. "dbname => "yolo")
     * @return void
     * @throws \Programster\Emailers\ExceptionFailedToSendEmail - if emailer failed to send email.
     * @throws \Programster\Log\Exceptions\ExceptionInvalidLogLevel - if an invalid log level was provided.
     */
    public function log($level, string|\Stringable $message, array $context = []) : void
    {
        $logLevelEnum = $this->convertLogLevelMixedVariable($level);

        $subject = $this->m_serviceName . ' - ' . $logLevelEnum->value;

        $body =
            '<p>This is a <em>' . $logLevelEnum->value . '</em> level log from [ ' . $this->m_serviceName . ' ]</p>' .
            '<h3>Error Message:</h3>' .
            '<pre>' . $message . '</pre>' .
            '<h3>Context:</h3>' .
            '<pre>' . print_r($context, true) . '</pre>';

        foreach ($this->m_subscribers as $subscriber)
        {
            $this->m_emailer->send(
                $subscriber->getName(),
                $subscriber->getEmail(),
                $subject,
                $body,
                true // htmlFormat
            );
        }
    }
}
