<?php
/*
 * Author: Rohit Kumar
 * Website: iamrohit.in
 * Version: 0.0.1
 * Date: 07-09-2014
 * App Name: Blogspot blog reader
 * Description: Read your blogspot articles and display on your websites.
 */
class blogReader {
    
    public $url;
    public $limit;
    public $maxLimit =999; 
    private static $rssUrl = '/feeds/posts/default?alt=rss';
    
    // set variable at the time of object initialization 
    function __construct($url, $limit) {
        $this->url = $url;
        $this->limit = $limit;
    }
    
    // create blogspot Rss url
    public function rssUrl() {
        $rssUrl = $this->url . self::$rssUrl."&max-results=".$this->maxLimit ;
        return $rssUrl;
    }
    
    // Make connection to Rss
    private function blogData() {
        try {
            $handle = fopen($this->rssUrl(), "r");
            $contents = stream_get_contents($handle);
            $doc = new SimpleXmlElement($contents, LIBXML_NOCDATA);
            return $doc;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    
   // Fetch total blogspot atricles
    public function totalArticle() {
        try {
            $blogObj = $this->blogData();
            if (isset($blogObj->channel)) {
                $numArticle = count($blogObj->channel->item);
                return $numArticle;
            } else {
                 throw new Exception('Article channel not found!!');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
   
    // show article with user specified limit.
    public function showBlogArticles() {
        try {
            $blogObj = $this->blogData();
            if($this->totalArticle()>0) {
                  if($this->limit > $this->totalArticle()) {
                   $this->limit  = $this->totalArticle(); 
                  }
                for ($i = 0; $i < $this->limit; $i++) {
                    $arr['blog'][$i]['title'] = $blogObj->channel->item[$i]->title;
                    $arr['blog'][$i]['description'] = $blogObj->channel->item[$i]->description;
                    $arr['blog'][$i]['link'] = $blogObj->channel->item[$i]->link;
                    $arr['blog'][$i]['pubDate'] = $blogObj->channel->item[$i]->pubDate;
                    $arr['blog'][$i]['author'] = $blogObj->channel->item[$i]->author;
                }
                $arr['totalArticle'] = $this->totalArticle();
                 return $arr;
            } else {
                throw new Exception('No articals found .Please check your blogspot url again!!');
            }
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

}
?>

