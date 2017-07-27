# csu-notice:中南大学校内通知

a practice of vuejs about csu-notice  

本程序主要用于练习es6&vuejs,使用了vuejs2，vue-router,vue-resource,   
为了增加界面效果，采用了vue-circle-menu，vue-infinite-loading，感谢他们的作者。   

后端采用php，使用了curl-wrapper,simple_html_dom，获取并解析[tz.its.csu.edu.cn](http://tz.its.csu.edu.cn),
由于此网站仅在校内网可访问，于是在请求头添加了x-forwarded-for: 202.197.71.84(校内服务器),实现了免登陆访问。
注意，此网站的搜索似乎有点诡异，是服务器端记录keyword，可参见代码中用法。
#Demo
[点击这里查看](http://lovesmg.cn/csu-notice)

## Build Setup

``` bash
git clone {this.git}

cd path/to/you/project

# install dependencies

npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build
```
#More
参见源代码，有空慢慢补充
