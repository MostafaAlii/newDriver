<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Models\Concerns\Activity\Activityable;
class Image extends Model {
    use Activityable;
    protected $fillable = [
        'filename',
        'type',
        'photo_status',
        'photo_type',
        'reject_reson',
        'imageable_type',
        'imageable_id',
    ];
    public $timestamps = false;
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
    public function captainProfile() {
        return $this->belongsTo(CaptainProfile::class, 'imageable_id');
    }
}
