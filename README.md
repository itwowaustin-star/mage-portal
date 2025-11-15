# MAG Laravel Marketing Portal

现代化的 Inertia + Vue 单页应用，用于展示山西马格网络的项目能力、新闻和团队联络。后端基于 Laravel 12，通过第二数据库连接实时读取门户系统（`mg_*` 表）数据，并在前端以 Tailwind CSS 4 的品牌风格渲染。站点包含首页、服务、团队、新闻以及联系表单，并提供受 Fortify 保护的仪表盘入口。

## 功能亮点
- **门户数据直连**：`PortalProject`、`PortalAdvisor` 等模型通过 `portal` 连接读取 `mg_services`、`mg_personal` 等表，保持营销站内容与门户后台同步。
- **定制化首页**：`HomeController` 聚合项目、案例、行业标签、顾问、新闻与 FAQ，并利用 `PortalMedia` 自动拼接图片 URL。
- **联系表单与通知**：`StoreContactRequest` 负责校验，`ContactSubmission` 模型持久化后会通过队列邮件通知 `MAIL_FROM_ADDRESS`。
- **Wayfinder + Inertia**：前端在 `resources/js` 中使用 Vue 3、Wayfinder 类型化路由和 Tailwind v4 构建页面。
- **Pest 测试**：`tests/Feature/MarketingPagesTest.php` 覆盖了首页数据渲染与联系表单入库/邮件流程。

## 技术栈
- PHP 8.4 / Laravel 12 / Fortify / Inertia Laravel 2 / Wayfinder
- Vue 3 + @inertiajs/vue3 2.x + Tailwind CSS 4 + Vite 7
- Pest 4、Laravel Pint、Prettier、ESLint 9
- 默认数据库：SQLite；门户数据可指向 MySQL/MariaDB 等

## 环境要求
- PHP ≥ 8.2（建议 8.4）并启用 `pdo_sqlite`、`pdo_mysql`
- Composer、Node.js ≥ 20、npm
- SQLite（默认）或其他 Laravel 支持的数据库
- 连接门户库所需的 `PORTAL_DB_*`、`PORTAL_MEDIA_*` 环境变量

## 本地启动
1. 克隆代码后安装依赖：
   ```bash
   composer install
   npm install
   ```
2. 复制环境文件并生成应用 key：
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. 根据需要设置数据库：
   - 默认使用 `database/database.sqlite`。
   - 如需 MySQL，请调整 `.env` 中 `DB_*`。
   - 门户数据源必须配置 `PORTAL_DB_*`；若需要本地媒体文件，还可设置 `PORTAL_MEDIA_BASE_URL`、`PORTAL_LOCAL_DISK`、`PORTAL_LOCAL_PATH`。
4. 运行迁移与种子（会创建默认用户 `test@example.com / password` 与 `contact_submissions` 表）：
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```
5. 启动开发环境（包含 PHP 服务器、队列、日志和 Vite）：
   ```bash
   composer run dev
   ```
   如只需前端编译，可单独运行 `npm run dev`（默认监听 `--host 192.168.2.3`，可在 `package.json` 中调整）。

## 常用脚本
| 目标 | 命令 |
| --- | --- |
| 生产构建 | `npm run build` |
| SSR 构建 + 开发 | `npm run build:ssr`、`composer run dev:ssr` |
| 队列/日志单独运行 | `php artisan queue:listen`、`php artisan pail` |
| 生成 Wayfinder 类型 | `php artisan wayfinder:generate` |
| 代码格式化 | `vendor/bin/pint --dirty`、`npm run format`、`npm run lint` |

## 测试
运行所有测试：
```bash
php artisan test
```
Pest 会自动使用 `RefreshDatabase`（默认 SQLite）。`MarketingPagesTest` 中的 `seedPortalData()` 会搭建必须的 `mg_*` 表并写入示例数据，因此无需手动准备门户库即可通过测试。

## 邮件与队列
- 设置 `MAIL_MAILER`、`MAIL_HOST`、`MAIL_USERNAME`、`MAIL_PASSWORD` 以及 `MAIL_FROM_ADDRESS` 后，联系表单提交会入队 `ContactSubmissionReceived` 邮件。
- 在本地可使用 `php artisan queue:listen` 或 Laravel Horizon 等消费者。

## 项目结构速览
- `app/Http/Controllers/*`：营销页控制器，如 `HomeController`、`ServiceController`。
- `app/Models/Portal*`：指向门户库的只读模型。
- `resources/js`：Inertia 页面、布局、组件，Tailwind 4 通过 `@import "tailwindcss";` 在 `resources/css/app.css` 中加载。
- `tests/Feature/MarketingPagesTest.php`：端到端营销流程测试。

## 部署提示
1. 确保门户数据库或 API 可访问，`.env` 中的 `PORTAL_DB_*`、`PORTAL_MEDIA_BASE_URL` 与生产环境一致。
2. 生产构建流程：
   ```bash
   php artisan migrate --force
   npm run build
   php artisan optimize
   ```
3. 队列与计划任务需常驻（队列处理联系邮件，调度器可扩展定时同步逻辑）。

## 故障排查
- **门户图片无法显示**：确认 `storage:link` 已执行，且 `PortalMedia` 指定的本地磁盘存在该文件，否则会回退到 `PORTAL_MEDIA_BASE_URL`。
- **联系邮件未发送**：检查队列是否运行、`MAIL_FROM_ADDRESS` 是否已配置。
- **Vite 找不到资源**：生产环境需要重新执行 `npm run build`，或本地运行 `npm run dev`/`composer run dev`。

欢迎根据企业品牌继续扩展样式与内容，路由更新后记得运行 `php artisan wayfinder:generate` 以同步前端类型。
