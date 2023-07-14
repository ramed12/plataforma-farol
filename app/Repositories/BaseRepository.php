<?php

namespace App\Repositories;
use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function update($data, $key) {
        return tap($this->find($key))->update($data);
    }

    public function list($request, $orderByField, $orderByOrder, $paginate) {

        $fillable  = $this->model->getFillable();
        $relations = $this->model->getRelations();
        $model     = $this->model->orderBy($orderByField, $orderByOrder);

        foreach ($request->except(['page', 'per_page', 'order_by_field','order_by_order']) as $field => $filter) {

            if (in_array($field, $fillable)) {

                switch ($field) {
                    case 'created_at':
                    case 'updated_at':
                    case 'deleted_at':
                        if ($request->input($field)) {
                            $model->whereDate($field, $filter);
                        }
                        break;
                    case 'name':
                    case 'email':
                        if ($request->input($field)) {
                           $model->where($field, "like", "%".$filter."%");
                        }
                        break;
                    default:
                        if ($request->input($field)) {
                            $model->where($field, $filter);
                        }
                    break;
                }

            } else {

                if($request->input($field)) {

                    if (is_array($request->input($field))) {

                        $model->whereHas($relations[$field][0], function($query) use ($relations, $field, $filter){
                            $query->whereIn($relations[$field][1].".".$field, $filter);
                        });

                    } else {
                        $model->whereRelation($relations[$field][0],$relations[$field][1].'.'.$field,$filter)->get();
                    }
                }
            }
        }

        return is_null($paginate) ? $model->get() : $model->paginate($paginate);
    }

    public function find($key) {

        return $this->model->findOrFail($key);
    }

    public function findIn($keys, $field = null) {
        return $this->model->whereIn(((is_null($field)) ? $this->model->getKeyName() : $field), $keys)->get();
    }

     public function whereInNotNull($keys, $field = null) {
        return $this->model->whereNotNull(((is_null($field)) ? $this->model->getKeyName() : $field), $keys)->get();
    }

    public function findNot($key, $value){
        return $this->model->whereNotIn($key, $value)->whereNull('id_father')->get();
    }

    public function whereNotNull($key){
        return $this->model->whereNotNull($key)->get();
    }

    public function first($request, $data) {

        $fillable  = $this->model->getFillable();
        $relations = $this->model->getRelations();
        $model     = $this->model;

        foreach ($data as $field => $filter) {

            if (in_array($field, $fillable)) {

                switch ($field) {
                    case 'created_at':
                    case 'updated_at':
                    case 'deleted_at':
                        if ($request->input($field)) {
                            $model->whereDate($field, $filter);
                        }
                        break;
                    case 'name':
                        if ($request->input($field)) {
                           $model->where($field, "like", "%".$filter."%");
                        }
                        break;
                    default:
                        if ($request->input($field)) {
                            $model->where($field, $filter);
                        }
                        break;
                }
            } else {
                if ($request->input($field)) {
                    $model->whereRelation($relations[$field][0],$relations[$field][1].'.'.$field,$filter)->get();
                }
            }
        }

        return $model->first();
    }

    public function destroy($key) {
        return tap($this->find($key))->delete();
    }

    public function columns() {
        return $this->model->getColumns();
    }

    public function all() {
        return $this->model->get();
    }

    // Adicionado por josé

    public function where($key, $value){
        return $this->model->where($key, $value)->first();
    }

    public function whereS($key, $value){
        return $this->model->where($key, $value)->get();
    }

    public function chacheKey() {
        return $this->model->getTable();
    }
}
