<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );


if(isset($_POST['submit']))
{
	$package=$_POST['package'];
	$price=$_POST['price'];

	   
	$id=intval($_GET['id']);
$sql=mysqli_query($con,"UPDATE `package` SET `package` = '$package', `price` = '$price' WHERE `package`.`id` = '$id'");
//move_uploaded_file($_FILES["productimage1"]["tmp_name"],"../img/blog/".$productimage1);
$_SESSION['msg']="Package Updated !!";

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin| Package edit</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body>
<?php include('include/header.php');?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
<?php include('include/sidebar.php');?>				
			<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Edit Package</h3>
							</div>
							<div class="module-body">

									<?php if(isset($_POST['submit']))
{?>
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
									</div>
<?php } ?>


									<br />

			<form class="form-horizontal row-fluid" name="Category" enctype="multipart/form-data"  method="post" >
<?php
$id=intval($_GET['id']);
$query=mysqli_query($con,"select * from package where id='$id'");
while($row=mysqli_fetch_array($query))
{
?>				

<div class="control-group">
<label class="control-label" for="basicinput">Day</label>
<div class="controls">
<select name="products" class="" onChange="getSubcat(this.value);"  required>
<?php $query1=mysqli_query($con,"select * from products");
while($row1=mysqli_fetch_array($query1))
{?>

<option value="<?php echo $row1['id'];?>"><?php echo $row1['productName'];?></option>
<?php } ?>
</select>
</div>
</div>






<div class="control-group">
<label class="control-label" for="basicinput">Day</label>
<div class="controls">
<input type="text"   name="package" value="<?php echo  htmlentities($row['package']);?>" class="" required>
</div>
</div>

<div class="control-group">
<label class="control-label" for="basicinput">Title</label>
<div class="controls">
<input type="text"  name="price" value="<?php echo  htmlentities($row['price']);?>" class="" required>
</div>
</div>
 


									<?php } ?>	

	<div class="control-group">
											<div class="controls">
												<button type="submit" name="submit" class="btn">Update</button>
											</div>
										</div>
									</form>
							</div>
						</div>


						

						
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

<?php include('include/footer.php');?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
</body>
<?php } ?>