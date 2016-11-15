/*************************************************************************************************
 *                     Search for an Business
 *************************************************************************************************/
/************************************
    YOUR WEBSITE HERE
************************************/
var webURL = "";
//var webURL = "http://localhost/Corvallis-Sustainability-ReUse/public_html/index.php"; //used for local development by Lauren Miller

/*This happens when the user presses save in the edit view*/

function saveClicked() {
    var payload = {};
    payload.oldName = document.getElementById('inputHidden').value;
    payload.name = document.getElementById('name').value;
    payload.add1 = document.getElementById('add1').value;
    payload.add2 = document.getElementById('add2').value;
    payload.city = document.getElementById('city').value;
    payload.zip = document.getElementById('zip').value;
    payload.phone = document.getElementById('phone').value;
    payload.state = '' + $('#selectState').find("option:selected").val();
    payload.website = document.getElementById('website').value;

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: webURL + "/RUapi/changeBusiness",
        data: payload,
        success: function() {
            $('instructions').innerHTML = "Edit or Remove any of the businesses listed below, or search for one in our search box!";
            $('#editFields').hide();
            $('#searchBox').show();
            clearAll();
            allBusinesses();
        },
        error: function(xhr, status, error) {
            alert("Status: " + status);
            alert(xhr.responseText);
        }

    });
    event.preventDefault();
}

/*
function searchBusiness()
purpose: search business by name
*/
function searchBusiness() {
    var match = $('#searchName').val();
    $.ajax({
        type: "GET",
        url: webURL + "/RUapi/business/" + match,
        dataType: 'json',
        success: function(data) {
            $('#EditData').empty();
            $('#EditData1').empty();
            $('#EditData2').empty();
            var row = '<tr><th>' + 'Name' + '</th><th>' + 'Address' + '</th><th>' + 'Modify' + '</th><th>' + 'Delete' + '</th></tr>';
            for (var i = 0; i < data.length; i++) {
                row += '<tr><td>' + data[i].name + '</td><td>' + data[i].address_line_1 + '</td><td>' + '<input type= hidden id= edit value=' + data[i].id + '><input type= submit value=Edit id=edit onclick=editBusiness()>' + '</td><td>' + '<input type= hidden id= delete value=' + data[i].id + '><input type= submit value=Delete id=del onclick=delItem()>' + '</td></tr>';
            }
            $('#table').append(row);
        },
    });

}
/*
function allBusinesses()
purpose: display all businesses
*/
function allBusinesses() {
    clearAll();
    $('#table').empty();
    // var match = $('#searchName').val();
    $.ajax({
        type: "GET",
        url: webURL + "/RUapi/business",
        dataType: 'json',
        success: function(data) {
            $('#EditData').empty();
            $('#EditData1').empty();
            $('#EditData2').empty();
            var row = '<tr><th>' + 'Name' + '</th><th>' + 'Address' + '</th><th>' + 'Modify' + '</th><th>' + 'Delete' + '</th></tr>';
            for (var i = 0; i < data.length; i++) {
                row += '<tr><td>' + data[i].name + '</td><td>' + data[i].address_line_1 + '</td><td>' + "<button value='" + data[i].name + "' type=submit id=edit onclick='searchBusinessHelper(this.value); return false;'>" + 'Edit' + "</button>" + '</td><td>' + '<input type= hidden id= delete value=' + data[i].id + '><input type= submit value=Delete id=del onclick=delItem()>' + '</td>' + '</tr>';
            }
            $('#table').append(row);
        },
    });
}

// /*
// function searchBusiness()
// purpose: function to call searchBusiness when one of the list businesses is selected
// */
function searchBusinessHelper(name) {
    $('#table').empty();
    $('#searchName')[0].value = '' + name + '';
    searchBusiness();
}


/*
function delItem()
purpose: delete business by id
*/
function delItem() {
    var match = $('#delete').val();
    console.log(match);
    $.ajax({
        type: "DELETE",
        url: webURL + "/RUapi/business/" + match,
        dataType: 'json',
        success: function(data) {
            console.log(data);
        }
    });
    $('#table').empty();
}

function getStatesDropdown(state_id) {
    $.ajax({
        type: "GET",
        url: webURL + "/RUapi/states",
        dataType: 'json',
        success: function(data) {
         var optionsList = "<select class='form-control' id='selectState' name='selectState' id='states'><option>Select State</option>";

          //  var optionsList = "<select class='form-control' id='selectState' name='selectState' onChange='changeState()' id='states'><option>Select State</option>";
            for (var i = 0; i < data.length; i++) {
              /*From colleen: I had to take this part out because it causes
              whatever option i run the if-statement on (the previous choice for
            state) it still thinks that that option is 'selected' later and doesnt
              change the state.
              This happens even if i don't include the line that you see with
              "6 slashmarks" next to it below.
              */
                // if(data[i].id = state_id){
                //   $('#basic-addonStatesHere').innerHTML = 'Was: ' + data[i].name; + '';
                //////@@@@   optionsList += "<option selected='false' value = " + data[i].id + ">";
              // }
                // else{
                  optionsList += "<option value = " + data[i].id + ">";
              // }
                optionsList += data[i].name;
                optionsList += "</option>";
            }
            optionsList += "</select>";
            $("#statesHere").append(optionsList);
        }
    });
}

