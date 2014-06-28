    /*post forum data to php script for update(日本語版のみ)*/
    function postPhpForumDataUpdate(){
      var col = getForumData();

      var forumId = col["forumId"]; 
      var datepicker = col["datepicker"]; 
      var title = col["title"];
      var active = col["active"]; 

      $.ajax({
        type: "POST",
        url:"/irforum/application/password/updateforum",
        data:{ 
            "quickregisterForumUpdate": "on",
            "forumId": forumId, 
            "datepicker": datepicker,
            "title": title,
            "checkBox": active,
            },success:function(result){
              //if(result==""){
                alert("フォーラム情報が更新されました!");
                //alert(result);
                var url = "/irforum/application/password/config";    
                $(location).attr('href',url);
                $('#dialog').dialog('close');
              //}else{
                //alert(result);
              //}
            },error:function(XMLHttpRequest, textStatus, errorThrown ){
                alert(textStatus + "\n" + XMLHttpRequest.status +"\n"+ errorThrown.message);
            }
      });
    }
    /*delete user data*/
    function deletePhpForumData(){
      var col = getForumData();
      var forumId = col["forumId"]; 
      $.ajax({
        type: "POST",
        url:"/irforum/application/password/deleteforum",
        data:{ 
            "quickregisterForumDelete": "on",
            "forumId": forumId, 
            },success:function(result){
              //if(result==""){
                alert("フォーラム情報が削除されました!");
                //alert(result);
                var url = "/irforum/application/password/config";    
                $(location).attr('href',url);
                $('#dialog').dialog('close');
              //}else{
                //alert(result);
              //}
            },error:function(XMLHttpRequest, textStatus, errorThrown ){
                alert(textStatus + "\n" + XMLHttpRequest.status +"\n"+ errorThrown.message);
            }
      });
    }

