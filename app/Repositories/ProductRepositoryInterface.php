<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function get();


    /**
     * Get one
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(int $id, array $attributes);

    /**
     * Delete
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * Pagination
     * @param int $perPage
     * @return mixed
     */
    public function paginate(int $perPage);

    /**
     * Pagination
     * @return mixed
     */
    public function latest();
}
