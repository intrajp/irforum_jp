  /*post forum data to php script */
  function postPhpForumData(){
    var col = getForumData();

    var datepicker = col["datepicker"];
    var title = col["title"];
    var active = col["active"];

    $.ajax({
      type: "POST",
      url:"/irforum/application/password/addforum",
      data:{ 
          "datepicker": datepicker,
          "title": title,
          "checkBox": active,
          },success:function(result){
            //if(result==""){
              alert(datepicker + "の" + title + "をフォーラムの日程として追加しました");
              $('#dialog').dialog('close');
            //}else{
              //alert(result);
            //}
          },error:function(XMLHttpRequest, textStatus, errorThrown ){
             alert(textStatus + "\n" + XMLHttpRequest.status +"\n"+ errorThrown.message);
         }
    });
  }
