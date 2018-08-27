<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  Function_Create_Library.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/17 10:19
 *  文件描述 :  Wx_小程序：执行函数生成类
 *  历史记录 :  -----------------------
 */
class Function_Create_Library
{
    /**
     * 名 称 : $FunctionConfig
     * 功 能 : 函数生成配置信息
     * 创 建 : 2018/08/17 10:20
     */
    private static $FunctionConfig = array(

        // 传值类型 : (GET/POST/PUT/DELETE)
        'dataType' => '传值类型',

        // 函数名称 : 默认 __function
        'name'     => '__function',

        // 函数说明 : 默认 新创建函数
        'explain'  => '新创建函数',

        // 函数输入 : 示例 [
        //  '(String) $name => "名字"',
        //  '(String) $name => "名字"'
        //]
        'input'    => array(),

    );

    /**
     * 名 称 : __construct()
     * 功 能 : 定义配置信息数据
     * 创 建 : 2018/08/17 10:20
     */
    private function __construct()
    {
        // TODO: 禁止外部实例化
    }

    /**
     * 名 称 : __clone()
     * 功 能 : 禁止外部克隆该实例
     * 创 建 : 2018/08/17 10:20
     */
    private function __clone()
    {
        // TODO: 禁止外部克隆该实例
    }

    /**
     * 名 称 : execCreateFunction()
     * 功 能 : 执行创建模块功能
     * 创 建 : 2018/08/17 10:21
     */
    public static function execCreateFunction($FunctionConfig)
    {
        // 1. 设置时间为中国标准时区
        date_default_timezone_set('PRC');

        // 2. 验证传值内容是否正确
        self::inputValidate($FunctionConfig);

        // 3. Route 生成路由文件
        $String = self::RouteCreate($FunctionConfig);

        // 4. Controller 执行生成控制器代码
        $String.= self::controllerCreate($FunctionConfig);

        // 6. Service 执行生成逻辑函数代码
        $String.= self::serviceCreate($FunctionConfig);

        // 5. Library 执行生成自定义类代码
        $String.= self::libraryCreate($FunctionConfig);

        // 7. Interface 执行生成Dao层接口代码
        $String.= self::interfaceCreate($FunctionConfig);

        // 8. Dao 执行生成Dao层数据代码
        $String.= self::daoCreate($FunctionConfig);

        // 9. FilePut 处理信息成为文件
        file_put_contents('./Module_Code.php',$String);

        // 10. Print_r 打印数据
        print_r('Function_Create_Success');
    }

    /**
     * 名 称 : inputValidate()
     * 功 能 : 验证传值内容是否正确
     * 创 建 : 2018/08/17 11:03
     */
    private static function inputValidate($FunctionConfig)
    {
        // 判断配置信息是否存在
        if(empty($FunctionConfig)){
            print_r('请发送配置数组，数据与属性配置一样'); exit;
        }

        // 判断传值状态是否存在
        if(empty($FunctionConfig['dataType'])){
            print_r('请发送传值状态，参考类属性发送状态'); exit;
        }

        // 将传值状态转化成大写
        $dataType = strtoupper($FunctionConfig['dataType']);
        // 判断传值状态是否正确
        if(
            ($dataType!=='GET') &&
            ($dataType!=='POST')&&
            ($dataType!=='PUT') &&
            ($dataType!=='DELETE')
        ){
            print_r('传值类型不存在'); exit;
        }

        // 判断函数名称是否存在
        if(empty($FunctionConfig['name'])){
            print_r('请输入函数名称'); exit;
        }

        // 判断请输入函数说明是否存在
        if(empty($FunctionConfig['explain'])){
            print_r('请输入函数说明'); exit;
        }

        // 判断请输入函数说输入是否存在
        if(!is_array($FunctionConfig['input'])){
            print_r('请正确写入输入，没有输入发送空数组'); exit;
        }
    }

    /**
     * 名 称 : RouteCreate()
     * 功 能 : 执行生成路由文件代码
     * 创 建 : 2018/08/20 14:13
     */
    private static function RouteCreate($FunctionConfig)
    {
        // 将传值状态转化成小写
        $dataTypeL = strtolower($FunctionConfig['dataType']);
        $DataTypeL = ucfirst($dataTypeL);
        // 将传值状态转化成大写
        $dataTypeU = strtoupper($FunctionConfig['dataType']);
        // 获取名字
        $name =  $FunctionConfig['name'];
        $Name =  ucfirst($FunctionConfig['name']);
        // 处理标题信息
        $String = "
// ------ Route路由代码 ------
";
        // 处理内容
        $String.= "
/**
 * 传值方式 : {$dataTypeU}
 * 路由功能 : {$FunctionConfig['explain']}
 */
Route::{$dataTypeL}(
    ':v/{$name}_module/{$name}_route',
    '{$name}_module/:v.controller.{$Name}Controller/{$name}{$DataTypeL}'
);
";
    return $String;
    }

