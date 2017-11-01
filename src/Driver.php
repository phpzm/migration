<?php

namespace Simples\Migration;

use Simples\Persistence\Field;

/**
 * Interface Driver
 * @package Simples\Migration
 */
interface Driver
{
    /**
     * @param string $collection
     * @param array $fields
     * @return Instruction
     */
    public function create(string $collection, array $fields): Instruction;

    /**
     * @param string $collection
     * @param array $options
     * @return Instruction
     */
    public function alter(string $collection, array $options): Instruction;

    /**
     * @param string $collection
     * @return Instruction
     */
    public function drop(string $collection): Instruction;

    /**
     * @param string $collection
     * @param Field $field
     * @return Instruction
     */
    public function add(string $collection, Field $field): Instruction;

    /**
     * @param string $collection
     * @param Field $field
     * @return Instruction
     */
    public function change(string $collection, Field $field): Instruction;

    /**
     * @param string $collection
     * @param Field $field
     * @return Instruction
     */
    public function remove(string $collection, Field $field): Instruction;

}
