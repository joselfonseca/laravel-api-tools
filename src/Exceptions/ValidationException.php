<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

use RuntimeException;
use Illuminate\Support\MessageBag;

/**
 * Class ValidationException
 * @package Joselfonseca\LaravelApiTools\Exceptions
 */
class ValidationException extends RuntimeException
{


    /**
     * @var \Illuminate\Support\Collection|array
     */
    protected $messages;


    /**
     * ValidationException constructor.
     * @param string $messages
     */
    public function __construct($messages)
    {
        $this->messages = is_array($messages) ? new MessageBag($messages) : $messages;
    }

    /**
     * @return array|\Illuminate\Support\MessageBag|string
     */
    public function getMessageBag()
    {
        return $this->messages;
    }

}
