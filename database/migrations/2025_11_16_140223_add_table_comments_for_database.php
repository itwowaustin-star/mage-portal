<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 用户表注释
        DB::statement("ALTER TABLE mg_users COMMENT='系统用户表'");
        DB::statement("ALTER TABLE mg_users MODIFY COLUMN id BIGINT UNSIGNED AUTO_INCREMENT COMMENT '用户ID'");
        DB::statement("ALTER TABLE mg_users MODIFY COLUMN name VARCHAR(255) NOT NULL COMMENT '用户名'");
        DB::statement("ALTER TABLE mg_users MODIFY COLUMN email VARCHAR(255) NOT NULL COMMENT '邮箱地址'");
        DB::statement("ALTER TABLE mg_users MODIFY COLUMN email_verified_at TIMESTAMP NULL COMMENT '邮箱验证时间'");
        DB::statement("ALTER TABLE mg_users MODIFY COLUMN password VARCHAR(255) NOT NULL COMMENT '密码'");
        DB::statement("ALTER TABLE mg_users MODIFY COLUMN two_factor_secret TEXT NULL COMMENT '双因素认证密钥'");
        DB::statement("ALTER TABLE mg_users MODIFY COLUMN two_factor_recovery_codes TEXT NULL COMMENT '双因素认证恢复代码'");
        DB::statement("ALTER TABLE mg_users MODIFY COLUMN two_factor_confirmed_at TIMESTAMP NULL COMMENT '双因素认证确认时间'");
        DB::statement("ALTER TABLE mg_users MODIFY COLUMN remember_token VARCHAR(100) NULL COMMENT '记住登录令牌'");
        DB::statement("ALTER TABLE mg_users MODIFY COLUMN created_at TIMESTAMP NULL COMMENT '创建时间'");
        DB::statement("ALTER TABLE mg_users MODIFY COLUMN updated_at TIMESTAMP NULL COMMENT '更新时间'");

        // 联系表单提交表注释
        DB::statement("ALTER TABLE mg_contact_submissions COMMENT='联系表单提交记录表'");
        DB::statement("ALTER TABLE mg_contact_submissions MODIFY COLUMN id BIGINT UNSIGNED AUTO_INCREMENT COMMENT '提交ID'");
        DB::statement("ALTER TABLE mg_contact_submissions MODIFY COLUMN name VARCHAR(255) NOT NULL COMMENT '联系人姓名'");
        DB::statement("ALTER TABLE mg_contact_submissions MODIFY COLUMN phone VARCHAR(255) NOT NULL COMMENT '联系电话'");
        DB::statement("ALTER TABLE mg_contact_submissions MODIFY COLUMN company VARCHAR(255) NULL COMMENT '公司/单位名称'");
        DB::statement("ALTER TABLE mg_contact_submissions MODIFY COLUMN email VARCHAR(255) NULL COMMENT '电子邮箱'");
        DB::statement("ALTER TABLE mg_contact_submissions MODIFY COLUMN content TEXT NOT NULL COMMENT '需求描述'");
        DB::statement("ALTER TABLE mg_contact_submissions MODIFY COLUMN status VARCHAR(255) NOT NULL DEFAULT 'new' COMMENT '处理状态：new-新提交，processing-处理中，completed-已完成'");
        DB::statement("ALTER TABLE mg_contact_submissions MODIFY COLUMN created_at TIMESTAMP NULL COMMENT '提交时间'");
        DB::statement("ALTER TABLE mg_contact_submissions MODIFY COLUMN updated_at TIMESTAMP NULL COMMENT '更新时间'");

        // 新闻表注释
        DB::statement("ALTER TABLE mg_news COMMENT='新闻文章表'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN id INT UNSIGNED AUTO_INCREMENT COMMENT '新闻ID'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN admin_id INT NOT NULL DEFAULT 0 COMMENT '发布管理员ID'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN category_id INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '新闻分类ID'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN keywords VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'SEO关键词'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN title VARCHAR(50) NOT NULL DEFAULT '' COMMENT '新闻标题'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN content TEXT NOT NULL COMMENT '新闻内容'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN image VARCHAR(100) NOT NULL DEFAULT '' COMMENT '封面图片'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN description VARCHAR(255) NOT NULL DEFAULT '' COMMENT '新闻摘要'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN views INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '浏览次数'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN createtime INT NULL COMMENT '创建时间戳'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN updatetime INT NULL COMMENT '更新时间戳'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN deletetime INT NULL COMMENT '删除时间戳'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN weigh INT NOT NULL DEFAULT 0 COMMENT '排序权重'");
        DB::statement("ALTER TABLE mg_news MODIFY COLUMN status ENUM('normal','hidden') NULL DEFAULT 'normal' COMMENT '状态：normal-正常，hidden-隐藏'");

        // FAQ常见问题表注释
        DB::statement("ALTER TABLE mg_faq COMMENT='常见问题表'");
        DB::statement("ALTER TABLE mg_faq MODIFY COLUMN id INT AUTO_INCREMENT COMMENT '问题ID'");
        DB::statement("ALTER TABLE mg_faq MODIFY COLUMN title VARCHAR(255) NULL COMMENT '问题标题'");
        DB::statement("ALTER TABLE mg_faq MODIFY COLUMN content LONGTEXT NULL COMMENT '问题回答内容'");
        DB::statement("ALTER TABLE mg_faq MODIFY COLUMN isOpen TINYINT NULL DEFAULT 0 COMMENT '是否展开：0-否，1-是'");
        DB::statement("ALTER TABLE mg_faq MODIFY COLUMN createtime INT NULL COMMENT '创建时间戳'");
        DB::statement("ALTER TABLE mg_faq MODIFY COLUMN updatetime INT NULL COMMENT '更新时间戳'");
        DB::statement("ALTER TABLE mg_faq MODIFY COLUMN deletetime INT NULL COMMENT '删除时间戳'");

        // 团队成员表注释
        DB::statement("ALTER TABLE mg_team COMMENT='团队成员表'");
        DB::statement("ALTER TABLE mg_team MODIFY COLUMN id INT AUTO_INCREMENT COMMENT '成员ID'");
        DB::statement("ALTER TABLE mg_team MODIFY COLUMN department_name VARCHAR(255) NOT NULL COMMENT '部门名称'");
        DB::statement("ALTER TABLE mg_team MODIFY COLUMN content TEXT NOT NULL COMMENT '部门介绍'");
        DB::statement("ALTER TABLE mg_team MODIFY COLUMN leader_name VARCHAR(255) NOT NULL COMMENT '负责人姓名'");
        DB::statement("ALTER TABLE mg_team MODIFY COLUMN leader_office VARCHAR(255) NOT NULL COMMENT '负责人职位'");
        DB::statement("ALTER TABLE mg_team MODIFY COLUMN leader_cert VARCHAR(255) NOT NULL COMMENT '负责人资质证书'");
        DB::statement("ALTER TABLE mg_team MODIFY COLUMN tags TEXT NULL COMMENT '擅长领域标签（JSON格式）'");
        DB::statement("ALTER TABLE mg_team MODIFY COLUMN createtime INT NULL COMMENT '创建时间戳'");
        DB::statement("ALTER TABLE mg_team MODIFY COLUMN updatetime INT NULL COMMENT '更新时间戳'");
        DB::statement("ALTER TABLE mg_team MODIFY COLUMN deletetime INT NULL COMMENT '删除时间戳'");

        // Laravel 默认表注释
        DB::statement("ALTER TABLE mg_cache COMMENT='应用缓存表'");
        DB::statement("ALTER TABLE mg_cache_locks COMMENT='缓存锁表'");
        DB::statement("ALTER TABLE mg_failed_jobs COMMENT='失败任务队列表'");
        DB::statement("ALTER TABLE mg_job_batches COMMENT='批量任务表'");
        DB::statement("ALTER TABLE mg_jobs COMMENT='任务队列表'");
        DB::statement("ALTER TABLE mg_migrations COMMENT='数据库迁移记录表'");
        DB::statement("ALTER TABLE mg_password_reset_tokens COMMENT='密码重置令牌表'");
        DB::statement("ALTER TABLE mg_sessions COMMENT='用户会话表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 注释无法轻易回滚，此处留空
        // 如需清除注释，可以使用 ALTER TABLE table_name COMMENT=''
    }
};
