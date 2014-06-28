    /*jinmei check*/
    function isValidJinmei(jinmei) {
      var pattern = new RegExp(/^[ぁ-んァ-ヶー一-龠 　\r\n\t]+?$/g);
      return pattern.test(jinmei);
    }
    /*hiragana check*/
    function isValidHiragana(hiragana) {
      var pattern = new RegExp(/^([あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわゐゑをんがぎぐげござじずぜぞだぢづでどばびぶべぼぱぴぷぺぽぁぃぅぇぉっゃゅょゎ・ー　])+?$/g);
      return pattern.test(hiragana);
    }
    /*email check*/
    function isValidEmailAddress(emailAddress) {
      var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
      return pattern.test(emailAddress);
    }
    /*phone number check*/
    function isValidPrefId(prefId) {
      var pattern = new RegExp(/[1-47]/);
      return pattern.test(prefId);
    }
    /*phone number check*/
    function isValidPhoneNumber(phoneNumber) {
      //var pattern = new RegExp(/[0-9-()+]{1,20}/i);
      var pattern = new RegExp(/[0-9]{1,4}/i);
      return pattern.test(phoneNumber);
    }
    /*zip code check*/
    function isValidZipCodeFirst(zipCode) {
      var pattern = new RegExp(/[0-9]{3,3}/i);
      return pattern.test(zipCode);
    }
    function isValidZipCodeSecond(zipCode) {
      var pattern = new RegExp(/[0-9]{4,4}/i);
      return pattern.test(zipCode);
    }
    /*address check*/
    function isValidAddress(address) {
      var pattern = new RegExp(/^[a-zA-Z0-9ぁ-んァ-ヶー一-龠 　\r\n\t]+?$/g);
      return pattern.test(address);
    }
    /*LoginName check*/
    function isValidLoginName(loginName) {
      var pattern = new RegExp(/[a-zA-Z0-9]{4,32}/);
      return pattern.test(loginName);
    }
    /*Password check*/
    function isValidPassword(password) {
      var pattern = new RegExp(/[a-zA-Z0-9]{8,16}/);
      return pattern.test(password);
    }
    /*date check*/
    function isValidDate(date) {
      var pattern = new RegExp(/[0-9\/\-]+?$/);
      return pattern.test(date);
    }
    /*title check*/
    function isValidTitle(title) {
      var pattern = new RegExp(/^[a-zA-Z0-9ぁ-んァ-ヶー一-龠 　\r\n\t]+?$/g);
      return pattern.test(title);
    }

