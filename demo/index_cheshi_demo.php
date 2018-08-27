<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  index_cheshi_demo.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/15 20:27
 *  文件描述 :  Wx_小程序：执行函数生成类
 *  历史记录 :  -----------------------
 */
include('../library/Function_Create_Library.php');

Function_Create_Library::execCreateFunction([
    // 传值类型 : (GET/POST/PUT/DELETE)
    'dataType' => 'POST',
    // 函数名称 : 默认 __function
    'name'     => 'seckill',
    // 函数说明 : 默认 新创建函数
    'explain'  => '添加秒杀商品',
    // 函数输入 : 示例 [
    //  '$get['goodLimit']  => '商品页码';',
    //]
    'input'    => [
        '$post[\'goood_index\']        => \'商品标识\';',
        '$post[\'json_goods\']         => \'商品数据\';',
        '$post[\'seckill_number\']     => \'秒杀数量\';',
        '$post[\'seckill_price\']      => \'秒杀价格\';',
        '$post[\'seckill_start_time\'] => \'开始时间\';',
        '$post[\'seckill_stop_time\']  => \'结束时间\';',
    ],
]);