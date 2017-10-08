<?php
namespace app\admin\validate;
use think\Validate;

class Active extends Validate{
    protected $rule = [
        ['name', 'require', '申请人不能为空'],
        ['active_name', 'require', '活动名称不能为空'],
        ['active_intro', 'require', '活动描述不能为空'],
        ['end_time', 'require', '结束时间不能为空'],
        ['application_time', 'require', '申请时间不能为空'],
        ['status', 'integer'],
    ];
}