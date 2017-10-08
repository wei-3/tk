<?php
namespace app\home\validate;
use think\Validate;

class Owner extends Validate{
    protected $rule = [
        ['name', 'require', '业主姓名不能为空'],
        ['tel', 'require|length:11,11', '电话不能为空|电话长度只有11位'],
        ['number', 'require', '房号不能为空'],
        ['cell_name', 'require', '小区名不能为空'],
        ['relationship', 'require', '与业主关系不能为空'],
        ['id_card', 'require', '身份证不能为空'],
        ['status', 'integer'],
    ];
}