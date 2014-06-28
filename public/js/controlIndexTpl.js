  /*post zip data to php script (日本語版は引数2つ)*/
  function selectAddressFromZip(zipFirst,zipLast){
    $.ajax({
      type: "POST",
      url:"/irforum/application/zip/index",
      data:{ 
          "zipFirst": zipFirst,
          "zipLast": zipLast, 
           },success:function(result){
            var address = result.split(",");
            var city = address[0];
            var town = address[1];
            var prefId = address[2];
            var prefNameKanji = address[3];
            setAddressFromZip(city,town,prefId,prefNameKanji);
      }
    });
    $(".prefSelection").css("backgroundColor", "lavender");
    $(".city").css("backgroundColor", "lavender");
    $(".town").css("backgroundColor", "lavender");
  }
  /*post user data to php script */
  function postPhpUserData(){
    var col = getUsersData();

    var surName = col["surName"];
    var firstName = col["firstName"]; 
    var surNameYomi = col["surNameYomi"]; 
    var firstNameYomi = col["firstNameYomi"]; 
    var email = col["email"]; 
    var zipFirst = col["zipFirst"]; 
    var zipLast = col["zipLast"]; 
    var prefId = col["prefId"]; 
    var city = col["city"]; 
    var town = col["town"];
    var building = col["building"]; 
    var phoneFirst = col["phoneFirst"]; 
    var phoneSecond = col["phoneSecond"]; 
    var phoneThird = col["phoneThird"]; 
    var forumId = col["forumId"]; 

    $.ajax({
      type: "POST",
      url:"/irforum/application/iruser/add",
      data:{ 
          "surName": surName,
          "firstName": firstName, 
          "surNameYomi": surNameYomi,
          "firstNameYomi": firstNameYomi, 
          "email": email, 
          "zipFirst": zipFirst, 
          "zipLast": zipLast, 
          "prefId": prefId, 
          "city": city, 
          "town": town, 
          "building": building, 
          "phoneFirst": phoneFirst, 
          "phoneSecond": phoneSecond, 
          "phoneThird": phoneThird, 
          "forumId": forumId, 
          },success:function(result){
            //if(result==""){
              $('#dialog').dialog('close');
              postPhpSendMail();
            //}else{
            //  alert(result);
            //}
          },error:function(XMLHttpRequest, textStatus, errorThrown ){
             alert(textStatus + "\n" + XMLHttpRequest.status +"\n"+ errorThrown.message);
         }
    });
  }
  /*send email and user name to php script */
  function postPhpSendMail(){
    var col = getUsersData();

    var surName = col["surName"];
    var firstName = col["firstName"];
    var email = col["email"];

    $.ajax({
      type: "POST",
      url:"/irforum/application/irmail/index",
      data:{
          "surName": surName,
          "firstName": firstName,
          "email": email,
          },success:function(result){
            //if(result==""){
              alert(surName + " " + firstName + "様, 御登録ありがとうございました!\n" + email + "にメールを送信しました!");
              var url = "/irforum";
              $(location).attr('href',url);
            //}else{
              //alert(result);
            //}
          },error:function(XMLHttpRequest, textStatus, errorThrown ){
              alert(textStatus + "\n" + XMLHttpRequest.status +"\n"+ errorThrown.message);
          }
    });
  }

