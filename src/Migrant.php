<?php

namespace Simples\Migration;

use Simples\Kernel\Container;
use Simples\Model\ModelAbstract;

/**
 * Class Migrant
 * @package Simples\Migration
 */
abstract class Migrant
{
    /**
     * @var ModelAbstract
     */
    protected $model;

    /**
     * Migrant constructor.
     * @param ModelAbstract $model
     */
    public function __construct(ModelAbstract $model)
    {
        $this->model = $model;
    }

    /**
     * @return Migrant
     */
    public static function instance(): Migrant
    {
        return Container::instance()->make(static::class);
    }

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
