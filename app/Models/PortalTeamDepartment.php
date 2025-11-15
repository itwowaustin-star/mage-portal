<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PortalTeamDepartment extends Model
{
    protected $connection = 'portal';

    protected $table = 'mg_team';

    public $timestamps = false;

    protected $guarded = [];

    public function scopeVisible(Builder $query): Builder
    {
        return $query->whereNull('deletetime');
    }

    protected function summary(): Attribute
    {
        return Attribute::get(function () {
            $plain = trim(strip_tags((string) $this->content));

            return preg_replace('/\s+/', ' ', (string) $plain);
        });
    }

    /**
     * @return Attribute<array<int, string>, never>
     */
    protected function tagList(): Attribute
    {
        return Attribute::get(function () {
            return collect(explode(',', (string) $this->tags))
                ->map(fn (string $tag) => trim($tag))
                ->filter()
                ->values()
                ->all();
        });
    }
}
