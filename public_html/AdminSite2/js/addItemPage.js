



//This will hold the function to add
var thisaddFunction;

/*Function to set the event listeners*/
setAddButtonListener = function(){
 var addButton = document.getElementById('add');
 makeaddFunction(addButton);
 addButton.addEventListener('click', thisaddFunction, false);
}

/*Function to set a memebr of the clickListenersForSquares[] array
to a particular function*/
makeaddFunction = function(addButton){

   thisaddFunction = function(){
     var newName = $('#name').val();
     var cat = $('#cat').val();

     payload = {};
     payload.name = newName;
     payload.cat = cat;

     $.ajax({
         type: "POST",
         url: "/RUapi/items",
         data: payload,
         dataType: 'json',
         success: function(data) {

         }
     });
     location.reload();
 }; //End of thisaddFunction defintion

}


$("#thisList").append("\
   <li class='white-square' id='" +"thisTable" + "'> \
     <span class='box-name'>\
      <input name='name' type='text' id='name'>\
      <button class='btn btn-primary' id='add'>add</button>\
     </span> \
     <div class='pull-right'> \
       <span class='below-line-container'>\
         <span class='below-line'>\
         <span class='lower-left-corner'>\
            \
          <div class='whenDisabled' style='margin-right: 20%;'>\
              <label id='cat' for='" + ''+ "'>Category id: </label>  \
              <input name='cat' class='catId' type='text'>\
          </div>\
          </span> \
         </span> \
       </span> \
     </div>\
   </li>");

   setAddButtonListener();
 
