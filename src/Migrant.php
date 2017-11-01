<?php

namespace Simples\Migration;

use Simples\Error\SimplesRunTimeError;
use Simples\Kernel\App;
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
     * @var Driver
     */
    private $migrate;

    /**
     * @var array
     */
    private $instructions = [];

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
     * @return Driver
     * @throws SimplesRunTimeError
     */
    private function driver(): Driver
    {
        if ($this->migrate) {
            return $this->migrate;
        }

        $settings = $this->model->getSettings();
        $migrate = off($settings, 'migrate');
        if (is_null($migrate)) {
            $class = get_class($this->model);
            throw new SimplesRunTimeError("Invalid migrate to driver used by `{$class}`");
        }
        $this->migrate = new $migrate;

        return $this->migrate;
    }

    /**
     * @return Migrant
     */
    public function create(): Migrant
    {
        $collection = $this->model->getCollection();
        $fields = $this->model->getFields();

        $instruction = $this->driver()->create($collection, $fields);

        return $this->append("{$collection}.create", $instruction);
    }

    /**
     * @param array $options
     * @return Migrant
     */
    public function alter(array $options): Migrant
    {
        $collection = $this->model->getCollection();

        $instruction = $this->driver()->alter($collection, $options);

        return $this->append("{$collection}.alter", $instruction);
    }

    /**
     * @return Migrant
     */
    public function drop(): Migrant
    {
        $collection = $this->model->getCollection();

        $instruction = $this->driver()->drop($collection);

        return $this->append("{$collection}.drop", $instruction);
    }

    /**
     * @param string $field
     * @return Migrant
     */
    public function add(string $field): Migrant
    {
        $collection = $this->model->getCollection();
        $fields = $this->model->getFields();

        $instruction = $this->driver()->add($collection, $fields[$field]);

        return $this->append("{$collection}.add.{$field}", $instruction);
    }

    /**
     * @param string $field
     * @return Migrant
     */
    public function change(string $field): Migrant
    {
        $collection = $this->model->getCollection();
        $fields = $this->model->getFields();

        $instruction = $this->driver()->change($collection, $fields[$field]);

        return $this->append("{$collection}.change.{$field}", $instruction);
    }

    /**
     * @param string $field
     * @return Migrant
     */
    public function remove(string $field): Migrant
    {
        $collection = $this->model->getCollection();
        $fields = $this->model->getFields();

        $instruction = $this->driver()->add($collection, $fields[$field]);

        return $this->append("{$collection}.remove.{$field}", $instruction);
    }

    /**
     * @param string $key
     * @param Instruction $instruction
     * @return Migrant
     */
    private function append(string $key, Instruction $instruction): Migrant
    {
        $this->instructions[$key] = $instruction;

        return $this;
    }

    /**
     * @return array
     */
    public function getInstructions(): array
    {
        return $this->instructions;
    }

}
