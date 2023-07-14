<?php

namespace App\Repositories\Contracts;

interface BaseRepositoryInterface {

    public function create($data);

    public function update($data, $key);

    public function list($request, $orderByField, $orderByOrder, $paginate);

    public function find($key);

    public function findIn($keys, $field = null);

    public function findNot($key, $value);

    public function first($request, $data);

    public function destroy($key);

    public function columns();

    public function all();

    public function chacheKey();

    public function where($key, $data);

    public function whereNotNull($key);
    public function whereS($key, $value);
}
