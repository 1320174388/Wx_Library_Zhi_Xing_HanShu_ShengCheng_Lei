
// ------ Route路由代码 ------

/**
 * 传值方式 : POST
 * 路由功能 : 添加秒杀商品
 */
Route::post(
    ':v/seckill_module/seckill_route',
    'seckill_module/:v.controller.SeckillController/seckillPost'
);

// ------ Controller控制器接代码 ------

/**
 * 名  称 : seckillPost()
 * 功  能 : 添加秒杀商品接口
 * 变  量 : --------------------------------------
 * 输  入 : $post['goood_index']        => '商品标识';
 * 输  入 : $post['json_goods']         => '商品数据';
 * 输  入 : $post['seckill_number']     => '秒杀数量';
 * 输  入 : $post['seckill_price']      => '秒杀价格';
 * 输  入 : $post['seckill_start_time'] => '开始时间';
 * 输  入 : $post['seckill_stop_time']  => '结束时间';
 * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
 * 创  建 : 2018/08/27 21:16
 */
public function seckillPost(\think\Request $request)
{
    // 实例化Service层逻辑类
    $seckillService = new SeckillService();
    
    // 获取传入参数
    $post = $request->post();
    
    // 执行Service逻辑
    $res = $seckillService->seckillAdd($post);
    
    // 处理函数返回值
    return \RSD::wxReponse($res,'S','');
}

// ------ Service逻辑层代码 ------

/**
 * 名  称 : seckillAdd()
 * 功  能 : 添加秒杀商品逻辑
 * 变  量 : --------------------------------------
 * 输  入 : $post['goood_index']        => '商品标识';
 * 输  入 : $post['json_goods']         => '商品数据';
 * 输  入 : $post['seckill_number']     => '秒杀数量';
 * 输  入 : $post['seckill_price']      => '秒杀价格';
 * 输  入 : $post['seckill_start_time'] => '开始时间';
 * 输  入 : $post['seckill_stop_time']  => '结束时间';
 * 输  出 : ['msg'=>'success','data'=>'提示信息']
 * 创  建 : 2018/08/27 21:16
 */
public function seckillAdd($post)
{
    // 实例化验证器代码
    $validate  = new SeckillValidate();
    
    // 验证数据
    if (!$validate->scene('edit')->check($post)) {
        return ['msg'=>'error','data'=>$validate->getError()];
    }
    
    // 实例化Dao层数据类
    $seckillDao = new SeckillDao();
    
    // 执行Dao层逻辑
    $res = $seckillDao->seckillCreate($post);
    
    // 处理函数返回值
    return \RSD::wxReponse($res,'D');
}

// ------ Library函数类代码 ------

/**
 * 名  称 : seckillLibPost()
 * 功  能 : 添加秒杀商品函数类
 * 变  量 : --------------------------------------
 * 输  入 : $post['goood_index']        => '商品标识';
 * 输  入 : $post['json_goods']         => '商品数据';
 * 输  入 : $post['seckill_number']     => '秒杀数量';
 * 输  入 : $post['seckill_price']      => '秒杀价格';
 * 输  入 : $post['seckill_start_time'] => '开始时间';
 * 输  入 : $post['seckill_stop_time']  => '结束时间';
 * 输  出 : ['msg'=>'success','data'=>'提示信息']
 * 创  建 : 2018/08/27 21:16
 */
public function seckillLibPost($post)
{
    // TODO : 执行函数处理逻辑
    
    // TODO : 返回函数输出数据
    return ['msg'=>'success','data'=>'返回数据'];
}

// ------ Interface接口代码 ------

/**
 * 名  称 : seckillCreate()
 * 功  能 : 声明:添加秒杀商品数据处理
 * 变  量 : --------------------------------------
 * 输  入 : $post['goood_index']        => '商品标识';
 * 输  入 : $post['json_goods']         => '商品数据';
 * 输  入 : $post['seckill_number']     => '秒杀数量';
 * 输  入 : $post['seckill_price']      => '秒杀价格';
 * 输  入 : $post['seckill_start_time'] => '开始时间';
 * 输  入 : $post['seckill_stop_time']  => '结束时间';
 * 输  出 : ['msg'=>'success','data'=>'提示信息']
 * 创  建 : 2018/08/27 21:16
 */
public function seckillCreate($post);

// ------ Dao数据层代码 ------

/**
 * 名  称 : seckillCreate()
 * 功  能 : 添加秒杀商品数据处理
 * 变  量 : --------------------------------------
 * 输  入 : $post['goood_index']        => '商品标识';
 * 输  入 : $post['json_goods']         => '商品数据';
 * 输  入 : $post['seckill_number']     => '秒杀数量';
 * 输  入 : $post['seckill_price']      => '秒杀价格';
 * 输  入 : $post['seckill_start_time'] => '开始时间';
 * 输  入 : $post['seckill_stop_time']  => '结束时间';
 * 输  出 : ['msg'=>'success','data'=>'提示信息']
 * 创  建 : 2018/08/27 21:16
 */
public function seckillCreate($post)
{
    // TODO :  SeckillModel 模型
}
