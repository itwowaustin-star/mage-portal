<?php

namespace App\Models;

use App\Support\PortalMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PortalProject extends Model
{
    protected $connection = 'portal';

    protected $table = 'mg_services';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'createtime' => 'datetime',
        'updatetime' => 'datetime',
    ];

    public function scopeVisible(Builder $query): Builder
    {
        return $query->whereNull('deletetime');
    }

    protected function slug(): Attribute
    {
        return Attribute::get(function (): string {
            $slugBase = Str::slug((string) $this->title, '-');

            if ($slugBase === '') {
                return (string) $this->getKey();
            }

            return $slugBase.'-'.$this->getKey();
        });
    }

    /**
     * @return Attribute<array<int, string>, never>
     */
    protected function tagList(): Attribute
    {
        return Attribute::get(function (): array {
            return collect(explode(',', (string) $this->tags))
                ->map(fn (string $tag) => trim($tag))
                ->filter()
                ->values()
                ->all();
        });
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => PortalMedia::url($this->image));
    }

    protected function excerpt(): Attribute
    {
        return Attribute::get(function () {
            $source = $this->description ?: $this->content;

            return Str::limit(trim(strip_tags((string) $source)), 120);
        });
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        $query = $this->newQuery()->visible();

        if ($field === 'slug' || $field === null) {
            $id = is_numeric($value) ? (int) $value : (int) Str::afterLast((string) $value, '-');

            return $query->whereKey($id > 0 ? $id : $value)->firstOrFail();
        }

        return parent::resolveRouteBinding($value, $field);
    }
}
