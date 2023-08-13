<?php

namespace App\Repositories;

class BaseRepository
{
    protected $model;
    
    /**
     * setModel
     *
     * @param  mixed $model
     * @return void
     */
    public function setModel($model)
    {
        $this->model = $model;
    }
    
    /**
     * getAll
     *
     * @return void
     */
    public function getAll()
    {
        return $this->model->all();
    }
    
    /**
     * find
     *
     * @param  mixed $id
     * @return void
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }
    
    /**
     * create
     *
     * @param  mixed $data
     * @return void
     */
    public function create(array $data)
    {
        $model = $this->model->create($data);

        return $model;
    }
    
    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return void
     */
    public function update(int $id, array $data)
    {
        $model = tap($this->model->where('id', $id))->update($data);

        return $model;
    }
    
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete(int $id)
    {
        $model = $this->model->find($id);

        $modelClone = $model->replicate();

        $model->delete();

        return $modelClone;
    }
}
