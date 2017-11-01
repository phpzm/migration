<?php

namespace Simples\Migration;

/**
 * Class Instruction
 * @package Simples\Migration
 */
class Instruction
{
    /**
     * @var string
     */
    private $command;

    /**
     * @var callable
     */
    private $done;

    /**
     * Instruction constructor.
     * @param string $command
     * @param callable $done
     */
    public function __construct(string $command, callable $done = null)
    {
        $this->command = $command;
        $this->done = $done ? $done : function () {
            return false;
        };
    }

    /**
     * @param string $command
     * @param callable|null $done
     * @return static
     */
    public static function make(string $command, callable $done = null)
    {
        return new static($command, $done);
    }
}
