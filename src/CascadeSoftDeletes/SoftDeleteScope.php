<?php

namespace Awais\CascadeSoftDeletes\CascadeSoftDeletes;

use Awais\CascadeSoftDeletes\Helper\SoftDeleteables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;

class SoftDeleteScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $table = $model->getTable();
        if (Schema::hasColumn($table, 'deleted_at') && in_array($table, SoftDeleteables::$tables)) {
            $builder->whereNull($table . '.deleted_at');
        }
    }
}
