<?php

namespace App\Models;

use App\Traits\CreatedBy;
use App\Traits\Notifiable;
use App\Traits\LogPreference;
use Spatie\Image\Manipulations;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements JWTSubject, HasMedia
{
    use HasFactory, Notifiable, HasRoles, LogPreference, InteractsWithMedia;
    use CreatedBy;
    use SoftDeletes;

    /**
     * The name of the logs to differentiate
     *
     * @var string
     */
    protected $logName = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'created_by',
        'designation_id',
        'department_id',
        'created_by',
        'gender'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean'
    ];



    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // public function divisionHead()
    // {
    //     return $this->belongsTo(Division::class, 'id', 'head_id');
    // }

    // public function departmentHead()
    // {
    //     return $this->belongsTo(Department::class, 'id', 'head_id');
    // }

    // public function userDepartment()
    // {
    //     return $this->belongsTo(Department::class, 'department_id', 'id');
    // }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }


    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id', 'id');
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'user_id', 'id');
    }

    public function setPasswordAttribute($value)
    {
        if (Hash::needsRehash($value)) {
            $value = Hash::make($value);
        }

        $this->attributes['password'] = $value;
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user-avatar')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('avatar')
            ->fit(Manipulations::FIT_CROP, 200, 200)
            ->nonQueued();
    }

    public static function last()
    {
        return static::all()->last();
    }
}
