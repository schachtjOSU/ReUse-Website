/*************************************************************************************************
*                     Search for an Item
*************************************************************************************************/
/************************************
    YOUR WEBSITE HERE
************************************/
var webURL = "http://web.engr.oregonstate.edu/~masseyta/testApi";

//globals
var x;
var y;
var z;

/*
function: checkSession()
purpose: security, make sure a user is logged in
*/
function checkSession(){

    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
     if(req.readyState == 4 && req.status == 200){

        if(req.responseText == 1){
          /* everything has passed! Yay! Go into your session */
          window.alert("You are not logged in! You will be redirected.");
          window.location.href = webURL + "/loginPage.php";
        }
      }
    }

    /* send data to create table */
    req.open("POST","checkSession.php", true);
    req.send();
}

/*
function: searchItem()
purpose: find an item by name
*/
function searchItem(){
    $('#table').empty();
    $.ajax({type:"GET",
    url: webURL + "/index/items",
    dataType: 'json',
    success: function(data){
        var match = $('#searchName').val();
        x = match;
        var row = '<tr><th>' + 'Name' + '</th><th>' + 'Modify' + '</th><th>' + 'Delete' + '</th></tr>';
        for(var i = 0; i < data.length; i++){ 
         if(data[i].name == match){
            row += '<tr><td>' + data[i].name + '</td><td>' + '<input type= hidden id= edit value=' + data[i].id + '><input type= submit value=Edit id=edit onclick=editItem()>'  + '</td><td>' + '<input type= hidden id= delete value=' + data[i].id + '><input type= submit value=Delete id=del onclick=delItem()>' + '</td></tr>';
         }
        }
        $('#table').append(row);
    },
  });
}

/*
function: delItem()
purpose: delete an item by id
*/
function delItem(){
    var match = $('#delete').val();
    $.ajax({type:"DELETE",
    url: webURL + "/index/item/" + match,
    dataType: 'json',
    success: function(data){
    }
  });
    $('#EditData').empty();
    $('#EditData1').empty();
    $('#EditData2').empty();
    document.getElementById("edItem").reset();  
    $('#table').empty();   
}

/*
function: editItem()
purpose: find an item by name
*/
function editItem(){
    $('#EditData').empty();
    $('#EditData1').empty();
    $('#EditData2').empty();
    document.getElementById("edItem").reset();   
    var c = $('#edit').val();

      $.ajax({type:"GET",
        url: webURL + "/index/category",
        dataType: 'json',
        success: function(data){
            var cat = "<div class='col-sm-10'><select class='form-control' name='selectState' id='states' onChange='changeCat(this.value)'><option>Select Category</option>";
            for(var i = 0; i < data.length; i++){ 
              cat += "<option value = " + data[i].id + ">";
              cat += data[i].name;
              cat += "</option>";
            }
            cat += "</select>";
            $("#EditData1").append(cat);
            formdata = '</div></div></div></br><p align="center"><button Id ="submit" type ="submit" class="btn btn-primary" onclick="changeItem(); return false" align="center">Update Item</button></div></p>';
            formdata += '</form>';
            $('#EditData2').append(formdata);
        }
    });

    $.ajax({type:"GET",
        url: webURL + "/index/items/" + c,
        dataType: 'json',
        success: function(data){
          var tempname = encodeURI(data[0].name);
          var bad = "%20";
          tempname = tempname.replace(/%20/g, "_");

          $('#table').empty();
          var d= '<form class="form-horizontal" role="form" action="#" id="form1">';
          d += '<div class="form-group">';
          d += '<div class="col-sm-10">';
          d += '<label class="control-label col-sm-2" for="text">' + 'Edit Information:' + '</label></br></br>';
          d += '<div class="col-sm-10">';
          d += '<input type ="text" class="form-control" Id="searchName" placeholder=' + 'Current:' + tempname + ' onChange="changeName(this.value)">';
          $('#EditData').append(d);

        }
      });

}

/* helper functions for onChange events */
function changeName(value) {
      y = value;
}

function changeCat(value) {
      z = value;
}

/*
function: changeItem()
purpose: Change item values for any field
*/
function changeItem(){

       var tableData = "name="+y+"&oldName="+x+"&cat="+z;
        $.ajax({type:"POST",
            url: webURL + "/index/changeItem",
            data: tableData,
            success: function(){
              $('#form1').empty();
              $('#table').empty();
            },
        });
      $('#EditData').empty();
      $('#EditData1').empty();
      $('#EditData2').empty();
}
