<?php
namespace app\admin\validate;
use think\Validate;

class Sale extends Validate{
    protected $rule = [
        ['tel', 'require|length:11,11', '电话不能为空|电话长度只有11位'],
        ['title', 'require', '标题不能为空'],
        ['type', 'require', '类型不能为空'],
        ['price', 'require', '价格不能为空'],
        ['content', 'require', '内容不能为空'],
        ['end_time', 'require', '截止时间不能为空'],
        ['status', 'integer'],
    ];
}
