<?php
	include '../includes/common.php';
	if (empty($_GET['id'])) {
		$_SESSION['bug'] = 'Apologies, unable to retrieve record';
		header('location: ' . WWW_ROOT  . 'error.php ');
		die();
	}
	$id = $_GET['id'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php
	include DIR_ROOT . 'includes/header.php';
	include  DIR_ROOT . 'includes/functions/database_connection.php';
	include  DIR_ROOT . 'includes/functions/do_pdo_query.php';
	include  DIR_ROOT . 'methods/user_methods.php';
	$hash = pdo_connect_hash();

	getToken();
	?>
</head>
<body id="page1">
	<div id="main">
		<!-- header -->
<?php
	//this includes will import the top navigation
	include DIR_ROOT . "includes/topnavigation.php";
?>
		<!-- content row 1 -->
		
	<div class="hero-unit">
        <form id="registration" class="form-horizontal" method='post' action='<?php echo WWW_ROOT; ?>users/userEdit_update.php'> 
		
        <fieldset>  
          <legend>Edit Page</legend> 
				
		  
		 <?php
			// id in the query string is required. Send to error page if missing.
			
			
			$get_hasher_stmt = getHasherById($hash, $id);
			$get_hasher_row = $get_hasher_stmt->fetch();
			$name = $get_hasher_row['name'];
			$email = $get_hasher_row['email'];
			$hashName = $get_hasher_row['hashName'];
			
			echo '
			<div class="control-group">
				<label class="control-label"  for="input01">user name:</label>  
				<div class="controls">  
					<input type=\'text\'  name=\'name\' id="name" data-trigger=\'focus\' 
					rel="popover" value="' . $name . '" data-content="Used only for log in purposes, 
					not a display name."   
					data-original-title="FYI" />   
				</div>   
			</div>';
			
			
			echo '
			<div class="control-group">
				<label class="control-label"  for="input01">hasher name:</label>
				<div class="controls">
					<input type=\'text\'  name=\'hashName\' id="hashName" data-trigger=\'focus\' 
					rel="popover" data-content="Let us know who you are so we know if you\'re a member."
					value= "' . $hashName . '" />
				</div>
			</div>';
			
			echo   '
			<div class="control-group">
				<label class="control-label"  for="input01">email:</label>
				<div class="controls">
					<input type=\'text\'  class="" name=\'email\' id=\'email\' data-trigger=\'focus\'
					rel="popover" data-content="For password reset only"
					data-original-title="don\'t worry" value="' . $email .'"/> 
				</div> 
			</div>';
				
			echo '<legend>Change Password</legend> 
			<div class="control-group">
				<label class="control-label"  name=\'password\' for="password">password:</label>
				<div class="controls">
					<input type=\'password\'  name=\'password\' id="password" data-trigger=\'focus\'  
					rel="popover" data-content="at least 6 characters long" /> 
				</div>
			</div>';
			
			echo '
			<div class="control-group">
				<label class="control-label" for="password">Re-enter password:</label>
				<div class="controls">
					<input type=\'password\'  name=\'password2\' id="password2" data-trigger=\'focus\' 
					rel="popover" data-content="at least 6 characters long"/>
					<p class="help-block"></p>					
				</div>
				<button type="submit" class="btn btn-primary" onclick=\'formSubmit()\' >Submit</button>
			</div>
			</fieldset>';
			
			echo getTokenField()
			. '<input type="hidden" name="id" value="'. $id.'" />'
		. '</form>'
	. '</div>';
		
	include DIR_ROOT . "includes/footer.html";
?>
</div>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo WWW_ROOT; ?>js/jquery-1.9.1.min.js"></script>
    <script src="<?php echo WWW_ROOT; ?>js/bootstrap.min.js"></script>

	<script>  
$(function() {
    $('[rel="popover"]').popover();
});
	</script>
</body>            
</html>