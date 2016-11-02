/*************************************************************************************************
*                     Search for an Business
*************************************************************************************************/

/************************************
    YOUR WEBSITE HERE
************************************/
var webURL = "";

// globals
var y;
var x;
var z;
var a;
var b;
var d;
var e;
var f;
var g;

/*
function searchBusiness()
purpose: search business by name
*/
function searchBusiness(){
    $('#table').empty();
    var match = $('#searchName').val();
    $.ajax({type:"GET",
    url: webURL + "/ruAPI/business/" + match,
    dataType: 'json',
    success: function(data){
      $('#EditData').empty();
      $('#EditData1').empty();
      $('#EditData2').empty();
        console.log(match);
        var row = '<tr><th>' + 'Name' + '</th><th>' + 'Address' + '</th><th>' + 'Modify' + '</th><th>' + 'Delete' + '</th></tr>';
        for(var i = 0; i < data.length; i++){ 
            row += '<tr><td>' + data[i].name + '</td><td>' + data[i].address_line_1 + '</td><td>' + '<input type= hidden id= edit value=' + data[i].id + '><input type= submit value=Edit id=edit onclick=editBusiness()>' + '</td><td>' + '<input type= hidden id= delete value=' + data[i].id + '><input type= submit value=Delete id=del onclick=delItem()>' + '</td></tr>';
        }
        $('#table').append(row);
    },
  });
}

/*
function delItem()
purpose: delete business by id
*/
function delItem(){
    var match = $('#delete').val();
    console.log(match);
    $.ajax({
    type:"DELETE",
    url: webURL + "/ruAPI/business/" + match,
    dataType: 'json',
    success: function(data){
      console.log(data);
    }
  });
  $('#table').empty();
}

/*
function editBusiness()
purpose: edit any field of any business searched for previously by name
*/
function editBusiness(){
    var c = $('#searchName').val();
    x = c;
      var d ='<label class="control-label col-sm-2" for="text">' + 'Edit Information:' + '</label></br>';
      $('#EditData').html(d);
      $.ajax({type:"GET",
        url: webURL + "/ruAPI/business",
        dataType: 'json',
        success: function(data){
            var cat = "<select class='form-control' name='selectState' id='states' onChange='changeCat(this.value)'><option>Select Business</option>";
            for(var i = 0; i < data.length; i++){ 
              cat += "<option value = " + data[i].id + ">";
              cat += data[i].name;
              cat += "</option>";
            }
            cat += "</select>";
            $("#EditData1").append(cat);
        }
    });

    var sid;
    $.ajax({type:"GET",
        url: webURL + "/ruAPI/business/" + c,
        dataType: 'json',
        success: function(data){
          console.log("In success");
          $('#table').empty();
          sid = data[0].state_id;
          console.log(sid);
          var d= '<form class="form-horizontal" role="form" action="#" id="form1">';
          d += '<div class="form-group">';
          d += '<div class="col-sm-10">';
          x = data[0].name;
          var tempname = encodeURI(data[0].name);
          var tempadd = encodeURI(data[0].address_line_1);
          var tempadd2 = encodeURI(data[0].address_line_2);
          var tempcity = encodeURI(data[0].city);
          var bad = "%20";
          tempname = tempname.replace(/%20/g, "_");
          tempadd = tempadd.replace(/%20/g, "_");
          tempadd2 = tempadd2.replace(/%20/g, "_");
          tempcity = tempcity.replace(/%20/g, "_");
          d += '<input type ="text" class="form-control" Id="searchName" placeholder=' + 'Current:' + tempname + ' onChange="changeName(this.value)">';
          d += '<input type ="text" class="form-control" Id="searchAdd" placeholder=' + 'Current:' + tempadd + ' onChange="changeAdd(this.value)">';
          d += '<input type ="text" class="form-control" Id="searchAdd2" placeholder=' + 'Current:' + tempadd2 + ' onChange="changeAdd2(this.value)">';
          d += '<input type ="text" class="form-control" Id="searchCity" placeholder=' + 'Current:' + tempcity + ' onChange="changeCity(this.value)">';
          d += '</div></div>'       
          $('#EditData').append(d);
            $.ajax({type:"GET",
              url: webURL + "/ruAPI/states",
              dataType: 'json',
              success: function(data){
                  var states ='<form class="form-horizontal" role="form" action="#" id="form1">';
                  states += "<div class='form-group' style='margin-left: 0;'><div class='col-sm-10' style='margin-left: 0;''><select class='form-control' name='selectState' id='states' onChange=changeState(this.value)>";
                  for(var i = 0; i < data.length; i++){ 
                    if(data[i].id == sid){
                      states += "<option selected='selected' value = " + data[i].id + ">";
                    }
                    else{
                      states += "<option value = " + data[i].id + ">";
                    }
                    states += data[i].name;
                    states += "</option>";
                  }
                  states += "</select></div></div>";
                  $("#EditData").append(states);
              },
          });
        }
      });


    $.ajax({type:"GET",
        url: webURL + "/ruAPI/business/" + c,
        dataType: 'json',
        success: function(data){
          console.log("In success");
          $('#table').empty();
          var d= '<form class="form-horizontal" role="form" action="#" id="form1">';
          d += '<div class="form-group">';
          d += '<div class="col-sm-10">';
          d += '<input type ="text" class="form-control" Id="searchCity" placeholder=' + 'Current:' + data[0].zip_code + ' onChange="changeZip(this.value)">';   
          d += '<input type ="text" class="form-control" Id="searchPhone" placeholder=' + 'Current:' + data[0].phone + ' onChange="changePhone(this.value)">';
          d += '<input type ="text" class="form-control" Id="searchWebsite" placeholder=' + 'Current:' + data[0].website + ' onChange="changeWeb(this.value)">';
          $('#EditData').append(d);
        }
      });
      
      var cat = '</div></div></br><p align="center"><button Id ="submit" type ="submit" class="btn btn-primary" onclick="changeBusiness(); return false" align="center">Update Item</button></p>';
      cat += '</form>';
      $('#EditData2').html(cat);
}