    /**
     * 名 称 : controllerCreate()
     * 功 能 : 执行生成控制器代码
     * 创 建 : 2018/08/17 10:24
     */
    private static function controllerCreate($FunctionConfig)
    {
        // 将传值状态转化成小写
        $dataType = strtolower($FunctionConfig['dataType']);
        // 处理输出
        if($dataType == 'get'){
            $tishixinxi = '请求成功';
            $output = '{"errNum":0,"retMsg":"请求成功","retData":"请求数据"}';
        }else{
            $tishixinxi = '';
            $output = '{"errNum":0,"retMsg":"提示信息","retData":true}';
        }
        // 处理名字
        $name = $FunctionConfig['name'].ucfirst($dataType);
        // 处理明细
        if($dataType == 'get')   {$names = 'Show';}
        if($dataType == 'post')  {$names = 'Add'; }
        if($dataType == 'put')   {$names = 'Edit';}
        if($dataType == 'delete'){$names = 'Del'; }
        // 处理标题信息
        $String = "
// ------ Controller控制器接代码 ------
";
        // 处理控制器注释信息
        $String.= self::notesCreate(
            $name,
            $FunctionConfig['explain'].'接口',
            $FunctionConfig['input'],
            $output
        );
        // 处理内容
        $String.= "
public function {$name}(\\think\\Request \$request)
{
    // 实例化Service层逻辑类
    \$".$FunctionConfig['name']."Service = new ".ucfirst($FunctionConfig['name'])."Service();
    
    // 获取传入参数
    \${$dataType} = \$request->{$dataType}();
    
    // 执行Service逻辑
    \$res = \$".$FunctionConfig['name'].'Service->'.$FunctionConfig['name'].$names."(\${$dataType});
    
    // 处理函数返回值
    return \\RSD::wxReponse(\$res,'S','".$tishixinxi."');
}
";
        // 返回数据
        return $String;
    }

    /**
     * 名 称 : libraryCreate()
     * 功 能 : 执行生成自定义类代码
     * 创 建 : 2018/08/17 10:25
     */
    private static function libraryCreate($FunctionConfig)
    {
        // 将传值状态转化成小写
        $dataType = strtolower($FunctionConfig['dataType']);
        // 处理输出
        if($dataType == 'get'){
            $output = "['msg'=>'success','data'=>'返回数据']";
        }else{
            $output = "['msg'=>'success','data'=>'提示信息']";
        }
        // 处理名字
        $name = $FunctionConfig['name'].'Lib'.ucfirst($dataType);
        // 处理标题信息
        $String = "
// ------ Library函数类代码 ------
";
        // 处理自定义类注释信息
        $String.= self::notesCreate(
            $name,
            $FunctionConfig['explain'].'函数类',
            $FunctionConfig['input'],
            $output
        );
        // 处理内容
        $String.= "
public function {$name}(\${$dataType})
{
    // TODO : 执行函数处理逻辑
    
    // TODO : 返回函数输出数据
    return ['msg'=>'success','data'=>'返回数据'];
}
";
        // 返回数据
        return $String;
    }

