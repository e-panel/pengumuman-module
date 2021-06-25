<?php

namespace Modules\Pengumuman\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Pengumuman extends Model
{
    use Sluggable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengumuman';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 
        'judul', 
        'slug', 
        'waktu', 
        'perihal', 
        'id_operator', 
        'lampiran', 
        'komentar', 
        'view'
    ];

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = uuid();
        });
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul'
            ]
        ];
    }
    
    /**
     * @param Builder $query
     * @param $uuid
     * @return Builder
     */
    public function scopeUuid($query, $uuid) 
    {
        return $query->whereUuid($uuid);
    }

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operator() 
    {
        return $this->belongsTo('Modules\Pengguna\Entities\Operator', 'id_operator');
    }
}
