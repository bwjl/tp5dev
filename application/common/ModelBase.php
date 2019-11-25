<?php

namespace app\common;

use think\Model;

abstract class ModelBase extends Model
{

    //多条记录查询
    public function getListDetailByQuery(array $where = [], $field = ['*'], $order = 'id asc', $isCount = false)
    {
        $obj = empty($where) ? $this : $this->where($where);
        if ($isCount) {
            return $obj->count('id');
        } else {
            return $obj->field($field)
                ->where('is_delete', DB_ISDELETE_NO)
                ->order($order)
                ->select()
                ->toArray();
        }
    }

    //单条主键查询
    public function getOne($id, array $field = ['*'])
    {
        $obj = $this->field($field)
            ->where('id', $id)
            ->where(['is_delete' => DB_ISDELETE_NO])
            ->find();
        return $obj ? $obj->toArray() : false;

    }

    //单条详情查询
    public function getDetail(array $where, array $field = ['*'])
    {
        $obj = $this->field($field)
            ->where($where)
            ->where('is_delete', DB_ISDELETE_NO)
            ->find();
        return $obj ? $obj->toArray() : false;

    }

     //删除
    public function del(array $where)
    {
        return $this->where($where)
            ->update(['is_delete' => DB_ISDELETE_IS]);
    }

    //编辑
    public function edit(array $where = [], array $param)
    {
        $param['update_id'] = get_userinfo('id');
        $param['update_time'] = time();
        return $this->where($where)
            ->update($param);
    }

    //新增
    public function add(array $param)
    {
        $param['create_id'] = get_userinfo('id');
        $param['create_time'] = time();
        $param['update_id'] = get_userinfo('id');
        $param['update_time'] = time();

        return $this->insertGetId($param);
    }


}




