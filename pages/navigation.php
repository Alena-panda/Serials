<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <style>
body {
    font-family: "Lato", sans-serif;
}
.sidenav {
    width: 155px;
    position: fixed;
    z-index: 1;
    top: 20px;
    left: 10px;
    background: #eee;
    overflow-x: hidden;
    padding: 8px 0;
}
.sidenav a {
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    font-size: 25px;
    color: #F4A900;
    text-shadow: 1px 0 1px #000, 
    0 1px 1px #000, 
    -1px 0 1px #000, 
    0 -1px 1px #000;
    display: block;
}
.sidenav a:hover {
    color: #064579;
}
.main {
    margin-left: 140px; /* Same width as the sidebar + left position in px */
    font-size: 28px; /* Increased text to enable scrolling */
    padding: 0px 10px;
}
@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
}
    </style>
</head>
<body>
    <title>Welcome!</title>

<div class="sidenav">
<!-- <a class="btn btn-outline-success" href="index.php?page=1">Search</a> -->
  <a href="index.php?page=1">Home</a>
  <a href="index.php?page=2">Registration</a>
  <a href="index.php?page=3">Product</a>
  <a href="index.php?page=4">Entry</a>
  <a href="index.php?page=5">Cart</a>
</div>
</body>
</html>
