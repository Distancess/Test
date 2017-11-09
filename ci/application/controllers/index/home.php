<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{
	/*
	*默认前台控制器
	*/
	public function index(){
		$this->output->enable_profiler(TRUE);
		// echo base_url() . 'style/index';
		// echo site_url().'/index/home/category';
		//echo site_url().'/index/home/detail';
		$this->load->model('article_model','art');
		$data=$this->art->check();
		
		/*导航栏限制数据*/
		$this->load->model('category_model','cate');
		$data['category']=$this->cate->limit_category(4);

		/*右侧标题*/
		$data['title']=$this->art->title(4);
		$this->load->view('index/home.html',$data);
	}
	/**
	* 分类页显示
	*/
	public function category(){
		/*导航栏限制数据*/
		$this->load->model('category_model','cate');
		$data['category']=$this->cate->limit_category(4);

		/*右侧标题*/
		$this->load->model('article_model','art');
		$data['title']=$this->art->title(4);

		$cid=$this->uri->segment(4);
		$data['article']=$this->art->category_article($cid);
		$this->load->view('index/category.html',$data);
	}

	/**
	* 更多显示
	*/
	public function detail(){
		$aid=$this->uri->segment(4);

		$this->load->model('category_model','cate');
		$data['category']=$this->cate->limit_category(4);

		/*右侧标题*/
		$this->load->model('article_model','art');
		$data['title']=$this->art->title(4);

		$data['article']=$this->art->aid_article($aid);
		
		$this->load->view('index/details.html',$data);
	}
}
