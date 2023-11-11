<?php
namespace App\Models\Concerns\Activity;
use App\Models\ImagesActivity;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
trait Activityable {
    public static function bootActivityable() {
        static::updated(function (Model $model) {
            collect($model->getWantedChangedColumns($model))->each(function ($change) use ($model) {
                $model->saveChange($change);
            });
        });
    }
    protected function saveChange(ColumnChange $change) {
        $this->activity()->create([
            'changed_column' => $change->column,
            'change_value_from' => $change->from,
            'change_value_to' => $change->to,
            'admin_id' => auth()->guard('admin')?->id(),
            'call_center_id' => auth()->guard('call-center')?->id(),
        ]);
    }

    protected function getWantedChangedColumns(Model $model) {
        return collect(
            array_diff(Arr::except($model->getChanges(), $this->ignoreActivityColumns()), $original = $model->getOriginal())
        )->map(function ($change, $column) use ($original) {
            return new ColumnChange($column, Arr::get($original, $column), $change);
        });
    }


    public function activity() {
        return $this->morphMany(ImagesActivity::class, 'activitieable')->latest();
    }

    public function ignoreActivityColumns() {
        return 'updated_at';
    }
}
