<?php

namespace Joselfonseca\LaravelApiTools\Exceptions;

use RuntimeException;

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
        $this->messages = is_array($messages) ? collect($messages) : $messages;
    }

    /**
     * @return array|\Illuminate\Support\Collection|string
     */
    public function getMessageBag()
    {
        return $this->messages;
    }

}