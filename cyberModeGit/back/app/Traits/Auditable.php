<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    // public static function bootAuditable()
    // {

    //     static::created(function (Model $model) {
    //         self::audit('created', $model);
    //     });

    //     static::updating(function (Model $model) {
    //         $model->attributes = array_merge($model->getChanges(), ['id' => $model->id]);

    //         self::audit('updated', $model);
    //     });

    //     static::deleting(function (Model $model) {
    //         // dd("dfshhfhd");
    //         // dd("dsjhjdfhhjfd");
    //         self::audit('deleted', $model);
    //     });
    // }

    // public static function logs()
    // {
    //     return AuditLog::where('subject_type', self::class)->get();
    // }
    // public static function itemLogs($id)
    // {
    //     return AuditLog::where(['subject_type'=> self::class,'subject_id'=>$id])->get();
    // }

    // protected static function audit($description, $model)
    // {
    //     AuditLog::create([
    //         'description'  => $description,
    //         'subject_id'   => $model->id ?? null,
    //         'subject_type' => sprintf('%s%s', get_class($model), '') ?? null,
    //         'user_id'      => 1,//auth()->id() ?? null,
    //         'properties'   => $model ?? null,
    //         'host'         => request()->ip() ?? null,
    //     ]);
    // }
}
