<?php

namespace App\Traits;

trait HasColumnsModel
{
    public function getColsWhere($model, $columns_names = array(), $where = array(), $order_field = 'id', $order_type = 'desc')
    {
        $data = $model::select($columns_names)->where($where)->orderBy($order_field, $order_type);
        return $data;
    }

    public function getFieldValue($model, $field_name, $where = array())
    {
        $data = $model::where($where)->value($field_name);
        return $data;
    }
}
