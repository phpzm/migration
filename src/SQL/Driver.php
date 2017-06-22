<?php

namespace Simples\Migration\SQL;

use Simples\Migration\Driver as Migration;

/**
 * Class Driver
 * @package Simples\Migration\SQL
 */
abstract class Driver implements Migration
{
    /**
     * @return string
     */
    public static function create(): string
    {
        return 'create';
    }

    /**
     * @param array $options
     * @return string
     */
    public static function alter(array $options): string
    {
        return $options;
    }

    /**
     * @return string
     */
    public static function drop(): string
    {
        return 'drop';
    }

    /**
     * @param string $field
     * @return string
     */
    public static function add(string $field): string
    {
        return 'add ' . $field;
    }

    /**
     * @param string $field
     * @return string
     */
    public static function change(string $field): string
    {
        return 'change ' . $field;
    }

    /**
     * @param string $field
     * @return string
     */
    public static function remove(string $field): string
    {
        return 'remove ' . $field;
    }
}
