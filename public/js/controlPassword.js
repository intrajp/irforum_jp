    /*connects register button to functions*/
    $(function(){
      $("#btExecLogin").click(checkPasswordData);
    });
    /*get event of each item*/
    $(function () {
      $("#loginName").focusin(clearBackgroundColor);
      $("#password").focusin(clearBackgroundColor);
    });
    /*helper function*/
    function alertMessageForPassword(){
      alert("記入していただいてない箇所がございます\n色の付いた箇所を御記入ください");
      checkPasswordData();
    }
    /*get user data and returns as an array */
    function getPasswordData(){
      var col = new Array();
      var loginName = $("#loginName").val();
      var password = $("#password").val();
      col["loginName"] = loginName; 
      col["password"] = password; 
      return col;
    }
    /*get user data and returns as an array */
    function checkPasswordData(){
      var col = getPasswordData();

      var loginName = col["loginName"];
      var password = col["password"]; 

      var checkStr = "off";
      if( !isValidLoginName( loginName ) ) {
        $(".loginName").css("backgroundColor", "pink");
        checkStr = "on";
      }
      if( !isValidPassword( password ) ) {
        $(".password").css("backgroundColor", "pink");
        checkStr = "on";
      }
      if(checkStr == "off"){
        postPhpPasswordData();
      }else{
        alert("正しくありません");
      }
    }
    /*message button before registeration*/
    function alertMessageStartRegisterPassword(){
      var col = getPasswordData();
      var loginName = col["loginName"];
      var password = col["password"]; 
      postPhpPasswordData();
    }
  /*unused -- post user data to php script */
  function postPhpPasswordData(){
    var col = getPasswordData();

    var loginName = col["loginName"];
    var password = col["password"]; 
    $.ajax({
      type: "POST",
      url:"/irforum/application/password/login",
      data:{ 
          "loginName": loginName,
          "password": password, 
          },success:function(result){
           //alert(result);
           var url = "/irforum/application/password/index";
           //var url = "/irforum/application/password/login";
           $(location).attr('href',url);
          },error:function(XMLHttpRequest, textStatus, errorThrown ){
             alert(textStatus + "\n" + XMLHttpRequest.status +"\n"+ errorThrown.message);
         }
    });
  }

