<?php 
	require_once( 'includes/common.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<?php
		require_once(DIR_ROOT . 'includes/header.php');
	?>
</head>
<body id="page1">
	<?php
		require_once( DIR_ROOT . 'includes/topnavigation.php');
	?>

		<!-- content -->
<div class="hero-unit">
				<h1>404</h1>
				<p>
					
					<blockquote style=' border-top: 1px solid #ccc;
									border-bottom: 1px solid #ccc;
									color: #a5a4a4;
									font-style: italic;
									margin: 30px;
									padding: 30px;    
									text-align: center;'>
					"Oops, seems this file doesn't exist :("<br />
					
					</blockquote>
					
				</p>
				
			</div>	<!-- footer -->

		
	<!-- footer -->
	<?php
	include DIR_ROOT . "includes/footer.html";
?>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo WWW_ROOT; ?>js/jquery-1.9.1.min.js"></script>
    <script src="<?php echo WWW_ROOT; ?>js/bootstrap.min.js"></script>

</body>            
</html>