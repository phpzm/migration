<?php

namespace Simples\Migration;

/**
 * Interface Driver
 * @package Simples\Migration
 */
interface Driver
{
    /**
     * @return string
     */
    public static function create(): string;

    /**
     * @param array $options
     * @return string
     */
    public static function alter(array $options): string;

    /**
     * @return string
     */
    public static function drop(): string;

    /**
     * @param string $field
     * @return string
     */
    public static function add(string $field): string;

    /**
     * @param string $field
     * @return string
     */
    public static function change(string $field): string;

    /**
     * @param string $field
     * @return string
     */
    public static function remove(string $field): string;

}
