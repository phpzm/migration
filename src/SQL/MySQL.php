<?php

namespace Simples\Migration\SQL;

use Simples\Migration\Driver as Migration;
use Simples\Migration\Instruction;
use Simples\Persistence\Drivers\MySQL as Database;
use Simples\Persistence\Field;
use const PHP_EOL;
use function implode;

/**
 * Class Driver
 * @package Simples\Migration\SQL
 */
class MySQL implements Migration
{
    /**
     * @param string $collection
     * @param array $fields
     * @return Instruction
     */
    public function create(string $collection, array $fields): Instruction
    {
        $command = [];
        $command[] = "CREATE TABLE `{$collection}`";
        $command[] = '(';
        $columns = [];
        /** @var Field $field */
        foreach ($fields as $field) {
            if (!$field->isMigratory()) {
                continue;
            }
            $columns[] = $this->parseFieldCreate($field);
        }
        $command[] = implode(',', $columns);
        $command[] = ')';

        return Instruction::make(
            implode(PHP_EOL, $command),
            function (Database $database) use ($collection) {
                return count($database->query("SHOW TABLES LIKE '{$collection}'")) > 0;
            }
        );
    }

    /**
     * @param string $collection
     * @param array $options
     * @return Instruction
     */
    public function alter(string $collection, array $options): Instruction
    {
        $command = [];
        $command[] = "ALTER TABLE `{$collection}`";
        $sets = [];
        foreach ($options as $key => $option) {
            $sets[] = "{$key } {$option}";
        }
        $command[] = implode(',', $sets);

        return Instruction::make(implode(PHP_EOL, $command));
    }

    /**
     * @param string $collection
     * @return Instruction
     */
    public function drop(string $collection): Instruction
    {
        $command = [];
        $command[] = "DROP TABLE `{$collection}`";

        return Instruction::make(
            implode(PHP_EOL, $command),
            function (Database $database) use ($collection) {
                return count($database->query("SHOW TABLES LIKE '{$collection}'")) === 0;
            }
        );
    }

    /**
     * @param string $collection
     * @param Field $field
     * @return Instruction
     */
    public function add(string $collection, Field $field): Instruction
    {
        $command = "ALTER TABLE `{$collection}` ADD COLUMN {$this->parseFieldCreate($field)}";
        $name = $field->getName();

        return Instruction::make(
            $command,
            function (Database $database) use ($collection, $name) {
                return count($database->query("SHOW COLUMNS FROM `{$collection}` LIKE '{$name}'")) > 0;
            }
        );
    }

    /**
     * @param string $collection
     * @param Field $field
     * @return Instruction
     */
    public function change(string $collection, Field $field): Instruction
    {
        return Instruction::make("ALTER TABLE `{$collection}` MODIFY {$this->parseFieldCreate($field)}");
    }

    /**
     * @param string $collection
     * @param Field $field
     * @return Instruction
     */
    public function remove(string $collection, Field $field): Instruction
    {
        $name = $field->getName();
        $command = "ALTER TABLE `{$collection}` DROP COLUMN {$name}";

        return Instruction::make(
            $command,
            function (Database $database) use ($collection, $name) {
                return count($database->query("SHOW COLUMNS FROM `{$collection}` LIKE '{$name}'")) === 0;
            }
        );
    }

    /**
     * @param Field $field
     * @return string
     */
    private function parseFieldCreate(Field $field)
    {
        $name = $field->getName();
        $type = $field->getType();

        return "`{$name}` {$type}";
    }
}
