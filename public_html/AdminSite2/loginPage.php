<head>
   <meta charset="UTF-8">
   <title>Login Form</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
   <link rel="stylesheet" type="text/css" href="css/loginPage.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>
<body>
   <div class="login">
      <h1>Login</h1>
      <form method="post" action="main.php">
         <input type="text" name="u" placeholder="Username" required="required" />
         <input type="password" name="p" placeholder="Password" required="required" />
         <button type="submit" class="btn btn-primary btn-block btn-large">Let me in.</button>
      </form>
   </div>
</body>
</html>
