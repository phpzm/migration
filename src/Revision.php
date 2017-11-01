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
     * Method what contains the instruction to up a Revision
     */
    abstract public function up();

    /**
     * Method what contains the instruction to down a Revision
     */
    abstract public function down();

    /**
     * @param Migrant $migrant
     * @param string $owner
     * @param bool $once
     * @return Revision
     */
    protected function add(Migrant $migrant, string $owner = '', bool $once = false): Revision
    {
        $this->instructions[] = ['instructions' => $migrant->getInstructions(), 'owner' => $owner, 'once' => $once];

        return $this;
    }

    /**
     * @param Migrant $migrant
     * @param string $owner
     * @return Revision
     */
    protected function once(Migrant $migrant, string $owner = '')
    {
        return $this->add($migrant, $owner, true);
    }

    /**
     * @return array
     */
    public function getInstructions(): array
    {
        return $this->instructions;
    }
}
