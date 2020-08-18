window.onload=function(){
    //頁面顯示控制
    var getUrlString = location.href; //取得get參數
    var url = new URL(getUrlString);
    var order = url.searchParams.get('order');
    var sc = url.searchParams.get('sc');
    var getSearch = url.searchParams.get('search');
    var getPsearch = url.searchParams.get('psearch');
    var obj = document.getElementById("order");
    var obj2 = document.getElementById("sc");
    var optOrder = obj.getElementsByTagName("option");
    var optSc = obj2.getElementsByTagName("option");
    var search = document.getElementById("datepicker");
    var psearch = document.getElementById("pid");
    var obj3 = document.getElementById("sMethod");
    var sMethod=obj3.getElementsByTagName("option");

    if(order != null && sc != null){
        for(var i=0; i<optOrder.length; i++){
            if(optOrder[i].value == order){
                optOrder[i].selected = true;
                break;
            }
        }
       
        optSc[sc].selected = true;
        
        
    }

    if(getSearch != null){
        search.value = getSearch;
    }

    if(getPsearch != null){
        psearch.value = getPsearch;
        psearch.style.display="inline-block";
        search.style.display="none";
        sMethod[1].selected = true;
    }
   
}



function search()
{ //搜尋控制
    var getUrlString = location.href; //取得get參數
    var url = new URL(getUrlString);
    var order = url.searchParams.get('order');
    var sc = url.searchParams.get('sc');
    var search = document.getElementById("datepicker");
    var psearch = document.getElementById("pid");
    var getParam = "";

    if(search.value != "") {
        getParam += "?search="+search.value;
        if(order != null && sc != null) {
            getParam += "&order="+order+"&sc="+sc;
        }

        location.href = 'index.php'+getParam;
    } else if(psearch.value != "") {
        getParam += "?psearch="+psearch.value;
        if(order != null && sc != null) {
            getParam += "&order="+order+"&sc="+sc;
        }

        location.href = 'index.php'+getParam;
    }else{
        alert('請輸入搜尋欄位');
    }
    
}

function order()
{ //排序控制
    var getUrlString = location.href; //取得get參數
    var url = new URL(getUrlString);
    var order = document.getElementById("order");
    var sc = document.getElementById("sc");
    var search = url.searchParams.get("search");
    var psearch = url.searchParams.get("psearch");
    var getParam = "";
    if(order.value != "" && sc.value != ""){
        getParam += "?order="+order.value+"&sc="+sc.value;
        if(search != null){
            getParam += "&search="+search;
        }else if(psearch != null){
            getParam += "&psearch="+psearch;
        }
    }else{
        if(search != null){
            getParam += "?search="+search;
        }else if(psearch != null){
            getParam += "?psearch="+psearch;
        }
    }
    location.href = 'index.php'+getParam;
}

function resetSearch()
{ //清空搜尋input
    var search = document.getElementById("datepicker");
    var psearch = document.getElementById("pid");
    var getUrlString = location.href; //取得get參數
    var url = new URL(getUrlString);
    var getSearch = url.searchParams.get("search");
    var getPsearch = url.searchParams.get("psearch");
    if(getSearch != null || getPsearch != null){
        search.value = "";
        psearch.value = "";
        var getUrlString = location.href;
        var url = new URL(getUrlString);
        var order = url.searchParams.get("order");
        var sc = url.searchParams.get("sc");
        var getParam = "";
        if(order != null && sc != null){
            getParam += "?order="+order+"&sc="+sc;
        }
        location.href = 'index.php'+getParam;
    } else if(search.value != "" || psearch.value != ""){
        search.value = "";
        psearch.value = "";
    }
   
}

function nextPage(page, pages)
{ //下一頁
    if((page+1) <= pages){
        var getParam = page_getparam(page+1);
        location.href = 'index.php'+getParam;
    }else{
        alert("超出最大頁數");
    }
   
}


function lastPage(page)
{ //上一頁
    if((page-1) > 0){
        var getParam = page_getparam(page-1);
        location.href = 'index.php'+getParam;
    }else{
        alert("已經是第一頁");
    }
   
}

function firstPage()
{ //到第一頁
    var getParam = page_getparam("1");
    location.href = 'index.php'+getParam;
}


function endPage(pages)
{ //到最後一頁
    var getParam = page_getparam(pages);
    location.href = 'index.php'+getParam;
}

function changePage(pages)
{ //跳頁
    var page = document.getElementById("page").value;
    if(page > 0){
        if(page <= pages){
            var getParam = page_getparam(page);
            location.href = 'index.php'+getParam;
        }else{
            alert("超出最大頁數");
        }
    }else{
        alert("頁數不可低於1");
    }
}

function page_getparam(page)
{ //取得換頁get參數
    var getUrlString = location.href;
    var url = new URL(getUrlString);
    var order = url.searchParams.get('order');
    var sc = url.searchParams.get('sc');
    var search = url.searchParams.get('search');
    var psearch = url.searchParams.get('psearch');
    var getParam = "?";
    if(order != null && sc != null){
        getParam += "order="+order+"&sc="+sc
        if(search != null){
            getParam += "&search="+search;
        }else if(psearch != null){
            getParam += "&psearch="+psearch;
        }
        getParam += "&page="+page;
    }else if(search != null){
        getParam += "search="+search+"&page="+page;
    }else if(psearch != null){
        getParam += "psearch="+psearch+"&page="+page;
    }else{
        getParam += "page="+page;
    }
    return getParam;
}

function searchMethod()
{ //控制搜尋input顯示
    var sel = document.getElementById("sMethod").value;
    var date = document.getElementById("datepicker");
    var pid = document.getElementById("pid");
    if(sel == 'time'){
        date.style.display = "inline-block";
        pid.style.display = "none";
        pid.value = "";
    }else if(sel == 'pid'){
        pid.style.display = "inline-block";
        date.style.display = "none";
        date.value = "";
    }
}

function page_controler(page, pages)
{
    var first = document.getElementById("first");
    var end = document.getElementById("end");
    if(page == '1'){
        first.disabled = true;
    }else{
        first.disabled = false;
    }

    if(page == pages){
        end.disabled = true;
    }else{
        end.disabled = false;
    }
}



$(document).ready(function() {
    $("#timeSub").click(function() {
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {
                time: $("#time").val()
            },
            success: function() {
                alert("時間修改成功");
            },
            error: function(jqXHR) {
                alert("發生錯誤" + jqXHR.status);
            }
        })
    });
});