    /**
     * 名 称 : serviceCreate()
     * 功 能 : 执行生成逻辑函数代码
     * 创 建 : 2018/08/17 10:25
     */
    private static function serviceCreate($FunctionConfig)
    {
        // 将传值状态转化成小写
        $dataType = strtolower($FunctionConfig['dataType']);
        // 处理输出
        if($dataType == 'get'){
            $output = "['msg'=>'success','data'=>'返回数据']";
        }else{
            $output = "['msg'=>'success','data'=>'提示信息']";
        }
        // 处理明细
        if($dataType == 'get')   {$names = 'Show';$namen = 'Select';}
        if($dataType == 'post')  {$names = 'Add'; $namen = 'Create';}
        if($dataType == 'put')   {$names = 'Edit';$namen = 'Update';}
        if($dataType == 'delete'){$names = 'Del'; $namen = 'Delete';}
        // 处理名字
        $name = $FunctionConfig['name'].$names;
        // 处理标题信息
        $String = "
// ------ Service逻辑层代码 ------
";
        // 处理自定义类注释信息
        $String.= self::notesCreate(
            $name,
            $FunctionConfig['explain'].'逻辑',
            $FunctionConfig['input'],
            $output
        );
        // 处理内容
        $String.= "
public function {$name}(\${$dataType})
{
    // 实例化验证器代码
    \$validate  = new ".ucfirst($FunctionConfig['name'])."Validate();
    
    // 验证数据
    if (!\$validate->scene('edit')->check(\${$dataType})) {
        return ['msg'=>'error','data'=>\$validate->getError()];
    }
    
    // 实例化Dao层数据类
    \${$FunctionConfig['name']}Dao = new ".ucfirst($FunctionConfig['name'])."Dao();
    
    // 执行Dao层逻辑
    \$res = \$".$FunctionConfig['name'].'Dao->'.$FunctionConfig['name'].$namen."(\${$dataType});
    
    // 处理函数返回值
    return \\RSD::wxReponse(\$res,'D');
}
";
        // 返回数据
        return $String;
    }

    /**
     * 名 称 : interfaceCreate()
     * 功 能 : 执行生成Dao层接口代码
     * 创 建 : 2018/08/17 10:26
     */
    private static function interfaceCreate($FunctionConfig)
    {
        // 将传值状态转化成小写
        $dataType = strtolower($FunctionConfig['dataType']);
        // 处理输出
        if($dataType == 'get'){
            $output = "['msg'=>'success','data'=>'返回数据']";
        }else{
            $output = "['msg'=>'success','data'=>'提示信息']";
        }
        // 处理明细
        if($dataType == 'get')   {$names = 'Select';}
        if($dataType == 'post')  {$names = 'Create'; }
        if($dataType == 'put')   {$names = 'Update';}
        if($dataType == 'delete'){$names = 'Delete'; }
        // 处理名字
        $name = $FunctionConfig['name'].$names;
        // 处理标题信息
        $String = "
// ------ Interface接口代码 ------
";
        // 处理自定义类注释信息
        $String.= self::notesCreate(
            $name,
            '声明:'.$FunctionConfig['explain'].'数据处理',
            $FunctionConfig['input'],
            $output
        );
        // 处理内容
        $String.= "
public function {$name}(\${$dataType});
";
        // 返回数据
        return $String;
    }

    /**
     * 名 称 : daoCreate()
     * 功 能 : 执行生成Dao层接口代码
     * 创 建 : 2018/08/17 10:26
     */
    private static function daoCreate($FunctionConfig)
    {
        // 将传值状态转化成小写
        $dataType = strtolower($FunctionConfig['dataType']);
        // 处理输出
        if($dataType == 'get'){
            $output = "['msg'=>'success','data'=>'返回数据']";
        }else{
            $output = "['msg'=>'success','data'=>'提示信息']";
        }
        // 处理明细
        if($dataType == 'get')   {$names = 'Select';}
        if($dataType == 'post')  {$names = 'Create'; }
        if($dataType == 'put')   {$names = 'Update';}
        if($dataType == 'delete'){$names = 'Delete'; }
        // 处理名字
        $name = $FunctionConfig['name'].$names;
        // 处理标题信息
        $String = "
// ------ Dao数据层代码 ------
";
        // 处理自定义类注释信息
        $String.= self::notesCreate(
            $name,
            $FunctionConfig['explain'].'数据处理',
            $FunctionConfig['input'],
            $output
        );
        // 处理内容
        $String.= "
public function {$name}(\${$dataType})
{
    // TODO :  ".ucfirst($FunctionConfig['name'])."Model 模型
}
";
        // 返回数据
        return $String;
    }

    /**
     * 名 称 : notesCreate()
     * 功 能 : 执行代码注释函数
     * 创 建 : 2018/08/17 10:26
     */
    private static function notesCreate($name,$explain,$input,$output)
    {
        // 处理注释信息
        $String = "
/**
 * 名  称 : {$name}()
 * 功  能 : {$explain}
 * 变  量 : --------------------------------------";
        // 处理注释输入
        if(!empty($input)){
            foreach ($input as $v)
            {
                $String.= "
 * 输  入 : {$v}";
            }
        }else{
            $String.= "
 * 输  入 : --------------------------------------";
        }
            $String.= "
 * 输  出 : {$output}
 * 创  建 : ".date('Y/m/d H:i',time())."
 */";
        // 返回最终处理成功注释
        return $String;

    }
}