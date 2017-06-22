<?php

namespace Simples\Migration;

use Simples\Persistence\QueryBuilder;

/**
 * Class Runner
 * @package Simples\Migration
 */
class Runner extends QueryBuilder
{
    /**
     * @param string $instruction
     * @return mixed
     */
    public function execute(string $instruction)
    {
        return $this->run($instruction, []);
    }
}
