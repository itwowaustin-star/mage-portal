<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $connection = 'portal';

    protected $table = 'mg_news';

    public $timestamps = false;

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'admin_id',
        'category_id',
        'keywords',
        'title',
        'content',
        'image',
        'description',
        'views',
        'createtime',
        'updatetime',
        'deletetime',
        'weigh',
        'status',
    ];

    protected $casts = [
        'createtime' => 'timestamp',
        'updatetime' => 'timestamp',
        'deletetime' => 'timestamp',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'normal')->whereNull('deletetime');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('weigh', 'desc')->orderBy('createtime', 'desc');
    }
}
