<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $connection = 'portal';

    protected $table = 'mg_faq';

    public $timestamps = false;

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'title',
        'content',
        'isOpen',
        'createtime',
        'updatetime',
        'deletetime',
    ];

    protected $casts = [
        'createtime' => 'timestamp',
        'updatetime' => 'timestamp',
        'deletetime' => 'timestamp',
    ];

    public function scopeActive($query)
    {
        return $query->whereNull('deletetime')->where('isOpen', 1);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('createtime', 'desc');
    }
}
