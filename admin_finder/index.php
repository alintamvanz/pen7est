<!DOCTYPE html>
<html>
<head>
	<title>Admin Finder - shutdown57</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/style.css">
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="jquery.min.js"></script>
</head>
<body>
<div class="container container-fluid">
<center>
<h1>Admin Finder</h1>
<form class="form-inline" style="margin-top:100px;" method="post" id="form">
  <div class="form-group">
    <label for="target">Target :</label>
    <input type="text" class="form-control" id="target" name="target">
  </div>
  <div class="form-group">
    <label for="method">Method </label>
    <select class="form-control" name="method">
    	<option value="http">Get HTTP Status</option>
    	<option value="curl">Get String On Target</option>
    </select>
  </div>
  <div class="form-group">
    <label for="target">Regex *):</label>
    <input type="text" class="form-control" id="regex" name="regex" placeholder="login|admin|username|password">
  </div>
  <button type="submit" class="btn btn-default" id="button">Let's Go !</button>
</form>
*) isi jika menggunakan Method Get String On Target
<div id="konten_adminfinder"></div>
</center>
<script type="text/javascript">
	$(document).ready(function(){
		$("#button").click(function(){
			$("#konten_adminfinder").html('<img src="load.gif" style="width:100px;height:100px"> Loading ...');
			$.ajax({
				type : 'POST',
				url : '__request.php',
				data : $("#form").serialize(),
				success:function(data){
					$("#konten_adminfinder").html(data);
				},error:function(data){
					alert("terjadi ke error an~");
				}
			});
			return false;
		});
	});
</script>
</div>
</body>
</html>
