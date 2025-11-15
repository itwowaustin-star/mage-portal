<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CachePortalMedia extends Command
{
    protected $signature = 'portal:cache-media {--force : Re-download files even if they already exist locally}';

    protected $description = 'Download remote media referenced in the portal database into local storage';

    /**
     * @var array<string, string[]>
     */
    protected array $tableColumns = [
        'mg_services' => ['image', 'content', 'description'],
        'mg_banner' => ['image'],
        'mg_news' => ['image', 'content', 'description'],
        'mg_attachment' => ['url'],
        'mg_personal' => ['content'],
        'mg_team' => ['content'],
    ];

    public function handle(): int
    {
        $baseUrl = rtrim((string) config('portal.media_base_url'), '/');

        if ($baseUrl === '') {
            $this->error('portal.media_base_url is not configured.');

            return self::FAILURE;
        }

        $paths = $this->collectMediaPaths();

        if ($paths->isEmpty()) {
            $this->components->info('未找到需要同步的图片或附件。');

            return self::SUCCESS;
        }

        $disk = config('portal.local_disk', 'public');
        $prefix = trim((string) config('portal.local_path_prefix', 'portal-media'), '/');
        $force = $this->option('force');
        $downloaded = 0;

        $this->components->info('开始同步 '.$paths->count().' 个资源文件。');

        foreach ($paths as $path) {
            $targetPath = $prefix.'/'.ltrim($path, '/');

            if (! $force && Storage::disk($disk)->exists($targetPath)) {
                continue;
            }

            $url = $baseUrl.'/'.ltrim($path, '/');

            try {
                $response = Http::timeout(60)->get($url);

                if (! $response->successful()) {
                    $this->components->warn("下载失败：{$url} ({$response->status()})");

                    continue;
                }

                Storage::disk($disk)->put($targetPath, $response->body());
                $downloaded++;
            } catch (Exception $exception) {
                $this->components->warn("下载失败：{$url} ({$exception->getMessage()})");
            }
        }

        $this->components->info("同步完成，本地新增 {$downloaded} 个文件。");

        return self::SUCCESS;
    }

    protected function collectMediaPaths(): Collection
    {
        $paths = collect();
        $connection = DB::connection('portal');

        foreach ($this->tableColumns as $table => $columns) {
            $connection->table($table)
                ->orderBy('id')
                ->chunkById(200, function ($rows) use (&$paths, $columns) {
                    foreach ($rows as $row) {
                        foreach ($columns as $column) {
                            $paths = $paths->merge($this->extractUploads($row->{$column} ?? null));
                        }
                    }
                });
        }

        return $paths->unique()->values();
    }

    /**
     * @return array<int, string>
     */
    protected function extractUploads(mixed $value): array
    {
        if (! is_string($value) || ! str_contains($value, '/uploads/')) {
            return [];
        }

        preg_match_all('#/uploads/[A-Za-z0-9/_\.\-]+#', $value, $matches);

        return collect($matches[0] ?? [])
            ->map(fn (string $path) => '/'.ltrim($path, '/'))
            ->filter(fn (string $path) => Str::startsWith($path, '/uploads/'))
            ->values()
            ->all();
    }
}
