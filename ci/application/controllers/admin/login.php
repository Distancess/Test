<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 后台默认控制器
*/

class Login extends CI_Controller{
	/*
	* 默认方法
	*/
	public function index(){
		//载入验证码辅助函数
		$this->load->helper('captcha');

		$speed='abcdefghijklmnopqrstuvwxyz1234567890';
		$word='';
		for($i=0;$i<4;$i++)
		{
			$word.=$speed[mt_rand(0,strlen($speed)-1)];
		}
		//echo $word;die;
		//配置项
		$vals=array(
			'word'=> $word,
			'img_path'=> './captcha/',
			'img_url' => base_url().'/captcha/',
			'img_width'=>80,
			'img_height'=>30,
			'expiration'=>60
		);
		if(!isset($_SESSION)){
			session_start();
		}
		$cap=create_captcha($vals);
		//p($cap);die;
		$_SESSION['code']=$cap['word'];
		//p($_SESSION['code']);die;
		$data['captcha']=$cap['image'];
		
		$this->load->view("admin/login.html",$data);
	}

	/**
	* 登录
	*/
	public function login_in(){
		$code=$this->input->post('captcha');
		if(!isset($_SESSION)){
			session_start();
		}

		if(strtoupper($code)!=strtoupper($_SESSION['code'])){
			error('验证码错误');
		}
		
		$username=$this->input->post('username');
		$this->load->model('admin_model','admin');
		$userData=$this->admin->check($username);

		$passwd=$this->input->post('passwd');

		if(!$userData || $userData[0]['passwd']!=md5($passwd)){
			error('用户名或者密码不正确');
		}
		$sessionData=array(
			'username'=>$username,
			'uid'=>$userData[0]['uid'],
			'logintime'=>time()
		);
		$this->session->set_userdata($sessionData);
		// $data=$this->session->userdata('username');
		// p($data);die;
		success('admin/admin/index','登录成功');
	}

	/**
	* 退出
	*/
	public function login_out(){
		$this->session->sess_destroy();
		success('admin/login/index','退出成功');
	}
}