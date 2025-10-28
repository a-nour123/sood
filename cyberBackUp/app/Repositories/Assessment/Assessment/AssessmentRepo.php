<?php

namespace App\Repositories\Assessment\Assessment;

use App\Models\Assessment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AssessmentRepo
{
    public static function model(): Model
    {
        return new Assessment();
    }

    public function get_all(array $select = ['*'], array $relation = []): Builder
    {
        return self::model()->with($relation)->select($select);
    }

    public function store($data)
    {
        try {
            self::model()->create($data);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }

    public function update($data, $row)
    {
        try {
            $row->update($data);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
