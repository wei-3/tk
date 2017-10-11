<?php
namespace app\admin\validate;
use think\Validate;

class Question extends Validate{
    protected $rule = [
        ['name', 'require', '问卷名称不能为空'],
        ['end_time', 'require', '截止时间不能为空'],
        ['status', 'integer'],
    ];
}
