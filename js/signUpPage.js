// DIAL CODE AND COUNTRY
$.get('https://www.cloudflare.com/cdn-cgi/trace', function(data) {
  data = data.trim().split('\n').reduce(function(obj, pair) {
    pair = pair.split('=');
    return obj[pair[0]] = pair[1], obj;
  }, {});

  const reg_dial_options = document.querySelectorAll('select[name=reg_phone_prefix]>option');
  const country_options = document.querySelectorAll('select[name=reg_country]>option');
  
  for (var i=0; i<reg_dial_options.length; i++) {
    if(reg_dial_options[i].getAttribute("data-explore-dial-country") == data.loc) {
        let wantedIndexDial = i;
        $("select[name=reg_phone_prefix]").prop("selectedIndex", wantedIndexDial);
        break;
      }
  }

  for (var j=0; j<country_options.length; j++) {
    if(country_options[j].getAttribute("value") == data.loc) {
        let wantedIndexCountry = j;
        $("select[name=reg_country]").prop("selectedIndex", wantedIndexCountry);
        break;
      }
  }
});

// DOB
var current_date = new Date();

new_year = (current_date.getFullYear() - 18);
if(current_date.getMonth() <10) {
  new_month = "0"+(current_date.getMonth() + 1);
} else {
  new_month = (current_date.getMonth() + 1);
}
if(current_date.getMonth() <10) {
  new_day = "0"+(current_date.getDate());
} else {
  new_day = current_date.getDate();
}

const new_date =  (new_year + '-' + new_month + '-' + new_day);
$("#reg_DOB").val(new_date);