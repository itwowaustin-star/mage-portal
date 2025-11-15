<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PortalAdvisor extends Model
{
    protected $connection = 'portal';

    protected $table = 'mg_personal';

    public $timestamps = false;

    protected $guarded = [];

    public function scopeVisible(Builder $query): Builder
    {
        return $query->whereNull('deletetime');
    }

    protected function expertise(): Attribute
    {
        return Attribute::get(function () {
            $plain = trim(strip_tags((string) $this->content));

            return preg_replace('/\s+/', ' ', (string) $plain);
        });
    }
}
