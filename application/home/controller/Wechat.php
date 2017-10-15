<?php
namespace app\home\controller;
use app\home\model\Document;
use app\home\model\Picture;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
use think\Controller;
use EasyWeChat\Foundation\Application;
class Wechat extends Controller{
    private $_AK='1vqu6ICNqwH3p1LqYMQqb2t6KFumwirz';
    private  $_options= [
        /**
         * Debug 模式，bool 值：true/false
         *
         * 当值为 false 时，所有的日志都不会记录
         */
        'debug'  => true,
        /**
         * 账号基本信息，请从微信公众平台/开放平台获取
         */
        'app_id'  => 'wxd703ca71f678d238',         // AppID
        'secret'  => '5fad2d333bf058b0206abcc9c31cffc7',     // AppSecret
        'token'   => 'wei',          // Token
        'aes_key' => '',                    // EncodingAESKey，安全模式下请一定要填写！！！
        /**
         * 日志配置
         *
         * level: 日志级别, 可选为：
         *         debug/info/notice/warning/error/critical/alert/emergency
         * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
         * file：日志文件位置(绝对路径!!!)，要求可写权限
         */
        'log' => [
            'level'      => 'debug',
            'permission' => 0777,
            'file'       => '/www/wwwroot/thinkphp/runtime/log/easywechat.log',
        ],
        /**
         * OAuth 配置
         *
         * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
         * callback：OAuth授权完成后的回调页地址
         */
        'oauth' => [
            'scopes'   => ['snsapi_userinfo'],
            'callback' => '/examples/oauth_callback.php',
        ],
        /**
         * 微信支付
         */
        'payment' => [
            'merchant_id'        => 'your-mch-id',
            'key'                => 'key-for-signature',
            'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
            'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！
            // 'device_info'     => '013467007045764',
            // 'sub_app_id'      => '',
            // 'sub_merchant_id' => '',
            // ...
        ],
        /**
         * Guzzle 全局设置
         *
         * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
         */
        'guzzle' => [
            'timeout' => 3.0, // 超时时间（秒）
            'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
        ],
    ];
    public function index(){
        // ...
        $app = new Application($this->_options);
        // 从项目实例中得到服务端应用实例。
        $server = $app->server;
        //消息处理
        $server->setMessageHandler(function ($message) {
            $redis=new \Redis();
            $redis->connect('127.0.0.1');
            switch ($message->MsgType) {
                case 'event':
                    //关注 取消关注  点击菜单
                    switch ($message->Event) {
                        case 'subscribe':
                            # code...
                            break;
                        case 'CLICK'://点击菜单
                            if($message->EventKey == 'V1001_GOOD'){
                                $articles=[];
                                $list=Document::where('category_id','46')->limit(5)->order('create_time','desc')->select();
                                foreach($list as $k=>$v){
                                    $pic=Picture::get(['id'=>$v->cover_id]);
                                    $news= new News([
                                        'title'       =>$v->title,
                                        'description' =>$v->description,
                                        'url'         => 'http://tk.wwei3.top/home/active/detail/id/'.$v->id.'html',
                                        'image'       => 'http://tk.wwei3.top/public'.$pic->path,
                                    ]);
                                    $articles[]=$news;
                                }
                                return $articles;
                            }elseif ($message->EventKey == 'b'){
                                //...
                            }
                            return '你点击了'.$message->EventKey;
                            break;
                        default:
                            # code...
                            break;
                    }
                    break;
                case 'text':
                    if($message->Content=='消息'){
                        $articles=[];
                        $list=Document::where('category_id','44')->limit(5)->order('create_time','desc')->select();
                        foreach($list as $k=>$v){
                            $pic=Picture::get(['id'=>$v->cover_id]);
                            $news= new News([
                                'title'       =>$v->title,
                                'description' =>$v->description,
                                'url'         => 'http://tk.wwei3.top/home/active/detail/id/'.$v->id.'html',
                                'image'       => 'http://tk.wwei3.top/'.$pic->path,
                            ]);
                            $articles[]=$news;
                        }
                        return $articles;
                    }elseif ($message->Content=='帮助'){
                        return '您可以发送关键字 消息 解除绑定';
                    }
                    $location=$redis->get('location_'.$message->FromUserName);
                    if($location===false){
                        return '请发位置信息，才能查询该地区';
                    }else{
                        if(strstr($message->Content,"搜索")){
                            $content=mb_substr( $message->Content,2);
                            $articles=[];
                            $url="http://api.map.baidu.com/place/v2/search?query={$content}&page_size=4&page_num=0&scope=2&location={$location}&radius=3000&output=xml&ak=".$this->_AK;
                            $xml=simplexml_load_file($url);
                            $results=$xml->results;
                            if(count($results->result)==0){
                                $message->Content='没有查询到结果'.$content;
                            }
                            foreach ($results->result as $result){
                                $news= new News([
                                    'title'       =>(string)$result->name,
                                    'description' => '',
                                    'url'         => '',
                                    'image'       => '',
                                ]);
                                $articles[]=$news;
                            }
                            return $articles;
                        }else{
                            return '该搜索方式不正确，例如：搜索火锅';
                        }
                    }
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    $redis->set('location_'.$message->FromUserName,$message->Location_X.','.$message->Location_Y);
                    return '位置已输入，请输入关键字';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
            // ...
        });
        $response = $server->serve();
        $response->send(); // Laravel 里请使用：return $response;
    }
    public function setMenu(){
        $app = new Application($this->_options);
        $menu = $app->menu;
        $buttons = [
            [
                "type" => "view",
                "name" => "个人中心",
                "url"  => "http://tk.wwei3.top/home/property/index.html"
            ],
            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",//点击跳转 相当于a标签
                        "name" => "首页",
                        "url"  => "http://tk.wwei3.top/home/index/index.html"
                    ],
                    [
                        "type" => "view",
                        "name" => "服务",
                        "url"  => "http://tk.wwei3.top/home/service/list_index.html"
                    ],
                    [
                        "type" => "view",
                        "name" => "发现",
                        "url"  => "http://tk.wwei3.top/home/property/find.html"
                    ],
                    [
                        "type" => "click",
                        "name" => "活动",
                        "key" => "V1001_GOOD"
                    ],
                ],
            ],
            [
                "name"       => "导航",
                "sub_button" => [
                    [
                        "type" => "view",//点击跳转 相当于a标签
                        "name" => "小区通知",
                        "url"  => "http://tk.wwei3.top/home/notice/notice.html"
                    ],
                    [
                        "type" => "view",
                        "name" => "便民服务",
                        "url"  => "http://tk.wwei3.top/home/service/service.html"
                    ],
                    [
                        "type" => "view",
                        "name" => "在线报修",
                        "url"  => "http://tk.wwei3.top/home/property/property.html"
                    ],
                    [
                        "type" => "view",
                        "name" => "小区租售",
                        "url"  => "http://tk.wwei3.top/home/sale/index.html"
                    ],
                ],
            ],
        ];
        $menu->add($buttons);
        echo '设置菜单成功';
    }
    //获取菜单
    public function getMenu(){
        $app = new Application($this->_options);
        $menu = $app->menu;
        $menus = $menu->all();
        var_dump($menus);
    }
    public function test(){
//        $len=mb_substr( '搜索火锅', 2) ;
//        $len=strstr("搜索火锅","搜索");
//        if(strstr("搜索火锅","搜索")){
//            var_dump($len);
//        }
        $list=Document::where('category_id','46')->limit(5)->order('create_time','desc')->select();
//        var_dump($list);
        foreach($list as $k=>$v){
            $pic=Picture::get(['id'=>$v->cover_id]);

           echo $pic->path;
        }
    }
}
