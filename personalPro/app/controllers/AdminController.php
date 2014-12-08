<?php

class AdminController extends BaseController {

	/*example*/
	/*public function show()
	{
		//return 'hello';
		//return Input::all();
		return JSON_encode(User::find(1), JSON_UNESCAPED_UNICODE);
	}
	public function haha(){
		return Tool::show();
	}*/
	/*public function ip2position(){
		$curl = curl_init('http://int.dpool.sina.com.cn/iplookup/iplookup.php?ip='.$ip); 
		curl_setopt($curl, CURLOPT_FAILONERROR, true); 
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //
		$result = curl_exec($curl); 
        curl_close($curl);  
  		//var_dump( compact($result));
  		$response = array('status'=>$result);
		$response = json_encode($response);
		echo ($response);
  		//var_dump($result);
	}*/
	public function demo1(){
		return Input::get('tmp1');
	}
	public function demo2($tmp2){
		return ($tmp2);
	}
	public function showAll()
	{
		return JSON_encode(User::all(), JSON_UNESCAPED_UNICODE);
	}
	public function showWhere()
	{
		return JSON_encode(User::where('account','=','hkq325800')->take(10)->get(), JSON_UNESCAPED_UNICODE);
	}

	//localhost/demo/public/logIn?username=hkq325800&password=hkq93214
	public function logIn(){
		if(User::where('account','=',Input::get('username'))->where('password','=',Input::get('password'))->count()==1){
			echo 'ok';
		}
		else if(User::where('account','=',Input::get('username'))->count()==0){
			echo '用户名不存在';
		}
		else{
			echo '密码不正确';
		}
	}
	public function signUp(){
		$user = new User;
		$user->account=Input::get('username');
		$user->password=Input::get('password');
		$user->save();
		echo 'ok';
	}
	public function getInfo(){
		$info="no";
		$flag=false;
		if(Input::get('username')){
			if(User::where('account','=',Input::get('username'))->count()==0){
				$flag=true;
			}
			else{
				$flag=false;
				$info="该用户已存在";
			}
		}
		if(Input::get('password')){
			$flag=true;
		}
		if(Input::get('captcha')){
			if(Input::get('captcha'))
				$flag=true;
			else{
				$flag=false;
				$info="验证码错误";
			}
		}
		if($flag)
			$info='ok';
		echo $info;
	}
	public function city2weather(){
		$cityid=Cityid::where('cityname','like','%'.Input::get('cityname'))->lists('cityid')[0];
		$result=file_get_contents('http://weatherapi.market.xiaomi.com/wtr-v2/weather?cityId='.$cityid);
		echo $result;
	}
	/*public function ip2position(){
		$ip=Input::get('ip');
		$result=file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?ip='.$ip);
        $arr=array();
        $arr=explode("	", $result);
		$arr[5]=iconv('GBK','UTF-8',$arr[5]);
  		echo $arr[5];
	}*/
	public function getweibotop10(){
		//echo vget("http://www.bilibili.com/")
		$html=file_get_contents('http://s.weibo.com/');//拉取初始文件
		$inner='http://s.weibo.com';
		$result=substr($html,stripos($html,'<div class="search_newrec_box clearfix">'),stripos($html,'<!-- /pl_todayhot -->')-stripos($html,'<div class="search_newrec_box clearfix">')+strlen('<!-- /pl_todayhot -->'));//截取正确的部分
		//截取正确部分中需要的字节
		$result=str_replace('<span class="newpink">new!</span>','',$result);//清除new！
		$result."</div>";$result=str_replace(' ','',$result);
		//echo $result;
		$arrtmp=explode('<a',$result);
		$arrhref=array();
		$arrsearched=array();
		for($i=1;$i<11;$i++){
			$arrhref[$i]=$inner.substr($arrtmp[$i],stripos($arrtmp[$i],'"href=')+6,stripos($arrtmp[$i],'"searchcard')-6);
			$arrsearched[$i]=substr($arrtmp[$i],stripos($arrtmp[$i],'nologin">')+9,stripos($arrtmp[$i],'</a>')-stripos($arrtmp[$i],'nologin">')-9);
		}
		$arrres=array('href'=>$arrhref,'key'=>$arrsearched);
		$response = json_encode($arrres);
		echo $response;
	}

	//define ( 'IS_PROXY', true ); //是否启用代理
	
	static function vget($url) { // 模拟获取内容函数
		/* cookie文件 */
		$cookie_file = dirname ( __FILE__ ) . "/cookie_" . md5 ( basename ( __FILE__ ) ) . ".txt"; // 设置Cookie文件保存路径及文件名
		/*模拟浏览器*/
		$user_agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; .NET CLR 1.1.4322)";
	    $curl = curl_init (); // 启动一个CURL会话
	    if (true) {
	        //以下代码设置代理服务器
	        //代理服务器地址
	        curl_setopt ( $curl, CURLOPT_PROXY,  'http://114.112.91.97');
	        curl_setopt( $curl, CURLOPT_PROXYPORT, 90); //代理服务器端口
	    }
	    curl_setopt ( $curl, CURLOPT_URL, $url ); // 要访问的地址
	    curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, 0 ); // 对认证证书来源的检查
	    curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, 2 ); // 从证书中检查SSL加密算法是否存在
	    curl_setopt ( $curl, CURLOPT_USERAGENT, $user_agent ); // 模拟用户使用的浏览器
	    curl_setopt ( $curl, CURLOPT_FOLLOWLOCATION, 1 ); // 使用自动跳转
	    curl_setopt ( $curl, CURLOPT_AUTOREFERER, 1 ); // 自动设置Referer
	    curl_setopt ( $curl, CURLOPT_HTTPGET, 1 ); // 发送一个常规的Post请求
	    curl_setopt ( $curl, CURLOPT_COOKIEFILE, $cookie_file ); // 读取上面所储存的Cookie信息
	    curl_setopt ( $curl, CURLOPT_TIMEOUT, 120 ); // 设置超时限制防止死循环
	    curl_setopt ( $curl, CURLOPT_HEADER, 0 ); // 显示返回的Header区域内容
	    curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 ); // 获取的信息以文件流的形式返回
	    $tmpInfo = curl_exec ( $curl ); // 执行操作
	    if (curl_errno ( $curl )) {
	        echo 'Errno' . curl_error ( $curl );
	    }
	    curl_close ( $curl ); // 关闭CURL会话
	    return $tmpInfo; // 返回数据
	}
}
