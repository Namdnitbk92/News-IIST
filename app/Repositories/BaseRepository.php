<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
	/**
     * @var Model
    */
    protected $model;
    /**
     * @var string
     */
    protected $resourceName;

    /**
     * @param Model $model
    */

	public function __construct(Model $model)
	{
		$this->model = $model;
		 // Set the Resource Name
        $this->resourceName = $this->model->getTable();
        $this->className = get_class($model);
	}

	 /**
     * Create a new model instance and store it in the database
     *
     * @param array $data
     * @return static
     */
    public function store(array $data)
    {
    	$model = $this->model->create($data);

    	return $model;
    }

        /**
     * Update a Model Object Instance
     *
     * @param int|string $id
     * @param array $data
     * @return \Illuminate\Support\Collection|null|static
     */
    public function update($id, array $data)
    {
    	// Fetch the Model Object
        $model = $this->byId($id);

        if ($model)
        {
        	$model->update($data);
        }

        return $model;
	}

	/**
     * Delete a model object
     *
     * @param string|Model
     *
     * @return boolean
     */
    public function delete($model)
    {
        // Delete the order
        return $model->delete();
    }

	/**
     * Return the Repository Model instance
     * @return Model
    */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Retrieve a single model object, using its id
     *
     * @param integer $id
     * @return null|Model
    */
    public function byId($id)
    {
        return $this->model->find($id);
    }

    /**
     * Determine if there is already an instance of a model with the given attributes
     *
     * @param array $attributes
     * @return model
     */
    public function ByWhere(array $attributes)
    {
        return $this->model->where($attributes);
    }
}
