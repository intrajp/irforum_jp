    /*post zip data to php script(日本語版は引数2つ) */
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
    }
    /*post user data to php script for update(日本語版のみ)*/
    function postPhpUserData(){
      var col = getUsersData();

      var userId = col["userId"]; 
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

      $.ajax({
        type: "POST",
        url:"/irforum/application/password/update",
        data:{ 
            "userId": userId, 
            "surName": surName,
            "firstName": firstName, 
            "surNameYomi": surNameYomi,
            "firstNameYomi": firstNameYomi, 
            "prefId": prefId, 
            "email": email, 
            "zipFirst": zipFirst, 
            "zipLast": zipLast, 
            "city": city, 
            "town": town, 
            "building": building, 
            "phoneFirst": phoneFirst, 
            "phoneSecond": phoneSecond, 
            "phoneThird": phoneThird, 
            },success:function(result){
              //if(result==""){
                alert("ユーザ情報が更新されました!");
                //alert(result);
                var url = "/irforum/application/password/index";    
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
    function deletePhpUserData(){
      var col = getUsersData();
      var userId = col["userId"]; 
      $.ajax({
        type: "POST",
        url:"/irforum/application/password/delete",
        data:{ 
            "userId": userId, 
            },success:function(result){
              //if(result==""){
                alert("ユーザ情報が削除されました!");
                //alert(result);
                var url = "/irforum/application/password/index";    
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

