<!DOCTYPE HTML>
<html>
<head>
   <title>Better Campus Map</title>
	<link rel="stylesheet" href="styles/ui.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="styles/master.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link href='http://fonts.googleapis.com/css?family=Mako' rel='stylesheet' type='text/css'>
	
	<link href="styles/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
	<link href="styles/main.css" rel="stylesheet" type="text/css" />
	
	<script src="scripts/zynga-scroller/Animate.js" type="text/javascript" charset="utf-8"></script>
   <script src="scripts/zynga-scroller/Scroller.js" type="text/javascript" charset="utf-8"></script>

	<!-- Common Library -->
	<script src="scripts/zynga-scroller/common/Engine.js" type="text/javascript" charset="utf-8"></script>
	<script src="scripts/zynga-scroller/common/Style.js" type="text/javascript" charset="utf-8"></script>
	
	<script type="text/javascript" src="scripts/jquery-1.5.2.min.js"></script>
	<script type="text/javascript" src="scripts/jquery-ui.min.js"></script>
   <script type="text/javascript" src="scripts/jquery.autocomplete.pack.js"></script>
   <script type="text/javascript" src="scripts/script.js"></script>
</head>
<body>
   <div id="holder">
      <div id="header">
         <div id="logo"><a href="index.php"><img src="images/logo.png" width="131" height="93" alt="Logo" border="0"></a></div>
         <div id="search">
				<form action="search.php" method="post">
            	<input id="building" type="text" autocomplete="off" name="searchterm">
               <input class="sub" type="submit" />
            </form>
         </div>
         <div class="clear"></div>
      </div>
      <div id="main">