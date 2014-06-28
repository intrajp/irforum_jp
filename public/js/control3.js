    /*changes background color of this class*/
    function clearBackgroundColor(){
      $(this).css("backgroundColor", "lavender");
    }
    /*connects register button to functions*/
    $(function(){
      $("#btExecForum").click(checkForumData);
      $("#btExecForumUpdate").click(checkForumDataUpdate);
      $("#btExecForumDelete").click(alertMessageForumDelete);
    });
    /*get event of each item*/
    $(function () {
      $("#datepicker").focusin(clearBackgroundColor);
      $("#title").focusin(clearBackgroundColor);
      $("#checkBox").focusin(clearBackgroundColor);
    });
    /*get user data and returns as an array */
    function getForumData(){
      var active;
      var col = new Array();
      var forumId = $("#forumId").val();
      var datepicker = $("#datepicker").val();
      var title = $("#title").val();
      if($('#checkBox').prop('checked')){
        active = 1;
      }else{
        active = 0;
      }
      col["forumId"] = forumId; 
      col["datepicker"] = datepicker; 
      col["title"] = title; 
      col["active"] = active; 
      return col;
    }
    /*get user data and returns as an array */
    function checkForumData(){
      var col = getForumData();

      var datepicker = col["datepicker"];
      var title = col["title"];
      var active = col["active"];

      var checkStr="off";

      if( !isValidDate( datepicker ) ) {
        $(".datepicker").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidTitle( title ) ) {
        $(".title").css("backgroundColor", "pink");
        checkStr="on";
      }
      if(checkStr == "off"){
        alertMessageStartRegister();
      }else{
        alert("色の付いたところを正しく記入してください");
      }
    }
    /*get user data and returns as an array */
    function checkForumDataUpdate(){
      var col = getForumData();

      var datepicker = col["datepicker"];
      var title = col["title"];
      var active = col["active"];

      var checkStr="off";

      if( !isValidDate( datepicker ) ) {
        $(".datepicker").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidTitle( title ) ) {
        $(".title").css("backgroundColor", "pink");
        checkStr="on";
      }
      if(checkStr == "off"){
        alertMessageStartRegisterUpdate();
      }else{
        alert("色の付いたところを正しく記入してください");
      }
    }
    /*message button before registeration*/
    function alertMessageStartRegister(){
      var active_str;
      var col = getForumData();
      var datepicker = col["datepicker"];
      var title = col["title"];
      var active = col["active"];
      if(active == 0){
        active_str="しない";
      }else{
        active_str="する";
      }
      $('#dialog').dialog(
      {
        width: 450,
        draggable: true,
        resizable: false,
        modal: true,
        position: [ 250, 150 ],
        overlay:
        {
          opacity: 0.5, 
          background: 'black' 
        },
        title: '確認',
        open: function(){
          $('#dialog').html(
            '<table border="1">' +
            '<tr><td>フォーラム日</td><td>' + datepicker + '</td></tr>' + 
            '<tr><td>タイトル</td><td>' + title + '</td></tr>' + 
            '<tr><td>アクティヴ化</td><td>' +active_str + '</td></tr>' + 
            '</table>' + 
            'この内容で登録してもよろしいですか？'
          );
        },
        buttons:
        { 
          '登録する': function()
          {
            postPhpForumData();
          },
          '中止する': function()
          { 
            $('#dialog').dialog('close');
          }
        }
      });
    }
    /*message button before update registeration*/
    function alertMessageStartRegisterUpdate(){
      var active_str;
      var col = getForumData();
      var forumId = col["forumId"];
      var datepicker = col["datepicker"];
      var title = col["title"];
      var active = col["active"];
      if(active == 0){
        active_str="しない";
      }else{
        active_str="する";
      }
      $('#dialog').dialog(
      {
        width: 450,
        draggable: true,
        resizable: false,
        modal: true,
        position: [ 250, 150 ],
        overlay:
        {
          opacity: 0.5, 
          background: 'black' 
        },
        title: '確認',
        open: function(){
          $('#dialog').html(
            '<table border="1">' +
            '<tr><td>フォーラムid</td><td>' + forumId + '</td></tr>' + 
            '<tr><td>フォーラム日</td><td>' + datepicker + '</td></tr>' + 
            '<tr><td>タイトル</td><td>' + title + '</td></tr>' + 
            '<tr><td>アクティヴ化</td><td>' +active_str + '</td></tr>' + 
            '</table>' + 
            'この内容で修正してもよろしいですか？'
          );
        },
        buttons:
        { 
          '修正する': function()
          {
            postPhpForumDataUpdate();
          },
          '中止する': function()
          { 
            $('#dialog').dialog('close');
          }
        }
      });
    }
    /*message button before update registeration*/
    function alertMessageForumDelete(){
      var active_str;
      var col = getForumData();
      var datepicker = col["datepicker"];
      var title = col["title"];
      var active = col["active"];
      if(active == 0){
        active_str="しない";
      }else{
        active_str="する";
      }
      $('#dialog').dialog(
      {
        width: 450,
        draggable: true,
        resizable: false,
        modal: true,
        position: [ 250, 150 ],
        overlay:
        {
          opacity: 0.5, 
          background: 'black' 
        },
        title: '確認',
        open: function(){
          $('#dialog').html(
            '<table border="1">' +
            '<tr><td>フォーラム日</td><td>' + datepicker + '</td></tr>' + 
            '<tr><td>タイトル</td><td>' + title + '</td></tr>' + 
            '<tr><td>アクティヴ化</td><td>' +active_str + '</td></tr>' + 
            '</table>' + 
            'このフォーラムを削除してもよろしいですか？'
          );
        },
        buttons:
        { 
          '削除する': function()
          {
            deletePhpForumData();
          },
          '中止する': function()
          { 
            $('#dialog').dialog('close');
          }
        }
      });
    }




