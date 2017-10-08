<?php
namespace app\admin\validate;
use think\Validate;

class Property extends Validate{
    protected $rule = [
        ['name', 'require', '报修人不能为空'],
        ['tel', 'require|length:11,11', '电话不能为空|电话长度只有11位'],
        ['address', 'require', '地址不能为空'],
        ['problem', 'require', '问题不能为空'],
        ['content', 'require', '内容不能为空'],
        ['status', 'integer'],
    ];
}