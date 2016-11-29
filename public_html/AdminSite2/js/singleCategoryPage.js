var category_id = document.getElementById('idInput').value;
console.log("Page for category with id " + category_id);

/*Set the togglers*/
$(function() {
  return $('[data-toggle]').on('click', function() {
    var toggle;
    toggle = $(this).addClass('active').attr('data-toggle');
    $(this).siblings('[data-toggle]').removeClass('active');
    return $('.list-elements').removeClass('grid list').addClass(toggle);
  });
});

/*Get the item*/
$.ajax({
    type: "GET",
    url: "/RUapi/category/"+ category_id,
    dataType: 'json',
    success: function(data) {
        for (var i = 0; i < data.length; i++) {
            var name;

            /*Name of category*/
            if(!data[i].name){
              name = 'Name missing';
            }
            else{
              name = data[i].name;
              console.log(name)
            }
            fillTable(name, category_id);
          }
    },
});

/**/
function fillTable(name, category_id){
  $("#thisList").append("\
     <li class='white-square' id='" + category_id + "'> \
       <span class='box-name'>" + name + " </span> \
       <div class='pull-right'> \
         <span class='below-line-container'>\
           <span class='below-line'>\
             <span class='lower-left-corner'>This category has an id of " + category_id + " </span> \
           </span> \
         </span> \
       </div>\
     </li>");
}