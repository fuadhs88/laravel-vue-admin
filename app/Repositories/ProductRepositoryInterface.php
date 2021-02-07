<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{

    const PER_PAGE = 10;
    /**
     * Get all
     * @return self
     */
    public function get();


    /**
     * Get one
     * @param int $id
     * @return self
     */
    public function find(int $id);

    /**
     * Create
     * @param array $attributes
     * @return self
     */
    public function create(array $attributes);

    /**
     * Update
     * @param int $id
     * @param array $attributes
     * @return self
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
     * @return self
     */
    public function paginate();

    /**
     * Pagination
     * @return self
     */
    public function latest();
}