/* helper functions for onchange events for fields to be changed */
function changeName(value) {
      y = value;
}

function changeAdd(value) {
      z = value;
}

function changeAdd2(value) {
      a = value;
}

function changeCity(value) {
      b = value;
}

function changeState(value) {
      d = value;
}

function changeZip(value) {
      e = value;
}

function changePhone(value) {
      f = value;
}

function changeWeb(value) {
      g = value;
}

/*
function cchangeBusiness()
purpose: sends new info to API for updating fields
*/
function changeBusiness(){

       var tableData = "name="+y+"&oldName="+x+"&add1="+z+"&add2="+a+"&city="+b+"&state="+d+"&zip="+e+"&phone="+f+"&website="+g;
        $.ajax({type:"POST",
            url: webURL + "/ruAPI/changeBusiness",
            data: tableData,
            success: function(){
              $('#form1').empty();
              $('#table').empty();
            },
        });
      $('#EditData').empty();
      $('#EditData1').empty();
      $('#EditData2').empty();
      var more = '<p><label>Update Items?</label></br><input type= submit value=Yes id=upItems onclick=editBusItems()><input type= submit value=No id=noUpItems onclick=clearAll()></p>'
      $('#EditData').html(more);
}

/*
function editBusItems()
purpose: displays items for addition of new or deletion of old
*/
function editBusItems(){
  $('#EditData').empty();
  $.ajax({type:"GET",
    url: webURL + "/ruAPI/items",
    dataType: 'json',
    success: function(data){
      window.alert("Select as many items as you'd like to be added to the Business.");
        var entry = '<input type = button value = DONE id = done onclick="clearAll()"" style="margin-right: 30px;">'
        $('#table').append(entry);
        var row = '<tr><th>' + 'Name' + '</th><th>'  + 'Add to Business or Delete from Business' + '</th></tr>';
        for(var i = 0; i < data.length; i++){ 
            row += '<tr><td>' + data[i].name + '</td><td>' + '<input type= hidden id= update1 value=' + data[i].id + '><input type= submit value=update id=update onclick=updateItem('+data[i].id+')>' + '</td>';
            row += '<td><input type= hidden id= delval1 value=' + data[i].id + '><input type= submit value=delete id=update onclick=delBusItem('+data[i].id+')>' + '</td></tr>';
        }
        $('#table').append(row);
    },
  });
}

/*
function delBusItem()
purpose: deletes item, many to many, from items business accepts
*/
function delBusItem(value){
  var name;
  if(y != null){
    name = y;
  }
  else{
    name = x;
  }
  console.log(name);
  //var item = document.getElementById("update1").value;
  var item = value;
  console.log(item);
  var tableData = "name="+name+"&items="+item;
    $.ajax({type:"DELETE",
      url: webURL + "/ruAPI/updateBusiness/" + name + "/" + item,
      //data: tableData,
      success: function(data){
        console.log(data);
      },
    });
  }    

/*
function updateItem()
purpose: adds new item to list of items business accepts, many to many
*/
function updateItem(value){
  var name;
  if(y != null){
    name = y;
  }
  else{
    name = x;
  }
  console.log(name);
  //var item = document.getElementById("update1").value;
  var item = value;
  console.log(item);
  var tableData = "name="+name+"&items="+item;

    $.ajax({type:"POST",
      url: webURL + "/ruAPI/updateBusiness",
      data: tableData,
      success: function(data){
        console.log(data);
      },
    });
  }  


/*
function clearAll()
purpose: table and div cleanup for new searches
*/
function clearAll(){
      $('#table').empty();   
      $('#EditData').empty();
      $('#EditData1').empty();
      $('#EditData2').empty();
      y = "";
}


/*
function checkSession()
purpose: makes sure a user is logged in with active session, or redirects
*/
function checkSession(){

    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
     if(req.readyState == 4 && req.status == 200){

        if(req.responseText == 1){
          /* everything has passed! Yay! Go into your session */
          window.alert("You are not logged in! You will be redirected.");
          window.location.href = webURL + "/AdminSite/loginPage.php";
        }
      }
    }

    /* send data to create table */
    req.open("POST","checkSession.php", true);
    req.send();
}
