<?php
	include '../includes/common.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php
	include DIR_ROOT . 'includes/header.php';
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
        <form id="registration" class="form-horizontal" method='post' action='newUser.php'> 
		
        <fieldset>  
          <legend>Registration</legend> 
				
		  
		 <?php
			// if any errors from newUser.php - display messages here.
			if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
				foreach ($_SESSION['errors'] as $errorMessage) {			
					echo '<div class="alert alert-error">  
					<a class="close" data-dismiss="alert">x</a>  
					<strong></strong>' . $errorMessage . '  
					</div>';
				}
			}
			//reset errors 
			$_SESSION['errors'] = NULL;
			$_SESSION['errors'] = array();

		 ?>
		 <p></p>
          <div class="control-group">  
            <label class="control-label"  for="input01">user name:</label>  
            <div class="controls">                
			  
			  <input type='text'  name='name' id="name" data-trigger='focus' 
				rel="popover" data-content="Used only for log in purposes, not a display name." 
				data-original-title="FYI" />
			  
              <p class="help-block"></p>  
            </div>  
          </div>
		  
		  <div class="control-group">  
            <label class="control-label"  for="input01">hash name:</label>  
            <div class="controls">                
			  
			  <input type='text'  name='hashName' id="hashName" data-trigger='focus' 
				rel="popover" data-content="Let us know who you are so we know if you're a member." 
				data-original-title="" />
			  
              <p class="help-block"></p>  
            </div>  
          </div>
		  

          <div class="control-group">  
            <label class="control-label"  name='password' for="password">password:</label>  
            <div class="controls">  
			
			  <input type='password'  name='password' id="password" data-trigger='focus' 
				rel="popover" data-content="at least 6 characters long" 
				data-original-title="" />

			
              <p class="help-block"></p>  
            </div>  
          </div>  
		  
		<div class="control-group">  
            <label class="control-label"  for="input01">email:</label>  
            <div class="controls">  
				
				
				
			  <input type='text'  class="" name='email' id='email' data-trigger='focus' 
				rel="popover" data-content="For password reset only" 
				data-original-title="don't worry" />
						          
              <p class="help-block"></p>  
            </div>  
          </div> 

            <button type="submit" class="btn btn-primary" onclick='formSubmit()' >Submit</button>  
             
          </div> 
        </fieldset>  
		<?php 
		
		echo getTokenField(); 
		?>
		</form>  
      </div>
	  

	
	<!-- footer -->
	<?php
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