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
  <li class='white-square' id='" +"thisTable" + "'> \
    <span class='box-name'>\
     <input name='name' type='text' value='" + name + "' disabled='disabled'>\
     <button class='btn btn-primary' id='save'>save</button>\
     <span class='whenDisabled'>" + name + "</span>\
    </span> \
    <div class='pull-right'> \
      <span class='below-line-container'>\
        <span class='below-line'>\
        <span class='lower-left-corner'>\
           \
         <div class='whenEnabled' style='margin-right: 20%;'>\
             <label for='" + category_id + "'>Category id: </label>  \
             <input name='cat' class='catId' type='text' value='" + category_id + "' disabled='disabled'>\
         </div>\
         <span class='whenDisabled'> Category ID: " + category_id + "</span>\
         </span> \
        </span> \
      </span> \
    </div>\
  </li>");
}
