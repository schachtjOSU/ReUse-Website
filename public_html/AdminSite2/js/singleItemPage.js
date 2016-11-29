var id = document.getElementById('idInput').value;
console.log("Page for item with id " + id);

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
    url: "/RUapi/items/"+ id,
    dataType: 'json',
    success: function(data) {
        for (var i = 0; i < data.length; i++) {
            var name, category_id;

            /*Name of item*/
            if(!data[i].name){
              name = 'Name missing';
            }
            else{
              name = data[i].name;
            }

            if(!data[i].category_id){
              category_id = 'Category id missing';
            }
            else{
              category_id = data[i].category_id;
            }

            /*fill the table (really ul) with each list item*/
            fillTable(name, category_id, id);
          }
    },
});

/**/
function fillTable(name, category_id, id){
  $("#thisList").append("\
     <li class='white-square' id='" + id + "'> \
       <span class='box-name'>" + name + " </span> \
       <div class='pull-right'> \
         <span class='below-line-container'>\
           <span class='below-line'>\
             <span class='lower-left-corner'>Category id: " + category_id + " </span> \
           </span> \
         </span> \
       </div>\
     </li>");
}
