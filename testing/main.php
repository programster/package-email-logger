<?php


use Programster\EmailLogger\EmailLogger;

require_once(__DIR__ . '/settings.php');


function main()
{
    $emailer = new Programster\Emailers\PhpMailerEmailer(
        SMTP_HOST,
        SMTP_USER,
        SMTP_PASSWORD,
        SMTP_PROTOCOL,
        SMTP_FROM_EMAIL,
        SMTP_FROM_NAME,
        SMTP_PORT,
        SMTP_REPLY_TO_EMAIL,
        SMTP_REPLY_TO_NAME
    );

    $logger = new EmailLogger(
        $emailer,
        "test-service",
        ...EMAIL_SUBSCRIBERS
    );

    $logger->debug("This is an debug log"); // deliberately no context.
    $logger->notice("This is a notice log", ['name' => 'value']);
    $logger->info("This is an info log", ['name' => 'value']);
    $logger->warning("This is a warning log", ['name' => 'value']);
    $logger->alert("This is an alert log", ['name' => 'value']);
    $logger->emergency("This is an emergency log", ['name' => 'value']);
    $logger->critical("This is a critical log", ['name' => 'value']);
}

main();

