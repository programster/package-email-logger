# Email Logger Package
A [PSR-3](https://www.php-fig.org/psr/psr-3/) logger for PHP that sends logs via email.


## Installation

```bash
composer require programster/email-logger
```

## Example Usage
```php
# Create an emailer, in this case using PHPMailer.
# Any emailer that implements the EmailerInterface will work
$emailer = new Programster\Emailers\PhpMailerEmailer(
    "smtp.gmail.com",
    "someemail@gmail.com",
    "app-specific-password-goes-here",
    SecurityProtocol::TLS,
    "someemail@gmail.com",
    "Senders Name",
    587,
    "noreply@someemail.com",
    "noreply"
);

# Create the email logger
$logger = new EmailLogger(
    $emailer,
    "my-service-name-here",
    new EmailSubscriber("Jenn", "jenn@somdomain.com"),
    new EmailSubscriber("Roy", "roy@anotherdomain.com"),
);

# Create some useful context for the log that might help debugging/resolving what went wrong...
$context = [
    'some' => 'details'
];

# Send the log (email)
$logger->critical("There was a critical error!", $context);
```


## Testing
When developing this package, please be sure to test, even if it's very basic. For now, one can
test by removing the `.example` extension from the `settings.php.example` file, and filling it in.
Then execute the `main.php` script to send emails to the subscribers specified in your settings.