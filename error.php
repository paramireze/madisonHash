<?php
include 'includes/common.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php
include DIR_ROOT . 'includes/header.php';
?>
</head>
<body id="page1">
	
	<?php
		include 'includes/topnavigation.php';
	?>
	
	<div class="hero-unit">
        
		
        
          <legend>Error!</legend> 
		  <?php
				
					echo $_SESSION['bug'];
				
		  ?>
		  <br />
		  
			If the problem persists, send an email to webmaster@madisonh3.com
			
	</div>
	<!-- content -->
	
	<!-- footer -->
	<?php
	include  DIR_ROOT . "includes/footer.html";
?>
</div>
    
    
    <script src="<?php echo WWW_ROOT; ?>js/jquery-1.9.1.min.js"></script>
    <script src="<?php echo WWW_ROOT; ?>js/bootstrap.min.js"></script>


</body>            
</html>