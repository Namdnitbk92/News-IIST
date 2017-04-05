<?php 

namespace App\Repositories;

interface BaseRepositoryInterface
{
    /**
     * Create a new model instance and store it in the database
     *
     * @param array $data
     * @return static
 	*/
    public function store (array $data);

    /**
     * Update a Model Object Instance
     *
     * @param int|string $id
     * @param array $data
     * @return \Illuminate\Support\Collection|null|static
     */
    public function update($id, array $data);

 	/**
     * Delete a model object
     *
     * @param string|Model
     *
     * @return boolean
    */
    public function delete($model);

    /**
     * Retrieve a single model object, using its id
     *
     * @param integer $id
     * @return null|Model
    */
    public function byId($id);

    /**
     * Return the Repository Model instance
     * @return Model
    */
    public function getModel();

    public function ByWhere(array $attributes);

}
