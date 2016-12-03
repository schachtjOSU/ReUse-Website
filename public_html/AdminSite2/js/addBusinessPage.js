

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
                <button class='btn btn-primary' id='save'>save</button>\
            </span> \
          </span> \
        </div>\
      </li>");


      $("input").prop('disabled', false);
      $(".whenDisabled").hide();
      $(".whenEnabled").show();
      $("#save").show();
      $(".box-detail.grid-only").addClass("centerTime");
      $("span.below-line").addClass("centerPhone");
