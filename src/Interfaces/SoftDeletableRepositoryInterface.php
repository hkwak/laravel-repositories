<?php

namespace Tmd\LaravelRepositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface SoftDeletableRepositoryInterface
{
    /**
     * Return a model by its primary key that MAY be soft deleted.
     *
     * @param mixed $modelId
     *
     * @return Model|null
     */
    public function findWithTrashed($modelId);

    /**
     * Return a model by its primary key that MAY be soft deleted or throw an exception if not found.
     *
     * @param mixed $modelId
     *
     * @return Model
     */
    public function findWithTrashedOrFail($modelId);

    /**
     * Return a model by its primary key that MUST be soft deleted.
     *
     * @param mixed $modelId
     *
     * @return Model|null
     */
    public function findTrashed($modelId);

    /**
     * Return a model by its primary key that MUST be soft deleted or throw an exception if not found.
     *
     * @param mixed $modelId
     *
     * @return Model
     */
    public function findTrashedOrFail($modelId);

    /**
     * Return a model by matching the specified field that MAY be soft deleted.
     *
     * @param string $field
     * @param mixed $value
     *
     * @return Model|null
     */
    public function findOneByWithTrashed(string $field, $value);

    /**
     * Return a model by matching the specified field that MAY be soft deleted or throw an exception if not found.
     *
     * @param string $field
     * @param mixed $value
     *
     * @return Model
     */
    public function findOneByWithTrashedOrFail(string $field, $value);

    /**
     * Return a model by matching the specified field that MUST be soft deleted.
     *
     * @param string $field
     * @param mixed $value
     *
     * @return Model|null
     */
    public function findTrashedOneBy(string $field, $value);

    /**
     * Return a model by matching the specified field that MUST be soft deleted or throw an exception if not found.
     *
     * @param string $field
     * @param mixed $value
     *
     * @return Model
     */
    public function findTrashedOneByOrFail(string $field, $value);
}
