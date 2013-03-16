<?php
include 'includes/common.php';
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
?>

</head>
<body id="page1">
	
	<?php
		include 'includes/topnavigation.php';
		
		function displayStuff($get_all_hashers_stmt) {
			while ($get_all_hashers_row = $get_all_hashers_stmt->fetch()) {
				$name = $get_all_hashers_row['name'];
				$hashName = $get_all_hashers_row['hashName'];
				$role = $get_all_hashers_row['role'];
				$email = $get_all_hashers_row['email'];
				$id = $get_all_hashers_row['user_id'];
				echo 	'<tr>'
						. 	'<td>'
						.	'<div class="btn-group">'
						.		'<a class="btn btn-primary" href="#"><i class="icon-user icon-white"></i> User</a>'
						.		'<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>'
						.		'<ul class="dropdown-menu">'
						.			'<li><a href="' . WWW_ROOT . 'users/userEdit.php?id=' . $id . '"><i class="icon-pencil"></i> Edit</a></li>'
						.			'<li><a href="users/userDelete.php?id='. $id .'"><i class="icon-trash"></i> Delete</a></li>'		
						.			'<li class="divider"></li>'
						.			'<li><a href="users/makeAdmin.php?id='. $id . '"><i class="i"></i> Make admin</a></li>'
						.		'</ul>'
						.	'</div>'								
						. '</td>'
						.	'<td>'.$name.'</td>'
						.	'<td>'.$hashName.'</td>'
						.	'<td>'.$role.'</td>'
						.	'<td>'.$email.'</td>'
						.'</tr>';					
					
				}
		}

		
		
		$to = 'paramireze@gmail.com';
		$subject = 'test';
		$message = 'testing';
		$headers = 'from: webmaster@madisonh3.com';
		//mail($to, $subject, $message, $headers);
		
	?>
	<div class="hero-unit">
		<h3>Admin Controls</h3>
		<p>
			<div>
				
			</div>					
		</p>				
	</div>

 <div class="container-fluid">  
     <div class="accordion" id="accordion2">  
            <div class="accordion-group">  
              <div class="accordion-heading">  
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">  
                  user accounts 
                </a>  
              </div>  
              <div id="collapseOne" class="accordion-body collapse" style="height: 0px; ">  
                <div class="accordion-inner">  
				<?php
				echo '<table class="table table-striped" >'
									. 	'<tbody>';
					
					$get_all_admin_stmt = selectAllAdmin($hash);
					if ($get_all_admin_stmt->rowCount() != 0) {
						echo  '<th>Admins</th>';
						displayStuff($get_all_admin_stmt);
					}
					$get_all_members_stmt = selectAllMembers($hash );
					if ($get_all_members_stmt->rowCount() != 0) {
						echo  '<th>Members</th>';
						displayStuff($get_all_members_stmt);
					}
					
					
					$get_all_guests_stmt = selectAllGuests($hash);
					if ($get_all_guests_stmt->rowCount() != 0) {
						echo  '<th>Guest</th>';						
						displayStuff($get_all_guests_stmt);
					}
					
				echo '</tbody>'
				.	'</table><br /><br /><br /><br /><br /><br />';							
					
				?>

				
                
                </div>  
              </div>  
            </div>  
            <div class="accordion-group">  
              <div class="accordion-heading">  
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">  
                events
                </a>  
              </div>  
              <div id="collapseTwo" class="accordion-body collapse">  
                <div class="accordion-inner">  
                  event content
                </div>  
              </div>  
            </div>  
            <div class="accordion-group">  
              <div class="accordion-heading">  
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">  
                  profiles
                </a>  
              </div>  
              <div id="collapseThree" class="accordion-body collapse">  
                <div class="accordion-inner">  
                  modify profiles
                </div>  
              </div>  
            </div>  
          </div>  
    </div>  
	<!-- footer -->
	<?php
	include  DIR_ROOT . "includes/footer.html";
?>
</div>
    
    
    <script src="<?php echo WWW_ROOT; ?>js/jquery-1.9.1.min.js"></script>
    <script src="<?php echo WWW_ROOT; ?>js/bootstrap.min.js"></script>


</body>            
</html>