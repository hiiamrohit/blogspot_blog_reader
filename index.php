<?php
/*
 * Author: Rohit Kumar
 * Website: iamrohit.in
 * Version: 0.0.1
 * Date: 07-09-2014
 * App Name: Blogspot blog reader
 * Description: Read your blogspot articles and display on your websites.
 */
if (isset($_POST['req'])) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    function __autoload($classname) {
        require_once("classes/" . $classname . ".php");
    }

    $url = $_POST['url'];
    $limit = $_POST['limit'];
    $blog = new blogReader($url, $limit);

    $data = $blog->showBlogArticles();
    echo json_encode($data);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Blog Reader</title>
        <meta charset="utf-8">
        <meta name="Keywords" content="Blog Reader, show blogspot data on your website. blogspot api ">
        <meta name="Description" content="Blog reader is a app to load blogspot artical on any website">
        <link href="css/custom.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    </head>
    <body>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-warning-sign" ></span> Alert Message</h4>
                    </div>
                    <h3>
                        <div class="modal-body" id="alertMsg">

                        </div>
                    </h3>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Loading-->
        <div class="modal fade" id="myModalLoading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" style="text-align:center;">
                        <img src='images/loading.GIF'><h3>  <span id="loadingText">Loading please wait....</span></h3>
                    </div>

                </div>
            </div>
        </div>

        <div id="contextFirst" > 
            <div class="panel panel-primary">
                <div class="panel-heading"><h3>Enter the url of blogspot page and set limit of articles.</h3>
                </div>
                <div class="panel-body" style="height:40%; text-align:center;" >
                    <form role="form" class="form-inline" id="fdata" >

                        <div class="form-group" style= "width:79%;">
                            <input type="hidden" name="req" value="blog">
                            <input type="input" style= "width:100%;" class="form-control input-lg" name="url"
                                   id="url" required="required"  placeholder="Enter blogspot url here (Exp: http://xxxxxxx.blogspot.in) !!" maxlength="50">

                        </div>
                        <div class="form-group" style= "width:6%;">
                            <input type="input" style= "width:100%;" class="form-control input-lg" 
                                   id="limit" required="required" name="limit" placeholder="Limit" maxlength="3">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg" id="sub">
                                <span class="glyphicon glyphicon-star" ></span> Submit..!!
                            </button>
                        </div>    
                    </form>     
                </div>
            </div> 


            <div class="panel panel-default">
                <div class="panel-heading"><span class="glyphicon glyphicon-leaf">

                    </span> Total Article Fetched <span class="badge" id="totalFetched">0</span> 
                    / Total Article Found <span class="badge" id="totalArticle">0</span></div>
                <div class="panel-body bar">
                    <ul class="list-group" id="articleList">
                        <li class="list-group-item">********** No Articles *********</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>   
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> 
    <script src="js/blog.js"></script> 

</body>
</html>
