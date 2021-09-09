<?php
namespace app\index\controller;
use think\Session;
use think\Request;
use think\cache\driver\Redis;
//use Predis;
class Index  extends \think\Controller
{
    public function index()
    {	
	
		
		/*
		$servers = config('cache.cluster_list');
		$a= new Predis\Client($servers, array('cluster' => 'redis'));
		$a->set("name9", "2222222222222");
		$a->get("name9");
		
		$redis = new Redis();
        $arr = array(rand(1,10),time());
		$redis->rpush('send_email_queue', json_encode($arr));
		echo $redis->rpop('send_email_queue');
		*/
		$REDIS_REMOTE_HT_KEY         = "product_%s";     //共享信息key
    	$REDIS_REMOTE_TOTAL_COUNT    = "total_count";    //商品总库存
    	$REDIS_REMOTE_USE_COUNT      = "used_count";     //已售库存
	
		$script = <<<eof
            local key = KEYS[1]
            local field1 = KEYS[2]
            local field2 = KEYS[3]
            local field1_val = redis.call('hget', key, field1)
            local field2_val = redis.call('hget', key, field2)
            if(field1_val>field2_val) then
                return redis.call('HINCRBY', key, field2,1)
            end
            return 0
eof;
		$redis = new Redis();
        echo $redis->evals($script,array($REDIS_REMOTE_HT_KEY,$REDIS_REMOTE_TOTAL_COUNT,$REDIS_REMOTE_USE_COUNT),array(),3);
		
		
		
		
        return $this->fetch();
    }
	
	
	//个人中心
	public function my()
    {	
		if(!Session::get('sess_admin')){
	  		return $this->error('请先登陆',url('/index/index/login'));
		}else{
			$user_info = Session::get('sess_admin');
		}
		$this->assign('ip', $_SERVER['SERVER_NAME']);
		$this->assign('user_info', $user_info);
        return $this->fetch();
    }
	
	//登录
	public function login()
    {
        return $this->fetch();
    }
	
	//登出
	public function loginout()
    {
       Session::set('sess_admin',NULL);
	   $this->success('登出成功', '/'); 
    }
	
	//提交
	public function submit(Request $request)
    {	
	
		$username = $request->param('username');
		$pass = $request->param('pass');
		
		$userlist = ['username'=>'superman','pass'=>'123456','sex'=>'男','account'=>100,'login_time'=>time()];

		if($username==$userlist['username'] && $pass == $userlist['pass'] ){
			Session::set('sess_admin',$userlist);
			$this->success('登陆成功', '/');
		}else{
			$this->error('用户名或密码错误!');
			
		}
		

    }
}
