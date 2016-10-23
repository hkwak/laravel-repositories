<?php

namespace Tmd\LaravelRepositories\Base;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tmd\LaravelRepositories\Interfaces\RepositoryInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * Return the fully qualified class name of the Models this repository returns.
     *
     * @return EloquentModel|string|\Illuminate\Database\Eloquent\Builder
     */
    abstract public function getModelClass();

    /**
     * Return a model by its primary key.
     *
     * @param mixed $key
     *
     * @return EloquentModel|null
     */
    public function find($key)
    {
        return $this->queryModelByKey($key);
    }

    /**
     * Return a model by its primary key. Throws an exception if not found.
     *
     * @param mixed $key
     *
     * @return EloquentModel|null
     *
     * @throws NotFoundHttpException
     */
    public function findOrFail($key)
    {
        if ($model = $this->queryModelByKey($key)) {
            return $model;
        }

        $class = $this->getModelClass();
        $this->throwNotFoundException((new $class)->getKeyName(), $key);

        return null;
    }

    /**
     * Return a model by the value of a field.
     *
     * @param string $field
     *
     * @param mixed  $value
     *
     * @return EloquentModel|null
     */
    public function findBy($field, $value)
    {
        return $this->queryModelByField($field, $value);
    }

    /**
     * Return a model by the value of a field. Throws an exception if not found.
     *
     * @param string $field
     * @param mixed  $value
     *
     * @return EloquentModel|null
     */
    public function findByOrFail($field, $value)
    {
        if ($model = $this->queryModelByField($field, $value)) {
            return $model;
        }
        $this->throwNotFoundException($field, $value);

        return null;
    }

    /**
     * Return all of this model.
     *
     * @return \Illuminate\Database\Eloquent\Collection|EloquentModel[]
     */
    public function all()
    {
        $class = $this->getModelClass();

        return $class::all();
    }

    /**
     * @param EloquentModel $model
     *
     * @return EloquentModel
     */
    public function persist(EloquentModel $model)
    {
        $model->save();

        return $this->find($model);
    }

    /**
     * @param mixed $key
     *
     * @return EloquentModel|null
     */
    protected function queryModelByKey($key)
    {
        $class = $this->getModelClass();

        return $class::find($key);
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return EloquentModel|null
     */
    protected function queryModelByField($field, $value)
    {
        $class = $this->getModelClass();

        return $class::where($field, $value)->first();
    }

    /**
     * @return string
     */
    protected function getModelClassWithoutNamespace()
    {
        $string = explode('\\', $this->getModelClass());

        return array_pop($string);
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $message
     */
    protected function throwNotFoundException($field, $value, $message = null)
    {
        if (!$message) {
            $message = "{$this->getModelClass()} with {$field} {$value} not found.";
        }
        throw new NotFoundHttpException($message);
    }
}