    /*changes background color of this class*/
    function clearBackgroundColor(){
      $(this).css("backgroundColor", "lavender");
    }
    /*checks the radio button state*/
    function checkButtonCheck(){
      var checkAgree = $("#checkBox").prop('checked');
      if(!checkAgree){
       alert("登録には同意が必要です");
      }
    }
    /*connects register button to functions*/
    $(function(){
      $("#btExec").click(checkUsersData);
      $("#btExec").mousedown(checkButtonCheck);
    });
    /*get event of each item*/
    $(function () {
      $("#surName").focusin(clearBackgroundColor);
      $("#firstName").focusin(clearBackgroundColor);
      $("#surNameYomi").focusin(clearBackgroundColor);
      $("#firstNameYomi").focusin(clearBackgroundColor);
      $("#email").focusin(clearBackgroundColor);
      $("#zipFirst").focusin(clearBackgroundColor);
      $("#zipLast").focusin(clearBackgroundColor);
      $("#zipLast").keyup(zipToAddressAlert);
      $("#prefSelection").focusin(clearBackgroundColor);
      $("#city").focusin(clearBackgroundColor);
      $("#town").focusin(clearBackgroundColor);
      $("#building").focusin(clearBackgroundColor);
      $("#phoneFirst").focusin(clearBackgroundColor);
      $("#phoneSecond").focusin(clearBackgroundColor);
      $("#phoneThird").focusin(clearBackgroundColor);
    });
    /*get user data and returns as an array */
    function getUsersData(){
      var col = new Array();
      /*only for update*/
      var userId = $("#userIdStr").text();
      /*end only for update*/
      var surName = $("#surName").val();
      var firstName = $("#firstName").val();
      var surNameYomi = $("#surNameYomi").val();
      var firstNameYomi = $("#firstNameYomi").val();
      var email = $("#email").val();
      var zipFirst = $("#zipFirst").val();
      var zipLast = $("#zipLast").val();
      var prefId = $("select[id='prefSelection']").val();
      var prefName = $("option:selected").text();
      var city = $("#city").val();
      var town = $("#town").val();
      var building = $("#building").val();
      var phoneFirst = $("#phoneFirst").val();
      var phoneSecond = $("#phoneSecond").val();
      var phoneThird = $("#phoneThird").val();
      var forumId = $("#forumId").val();
      col["userId"] = userId; 
      col["surName"] = surName; 
      col["firstName"] = firstName; 
      col["surNameYomi"] = surNameYomi; 
      col["firstNameYomi"] = firstNameYomi; 
      col["email"] = email; 
      col["zipFirst"] = zipFirst; 
      col["zipLast"] = zipLast; 
      col["prefId"] = prefId; 
      col["prefName"] = prefName; 
      col["city"] = city; 
      col["town"] = town; 
      col["building"] = building; 
      col["phoneFirst"] = phoneFirst; 
      col["phoneSecond"] = phoneSecond; 
      col["phoneThird"] = phoneThird; 
      col["forumId"] = forumId; 
      return col;
    }
    /*get user data and returns as an array */
    function checkUsersData(){
      var col = getUsersData();

      var surName = col["surName"];
      var firstName = col["firstName"]; 
      var surNameYomi = col["surNameYomi"]; 
      var firstNameYomi = col["firstNameYomi"]; 
      var email = col["email"]; 
      var zipFirst = col["zipFirst"]; 
      var zipLast = col["zipLast"]; 
      var prefId = col["prefId"]; 
      var prefName = col["prefName"]; 
      var city = col["city"]; 
      var town = col["town"];
      var building = col["building"]; 
      var phoneFirst = col["phoneFirst"]; 
      var phoneSecond = col["phoneSecond"]; 
      var phoneThird = col["phoneThird"]; 

      var checkStr="off";

      if( !isValidJinmei( surName ) ) {
        $(".surName").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidJinmei( firstName ) ) {
        $(".firstName").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidHiragana( surNameYomi ) ) {
        $(".surNameYomi").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidHiragana( firstNameYomi ) ) {
        $(".firstNameYomi").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidEmailAddress( email ) ) {
        $(".email").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidZipCodeFirst( zipFirst ) ) {
        $(".zipFirst").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidZipCodeSecond( zipLast ) ) {
        $(".zipLast").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidAddress( city ) ) {
        $(".city").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidAddress( town ) ) {
        $(".town").css("backgroundColor", "pink");
        checkStr="on";
      }
      if(( building !="")&&( !isValidAddress( building ))) {
        $(".building").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidPrefId( prefId ) ) {
        $(".prefSelection").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidPhoneNumber( phoneFirst ) ) {
        $(".phoneFirst").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidPhoneNumber( phoneSecond ) ) {
        $(".phoneSecond").css("backgroundColor", "pink");
        checkStr="on";
      }
      if( !isValidPhoneNumber( phoneThird ) ) {
        $(".phoneThird").css("backgroundColor", "pink");
        checkStr="on";
      }
      if(checkStr == "off"){
        alertMessageStartRegister();
      }else{
        alert("色の付いたところを正しく記入してください");
      }
    }
    /*set address from zip*/
    function setAddressFromZip(city,town,prefId,prefNameKanji){
      $("input.city").val(city);
      $("input.town").val(town);
      $("#prefSelection option:first-child").remove();
      $("<option value=\""+ prefId +"\" selected>" + prefNameKanji + "</option>").insertBefore("#prefSelection option:first");
    }
    /*alerts zip to address (日本語版のみ2つチェックする)*/
    function zipToAddressAlert(){
      var col = getUsersData();

      var zipFirst = col["zipFirst"];
      var zipLast = col["zipLast"];
      selectAddressFromZip(zipFirst,zipLast);
    }
    /*message button before registeration*/
    function alertMessageStartRegister(){
      var col = getUsersData();
      var surName = col["surName"];
      var firstName = col["firstName"]; 
      var surNameYomi = col["surNameYomi"]; 
      var firstNameYomi = col["firstNameYomi"]; 
      var email = col["email"]; 
      var zipFirst = col["zipFirst"]; 
      var zipLast = col["zipLast"]; 
      var prefName = col["prefName"]; 
      var city = col["city"]; 
      var town = col["town"];
      var building = col["building"]; 
      var phoneFirst = col["phoneFirst"]; 
      var phoneSecond = col["phoneSecond"]; 
      var phoneThird = col["phoneThird"]; 
      $('#dialog').dialog(
      {
        width: 450,
        draggable: true,
        resizable: false,
        modal: true,
        position: [ 250, 50 ],
        overlay:
        {
          opacity: 0.5, 
          background: 'black' 
        },
        title: '確認',
        open: function(){
          $('#dialog').html(
            '<table border="1">' +
            '<tr><td>ご芳名</td><td>' + surName + ' ' + firstName + '</td></tr>' + 
            '<tr><td>よみがな</td><td>' + surNameYomi + ' ' + firstNameYomi + '</td></tr>' + 
            '<tr><td>Email</td><td>' + email + '</td></tr>' + 
            '<tr><td>郵便番号</td><td>' + zipFirst + '-' + zipLast + '</td></tr>' + 
            '<tr><td>県名</td><td>' + prefName + '</td></tr>' + 
            '<tr><td>市等</td><td>' + city + '</td></tr>' + 
            '<tr><td>町等</td><td>' + town + '</td></tr>' + 
            '<tr><td>ビル名等</td><td>' + building + '</td></tr>' + 
            '<tr><td>電話番号</td><td>' +  phoneFirst + '-' + phoneSecond + '-' + phoneThird + '</td></tr>' + 
            '</table>' + 
            'この内容で登録してもよろしいですか？'
          );
        },
        buttons:
        { 
          '登録する': function()
          {
            postPhpUserData();
          },
          '中止する': function()
          { 
            $('#dialog').dialog('close');
          }
        }
      });
    }

