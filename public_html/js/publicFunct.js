function displayCategories(){
    $.ajax({type:"GET",
      url: webURL + "/publicIndex/category",
      dataType: 'json',
      success: function(data){
          var cat = "<select class='form-control' name='selectCat' id='cats'><option>Search By Category:</option>";
          for(var i = 0; i < data.length; i++){ 
            cat += "<option value = " + data[i].id + ">";
            cat += data[i].name;
            cat += "</option>";
          }
          cat += "</select>";
          $("#categories").html(cat);
      },
    });
  }

function displayItems(){
    $.ajax({type:"GET",
      url: webURL + "/publicIndex/items",
      dataType: 'json',
      success: function(data){
          var cat = "<select class='form-control' name='selectCat' id='ccats'><option>Search By Item:</option>";
          for(var i = 0; i < data.length; i++){ 
            cat += "<option value = " + data[i].id + ">";
            cat += data[i].name;
            cat += "</option>";
          }
          cat += "</select>";
          $("#items").html(cat);
      },
    });
  }

function getBusByCat(){
    $('#table').empty();
    var match = $('#cats').val();
    $.ajax({type:"GET",
    url: webURL + "/publicIndex/businessCat/" + match,
    dataType: 'json',
    success: function(data){
        console.log(match);
        var row = '<tr><th>' + 'Name' + '</th><th>' + 'Address' + '</th><th>' + 'phone' + '</th><th>' + 'map' + '</th></tr>';
        for(var i = 0; i < data.length; i++){ 
            row += '<tr><td>' + data[i].name + '</td><td>' + data[i].address_line_1 + '</td><td>' + data[i].phone + '</td><td>' + '<input type= submit value=Directions id=goMap onclick=goMapCat('+ data[i].name +')>' + '</td></tr>';
        }
        $('#table').append(row);
    },
  });
}

function goMapCat(value){
    $('#table').empty();
    var match = value;
    $.ajax({type:"GET",
    url: webURL + "/publicIndex/business/" + match,
    dataType: 'json',
    success: function(data){
        var address = data[i].address_line_1;
        var city = data[i].city;
        
    },
  });
}
