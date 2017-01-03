

/**/

/*Add list item to list in allBusinessesPage.php*/
 $("#thisList").append("\
 <li class='white-square'> \
      <span class='box-name'>\
        <input name='name_input' type='text' id='name_input' placeholder='name'>\
       </span> \
       <span class='box-detail grid-only'>\
        <input placeholder='address line 1' name='address_line_1_input' type='text' id='address_line_1_input''>\
       </span> \
        <div>\
          <span class='box-detail grid-only'>\
            <input placeholder='address line 2' name='address_line_2_input' type='text' id='address_line_2_input'> \
          </span>\
        </div>\
        <div>\
          <span class='box-detail grid-only'>\
            <input placeholder='zip_code_input' name='zipInput' type='text' id='zip_code_input'>\
          </span>\
        </div>\
        <span class='box-detail grid-only'> \
        <input placeholder='website' name='website_input' type='text' id='website_input'>\
        </span> \
        <span class='below-line-container'>\
          <span class='below-line'>\
          <input placeholder='phone number' name='phone_input' type='text' id='phone_input'>\
            <span class='lower-left-corner'>\
              <button class='btn btn-primary' id='add'>Save</button>\
          </span> \
        </span> \
      </div>\
    </li>");



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
           console.log("Pressed");
           var newName = $('#name_input').val();

           payload = {};
           payload.name = newName;

           $.ajax({
               type: "POST",
               url: "/RUapi/business",
               data: payload,
               dataType: 'json',
               success: function(data) {

               }
           });
           window.location.href = '../adminSite2/allBusinessesPage.php';
       }; //End of thisaddFunction defintion

      }

          $("input").prop('disabled', false);
          $(".whenDisabled").hide();
          $(".whenEnabled").show();
          $(".box-detail.grid-only").addClass("centerTime");
          $("span.below-line").addClass("centerPhone");


          setAddButtonListener();
