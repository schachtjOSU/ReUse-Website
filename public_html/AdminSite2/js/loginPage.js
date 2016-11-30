//User is logged out as soon as they arrive at the log in page.
// killSession();

function login(){

  /* get values from form */
  var user = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var type = "login"

  /* if no blanks, make the request and check for password match */
    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
      if(req.readyState == 4 && req.status == 200){

        /* add user to DB */
        if(req.responseText == 1){
        /* everything has passed! Session begin */
        window.location.href = "/AdminSite2/main.php";
        }

        /* false, errors. Notify  user, no addition to DB */
        if(req.responseText == 0){
            alert("Error: Incorrect user name or password.");
         }

         /* logged in already under another name */
         if(req.responseText == 3){
            killSession();
         }

         /* other errors */
        else if(req.responseText != 1 && req.responseText != 0){
          alert(req.responseText);
        }
      }
    }

    /* send to loginCheck.php for the session and db connection-- Calls function login() */
    req.open("POST","/AdminSite/loginCheck.php", true);
    req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var loginData ="type="+type+"&username="+user+"&password="+password;
    req.send(loginData);
}


/*
function killSession
purpose: Kill session
*/
// function killSession(){
//     var tableData = "killSession";
//     $.ajax({type:"POST",
//       url: "/AdminSite/loginCheck.php",
//       data: tableData,
//       success: function(data){
//         console.log("Success");
//       },
//     });
//   window.alert('Session already in progress. Logging out old user....')
//   logOut();
//   window.location.href = "/AdminSite2/loginPage.php";
// }
//
// function logOut(){
//     var type = "killSession";
//     req = new XMLHttpRequest();
//     req.onreadystatechange = function(){
//    		  if(req.readyState == 4 && req.status == 200){
//
// 	    	 if(req.responseText == 1){
//     	    	/* everything has passed! Yay! Go back to login page*/
//         		window.location.href = webURL + "loginPage.php";
//      		}
//
//         /* no specific instance for causing false, but if it's not true... tell me */
//      		else{
//           		document.getElementById("output2").innerHTML = req.responseText;
//      		}
//    		}
//   	}
//         /* send data to kill the sesions */
//         req.open("POST","loginCheck.php", true);
//         req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//         data = "type="+type;
//         req.send(data);
//   }
