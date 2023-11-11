<?php
namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\{HasOne,BelongsTo};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Callcenter extends Authenticatable implements JWTSubject {
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'callcenters';
    protected $fillable = ['name','email','password' ,'phone', 'status', 'password', 'country_id', 'admin_id', 'agent_id'];
    protected $hidden = ['remember_token',];
    protected $casts = ['email_verified_at' => 'datetime','password' => 'hashed',];
    public function profile(): HasOne {
        return $this->hasOne(related:CallcenterProfile::class, foreignKey:'callcenter_id');
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function scopeActive() {
        return $this->whereStatus('active')->get();
    }

    public function country(): BelongsTo {
        return $this->belongsTo(related:Country::class, foreignKey:'country_id');
    }

    public function admin(): BelongsTo {
        return $this->belongsTo(related:Admin::class, foreignKey:'admin_id');
    }

    public function agent(): BelongsTo {
        return $this->belongsTo(related:Agent::class, foreignKey:'agent_id');
    }
}
