## Context Summary

- The application now connects to the remote FastAdmin database via a dedicated `portal` connection (`config/database.php`) that pulls real project, service, advisor, and department records using the new models `PortalProject`, `PortalAdvisor`, and `PortalTeamDepartment`.
- A new support class `App\Support\PortalMedia` and Artisan command `php artisan portal:cache-media` sync `/uploads/...` assets into `storage/app/public/portal-media`, so the frontend can use local copies; configure the base URL through `PORTAL_MEDIA_BASE_URL` (currently `https://mag.sxmgwl.com`).
- All marketing Inertia pages (`Home`, `Services`, `Team`, `Contact`, `About`) plus the `MarketingLayout`使用统一浅色主题并渲染实时数据，不再提及 “mg_portal/FastAdmin”。
- `/cases` 路由与页面已移除，所有项目展示都通过 `/services` 完成，Home 页仍展示精选卡片并链接到对应服务详情。
- 默认数据库连接允许通过 `DB_TABLE_PREFIX`（示例为 `mg_`）为所有 Laravel 管理的表添加统一前缀；portal 连接不受影响。
- 首页新增 “安全资质” 区块，通过 `/安全集成.png` 与 `/安全运维.png` 两张图片突出展示官方认证，位置位于 hero 区块之后。
- 资质区块现改用 `/security-integration.png`、`/security-operations.png` 两张大尺寸图片，并在文案中点明对应的 CCRC 安全集成/安全运维资质。
- 首页的“高光项目图集”只展示带图片的服务条目，无图项目会提示稍后再来；原“同源数据下的案例视图”区块已删除。
- 公司对外地址统一为“山西省朔州市开发区恒晟大厦 1204/1304/1703”，页脚和联系页面均已更新，并展示备案号“晋ICP备2023002392号-1”。
- 首页安全资质图片改成更大尺寸的无边框画廊，页头品牌区使用了 `/public/logo.png` Logo。
- `npm run dev` 脚本现在执行 `vite --host 0.0.0.0`，方便监听所有地址。
- 首页与 Services 页已替换为“科技红”夜色 UI，突出网络安全与软件研发场景；布局包含红黑渐变 hero、项目图集和卡片式服务列表。
- To keep tests independent of a real Vite build, `resources/views/app.blade.php` now only loads `resources/js/app.ts`, and `public/build` contains a minimal fake manifest and placeholder asset.
- `tests/Feature/MarketingPagesTest.php` seeds an in-memory “portal” sqlite schema so the homepage and contact form can be verified without touching the remote database.