/*
function editBusiness()
purpose: edit any field of any business searched for previously by name
*/
function editBusiness() {
    $('#searchForm').hide();
    clearAll();
    $('#editFields').show();
    var nameOfBizToEdit =  $('#searchName').val();


    //Fill the search forms with data
    $.ajax({
        type: "GET",
        url: webURL + "/RUapi/business/" + nameOfBizToEdit,
        dataType: 'json',
        success: function(data) {
            $('#name')[0].value = '' + data[0].name; + '';
            $('#basic-addonName')[0].innerHTML = 'Was: ' + data[0].name; + '';
            $('#inputHidden')[0].value = '' + data[0].name; + '';
            $('#oldName')[0].innerHTML = 'Edit data for business ' + data[0].name;+ '';

            $('#add1')[0].value = '' + data[0].address_line_1 + '';
            $('#basic-addonAddress1')[0].innerHTML = 'Was: ' + data[0].address_line_1 + '';

            $('#add2')[0].value = '' + data[0].address_line_2 + '';
            $('#basic-addonAddress2')[0].innerHTML = 'Was: ' + data[0].address_line_2 + '';

            $('#city')[0].value = '' + data[0].city + '';
            $('#basic-addonCity')[0].innerHTML = 'Was: ' + data[0].city + '';

            $('#zip')[0].value = '' + data[0].zip_code + '';
            $('#basic-addonZip')[0].innerHTML = 'Was: ' + data[0].zip_code + '';

            $('#phone')[0].value = '' + data[0].phone + '';
            $('#basic-addonPhone')[0].innerHTML = 'Was: ' + data[0].phone + '';

            $('#website')[0].value = '' + data[0].website + '';
            $('#basic-addonWebsite')[0].innerHTML = 'Was: ' + data[0].website + '';

            $('#state')[0].value = '' + data[0].state_id + '';
            $('#basic-addonState')[0].innerHTML = 'Was: ' + data[0].state_id + '';

            // $('#basic-addonStatesHere')[0].innerHTML = 'Was: ' + data[0].state_id; + '';

            getStatesDropdown(data[0].state_id);
        }
    });
}

/*
function editBusItems()
purpose: displays items for addition of new or deletion of old
*/
function editBusItems() {
    $('#EditData').empty();
    $.ajax({
        type: "GET",
        url: webURL + "/RUapi/items",
        dataType: 'json',
        success: function(data) {
            window.alert("Select as many items as you'd like to be added to the Business.");
            var entry = '<input type = button value = DONE id = done onclick="clearAll()"" style="margin-right: 30px;">'
            $('#table').append(entry);
            var row = '<tr><th>' + 'Name' + '</th><th>' + 'Add to Business or Delete from Business' + '</th></tr>';
            for (var i = 0; i < data.length; i++) {
                row += '<tr><td>' + data[i].name + '</td><td>' + '<input type= hidden id= update1 value=' + data[i].id + '><input type= submit value=update id=update onclick=updateItem(' + data[i].id + ')>' + '</td>';
                row += '<td><input type= hidden id= delval1 value=' + data[i].id + '><input type= submit value=delete id=update onclick=delBusItem(' + data[i].id + ')>' + '</td></tr>';
            }
            $('#table').append(row);
        },
    });
}

/*
function delBusItem()
purpose: deletes item, many to many, from items business accepts
*/
function delBusItem(value) {
    var name;
    if (y != null) {
        name = y;
    } else {
        name = x;
    }
    console.log(name);
    //var item = document.getElementById("update1").value;
    var item = value;
    console.log(item);
    var tableData = "name=" + name + "&items=" + item;
    $.ajax({
        type: "DELETE",
        url: webURL + "/RUapi/updateBusiness/" + name + "/" + item,
        //data: tableData,
        success: function(data) {
            console.log(data);
        },
    });
}

/*
function updateItem()
purpose: adds new item to list of items business accepts, many to many
*/

function updateItem(value) {
    var name;
    if (y != null) {
        name = y;
    } else {
        name = x;
    }
    console.log(name);
    //var item = document.getElementById("update1").value;
    var item = value;
    console.log(item);
    var tableData = "name=" + name + "&items=" + item;

    $.ajax({
        type: "POST",
        url: webURL + "/RUapi/updateBusiness",
        data: tableData,
        success: function(data) {
            console.log(data);
        },
    });
}


/*
function clearAll()
purpose: table and div cleanup for new searches
*/
function clearAll() {
    $('#table').empty();
    $('#statesHere').empty();
    $('#EditData').empty();
    $('#EditData1').empty();
    $('#EditData2').empty();
}


/*
function checkSession()
purpose: makes sure a user is logged in with active session, or redirects
*/
function checkSession() {

    req = new XMLHttpRequest();
    req.onreadystatechange = function() {
        if (req.readyState == 4 && req.status == 200) {

            if (req.responseText == 1) {
                /* everything has passed! Yay! Go into your session */
                window.alert("You are not logged in! You will be redirected.");
                window.location.href = webURL + "loginPage.php";
            }
        }
    }

    /* send data to create table */
    req.open("POST", "checkSession.php", true);
    req.send();
}
