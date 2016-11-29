var id = document.getElementById('idInput').value;
console.log("Page for item with id " + id);

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

            fillSquare(name, category_id, id);
          }
    },
});

/**/
function fillSquare(name, category_id, id){
  $("#thisList").append("\
     <li class='white-square' id='" +"thisTable" + "'> \
       <span class='box-name'> <input type='text' value=" + name + " disabled='disabled'><span class='whenDisabled'>" + name + "</span></span> \
       <div class='pull-right'> \
         <span class='below-line-container'>\
           <span class='below-line'>\
             <span class='lower-left-corner'>Category id: " + category_id + " </span> \
           </span> \
         </span> \
       </div>\
     </li>");
}
