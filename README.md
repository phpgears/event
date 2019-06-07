[![PHP version](https://img.shields.io/badge/PHP-%3E%3D7.1-8892BF.svg?style=flat-square)](http://php.net)
[![Latest Version](https://img.shields.io/packagist/v/phpgears/event.svg?style=flat-square)](https://packagist.org/packages/phpgears/event)
[![License](https://img.shields.io/github/license/phpgears/event.svg?style=flat-square)](https://github.com/phpgears/event/blob/master/LICENSE)

[![Build Status](https://img.shields.io/travis/phpgears/event.svg?style=flat-square)](https://travis-ci.org/phpgears/event)
[![Style Check](https://styleci.io/repos/149037486/shield)](https://styleci.io/repos/149037486)
[![Code Quality](https://img.shields.io/scrutinizer/g/phpgears/event.svg?style=flat-square)](https://scrutinizer-ci.com/g/phpgears/event)
[![Code Coverage](https://img.shields.io/coveralls/phpgears/event.svg?style=flat-square)](https://coveralls.io/github/phpgears/event)

[![Total Downloads](https://img.shields.io/packagist/dt/phpgears/event.svg?style=flat-square)](https://packagist.org/packages/phpgears/event/stats)
[![Monthly Downloads](https://img.shields.io/packagist/dm/phpgears/event.svg?style=flat-square)](https://packagist.org/packages/phpgears/event/stats)

# Event

Event base classes and handling interfaces

This package only provides the building blocks to Event

## Installation

### Composer

```
composer require phpgears/event
```

## Usage

Require composer autoload file

```php
require './vendor/autoload.php';
```

### Events

Events are DTOs that carry all the information for an action to happen

You can create your own by implementing `Gears\Event\Event` or extending from `Gears\Event\AbstractEvent` which ensures event immutability and payload and metadata is composed only of **scalar values** which is a very interesting capability. AbstractEvent has a private constructor forcing you to create events using the _occurred_ static method

```php
use Gears\Event\AbstractEvent;

class CreateUserEvent extends AbstractEvent
{
    public static function fromPersonalData(
        string $name,
        string lastname,
        \DateTimeImmutable $birthDate
    ): self {
        return new occurred([
            'name' => $name,
            'lastname' => $lastname,
            'birthDate' => $birthDate->format('U'),
        ]);
    }
}
```

In case of a event without any payload you could extend `Gears\Event\AbstractEmptyEvent`

```php
use Gears\Event\AbstractEvent;

class CreateUserEvent extends AbstractEmptyEvent
{
    public static function instance(): self {
        return self::occurred();
    }
}
```

### Collection

Events can be grouped into iterables implementing `Gears\Event\EventCollection` objects, `Gears\Event\EventArrayCollection` is provided accepting only instances of `Gears\Event\Event`

#### Async events

Having event assuring all of its payload is composed only of scalar values proves handy when you want to delegate event handling to a message queue system such as RabbitMQ, Gearman or Apache Kafka, serializing/deserializing scalar values is trivial in any format and language

Asynchronous behaviour must be implemented at EventBus level, event bus must be able to identify async events (a map of events, implementing an interface, by a payload parameter, ...) and enqueue them 

If you want to have asynchronous behaviour on your EventBus have a look [phpgears/event-async](https://github.com/phpgears/event-async), there you'll find all the necessary pieces to start your async event bus

### Handlers

Events are handed over to implementations of `Gears\Event\EventHandler`, available in this package is `AbstractEventHandler` which verifies the type of the event so you can focus only on implementing the handling logic

```php
class CreateUserEventHandler extends AbstractEventHandler
{
    protected function getSupportedEventType(): string
    {
        return CreateUserEvent::class;
    }

    protected function handleEvent(Event $event): void
    {
        /* @var CreateUserEvent $event */

        $user = new User(
            $event->getName(),
            $event->getLastname(),
            $event->getBirthDate()
        );

        [...]
    }
}
```

Have a look at [phpgears/dto](https://github.com/phpgears/dto) fo a better understanding of how events are built out of DTOs and how they hold their payload

### Event Bus

Only `Gears\Event\EventBus` interface is provided, you can easily use any of the good bus libraries available out there by simply adding an adapter layer

#### Implementations

Event bus implementations currently available

* [phpgears/event-symfony-messenger](https://github.com/phpgears/event-symfony-messenger) uses Symfony's Messenger
* [phpgears/event-symfony-event-dispatcher](https://github.com/phpgears/event-symfony-event-dispatcher) uses Symfony's Event Dispatcher

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/phpgears/event/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/phpgears/event/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/phpgears/event/blob/master/LICENSE) included with the source code for a copy of the license terms.
