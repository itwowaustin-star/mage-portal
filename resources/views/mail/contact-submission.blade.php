<x-mail::message>
# 官网收到新的联系表单

**姓名：** {{ $submission->name }}

**电话：** {{ $submission->phone }}

@if($submission->company)
**公司：** {{ $submission->company }}
@endif

@if($submission->email)
**邮箱：** {{ $submission->email }}
@endif

**需求描述：**

{{ $submission->content }}

<x-mail::panel>
该信息来源于 {{ config('app.name') }} 官网的“联系我们”表单，请尽快跟进。
</x-mail::panel>

谢谢，<br>
{{ config('app.name') }}
</x-mail::message>
