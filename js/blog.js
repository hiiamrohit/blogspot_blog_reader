$(function() {

    // On submit click function
    $("#sub").click(function(e) {
        e.preventDefault();
        var url = $.trim($("#url").val());
        var limit = $.trim($("#limit").val());
        if (url == '') {
            $("#url").css("border:1px solid red");
            alertModal('Please enter blogspot url !!');
            $("#url").focus();
            return false;
        }
        if (limit == '') {
            alertModal('Please set limit !!');
            $("#limit").focus();
            return false;
        }
        $("ul#articleList").empty();
        loadingShow();
        getBlogData();

    });

// show loading message
    var loadingShow = function() {
        $("#myModalLoading").modal('show');
    }

// Hide loading message
    var loadingHide = function() {
        $("#myModalLoading").modal('hide');
    }

// alert/error message box
    var alertModal = function(msg) {
        $("div#myModal").modal('show');
        $("div#alertMsg").html(msg);
    }

    // reset bages value   
    var resetArticleBage = function() {
        $("span#totalArticle").html(0);
        $("span#totalFetched").html(0);
        $("ul#articleList").append('<li class="list-group-item">********** No Articles *********</li>');
    }

// function to fetch blog data with sussess and error 
    var getBlogData = function(url, limit) {
        var successRes = function(data) {
            loadingHide();
            if (typeof data === 'object') {
                $("span#totalArticle").html(data.totalArticle);
                if ($("#limit").val() > data.totalArticle) {
                    $("span#totalFetched").html(data.totalArticle);
                } else {
                    $("span#totalFetched").html($("#limit").val());
                }

                $.each(data['blog'], function(index, blog) {
                    $("ul#articleList").append(createHtml(index, blog.title[0], blog.description[0], blog.pubDate[0], blog.author[0]));
                });

            } else {
                alertModal(data);
                resetArticleBage();
            }
        };

        var errorRes = function(e) {
            alertModal("Error to fetch data, ( " + e.responseText + " )");
            loadingHide();
            resetArticleBage();
        };
// create html context to display articles
        var createHtml = function(sn, title, description, pubdate, author) {
            var html = '<li class="list-group-item">\n\
            <b>Article No: <span class="badge">' + (sn + 1) + '</span> \n\
Publishing date: <span class="badge">' + pubdate + ' </span> \n\
Author: <span class="badge">' + author + ' </span></b>\n\
<h4>' + title + '</h4><p>' + description + '</p></li>';
            return html;
        }

        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: $("#fdata").serialize(),
            dataType: 'json',
            success: successRes,
            error: errorRes
        });
    };

    // demo request to load blogspot articles on page
    var pageOnLoad = function() {
        $("#url").val('http://the-sarkarinaukri.blogspot.in');
        $("#limit").val(10);
        $("#sub").trigger('click');
    }
    pageOnLoad();

});