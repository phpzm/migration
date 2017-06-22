<?php

namespace Simples\Migration;

use Simples\Persistence\QueryBuilder;

/**
 * Class Revision
 * @package Simples\Migration
 */
abstract class Revision extends QueryBuilder
{
    /**
     * @var array
     */
    private $instructions = [];

    /**
     * @param mixed $instructions
     * @param string $owner
     * @return Revision
     */
    protected function add(mixed $instructions, string $owner = ''): Revision
    {
        $this->instructions[] = [
            'instructions' => $instructions,
            'owner' => $owner,
        ];

        return $this;
    }

    /**
     * Process the instruction
     */
    public function run()
    {
//        foreach ($this->instructions as $instruction) {
//
//        }
    }

    /**
     * Method what contains the instruction to up a Revision
     */
    abstract public function up();

    /**
     * Method what contains the instruction to down a Revision
     */
    abstract public function down();
}
