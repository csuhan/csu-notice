<?php

/**
 * Created by PhpStorm.
 * User: han
 * Date: 2017/7/26
 * Time: 22:55
 */
require 'curl-master/curl.php';
require 'simple_html_dom.php';
class CSUNotice
{
    private $site_url = 'http://tz.its.csu.edu.cn';
    private $base_url = 'http://tz.its.csu.edu.cn/Home/Release_TZTG/';
    private $article_url = 'http://tz.its.csu.edu.cn/Home/Release_TZTG_zd/';
    private $download_link = 'http://tz.its.csu.edu.cn/Home/FileDownload/';
    private $search_url = 'http://tz.its.csu.edu.cn/Home/Release_TZTG/0-';
    private $curl;

    //初始化
    public function __construct()
    {
        $this->curl = new Curl;
        //设置ip，模拟校内服务器，免登录
        $this->curl->headers['x-forwarded-for'] = '202.197.71.84';
    }


    //获取数据列表
    public function get_lists($page_no = 1,$key_word = '',$dept = '')
    {
        //响应
        $response = '';
        //输出的结果
        $res = [];

        //搜索,首次访问
        if($key_word!='' && $page_no==1)
        {
            $response = $this->curl->get($this->search_url.urlencode($key_word));
        }
        //列表，或者非首次访问搜索
        else{
            if($page_no==1) $page = '';
            else $page = $page_no-1;
            $response =  $this->curl->get($this->base_url.$page);

        }

        if($response->headers['Status-Code'] != 200) {
            throw new Exception('数据读取有误');
        }
//        print_r($response);

        //当前页面
        $res['now_page'] = (int)$page_no;
        preg_match('/共有数据：(\d*)条(.*)共(\d*)页/',$response->body,$matches);
        if(isset($matches[3]))
        {
            //总数据条数
            $res['total'] = (int)$matches[1];
            //总页数
            $res['total_page'] = (int)$matches[3];

            //判断数据是否为空
            if($matches[1] == 0)
            {
                $res['lists'] = '';
                $res['error_msg'] = 'no-msg';
                return json_encode($res,JSON_UNESCAPED_UNICODE);
            }
        }

        //匹配数据
        $html_dom = str_get_html($response->body);
        $lists = $html_dom->find('table.grid .trs',0)->children();
        foreach ($lists as $index => $tr)
        {
            preg_match('/Release_TZTG_zd\/(.*)\', \'\', \'left/',$tr->children(4)->children(0)->onclick,$id);
           $res['lists'][$index]['id'] =  $id[1];
           $res['lists'][$index]['title'] = str_replace('&nbsp;','',trim($tr->children(4)->children(0)->plaintext));
           $res['lists'][$index]['dept'] =  trim($tr->children(5)->plaintext);
           $res['lists'][$index]['viewer'] = trim($tr->children(6)->plaintext);
           $res['lists'][$index]['pubtime'] = trim($tr->children(7)->plaintext);
        }
        //输出
        return json_encode($res,JSON_UNESCAPED_UNICODE);
    }

    //获取页面数据
    public function get_article($id)
    {
        $response =  $this->curl->get($this->article_url.$id);
        if($response->headers['Status-Code'] != 200) {
            throw new Exception('数据读取有误');
        }

        $res= [];

        $html_dom = str_get_html($response->body);
        $table = $html_dom->find('table',2);
        $article = $table->find('tr',2);
        //文章
        $res['article'] = $this->parse_article($article);

        $downloads = $table->find('tr',3)->find('a');

        //无附件
        if(empty($downloads))
        {
            $res['has_download'] = false;
        }
        else{
            $res['has_download'] = true;
            foreach ($downloads as $index => $val)
            {
                $href = explode('FileDownload/',$val->href);
                $link = $href[1];
                $res['downloads'][$index] = [
                    'title'=>trim($val->plaintext),
                    'link' =>$this->download_link.$link
                ];
            }
        }

        return json_encode($res,JSON_UNESCAPED_UNICODE);
    }


    private function parse_article($article)
    {
        $temp = trim($article);
        //解决图片
        $temp =  str_replace('/FileUpload',$this->site_url.'/FileUpload',$temp);
        return $temp;
    }
}