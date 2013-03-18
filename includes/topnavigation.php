			
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- top navigation -->
				<ul class="nav">

					<li id='index'><a href="<?php echo WWW_ROOT; ?>index.php">Home</a></li>
					<li><a id='calendar' href="<?php echo WWW_ROOT; ?>calendar.php">Calendar</a></li>
					<li><a id='archives' href="<?php echo WWW_ROOT; ?>archives.php">History</a></li>
					<li><a id='howto' href="<?php echo WWW_ROOT; ?>howto.php">Info</a></li>
					<li><a id='races' href="<?php echo WWW_ROOT; ?>races.php">Races</a></li>						
					<li><a id='news' href="<?php echo WWW_ROOT; ?>news.php">News</a></li>
					<li><a id='contacts' href="<?php echo WWW_ROOT; ?>contacts.php">Contact Us</a></li>
				</ul>
				<script>
					// list of URLs, so the navigation knows which page it's on and 
					// can highlight the proper link
					var URL = document.URL;
					knownWebFiles={
						'http://test.madisonh3.com/index.php': 'index',
						'http://www.madisonh3.com/index.php': 'index',
						
						'http://test.madisonh3.com/calendar.php': 'calendar',
						'http://www.madisonh3.com/calendar.php': 'calendar',
						
						'http://test.madisonh3.com/archives.php': 'archives',
						'http://www.madisonh3.com/archives.php': 'archives',
						
						'http://test.madisonh3.com/howto.php': 'howto',
						'http://www.madisonh3.com/howto.php': 'howto',
						
						'http://test.madisonh3.com/example.php': 'calendar',
						'http://www.madisonh3.com/example.php': 'calendar',
						
						'http://test.madisonh3.com/races.php': 'races',
						'http://www.madisonh3.com/races.php': 'races',
						
						'http://test.madisonh3.com/news.php': 'news',
						'http://www.madisonh3.com/news.php': 'news',
						
						'http://test.madisonh3.com/contacts.php': 'contacts',
						'http://www.madisonh3.com/contacts.php': 'contacts',

					}
					//turns the background color to the link, in the navigation bar, black for whatever page you're on.
					if (document.URL in knownWebFiles) {
						var elementId = knownWebFiles[document.URL];
						var d = document.getElementById(elementId);
						d.style.background = 'black';
					}
					
					
				</script>
				<div class="nav-collapse collapse">
					
					
					
					<form action='<?php echo WWW_ROOT; ?>login/validateUser.php' method='post' class="navbar-form pull-right">
					<?php 
					
					// if user is logged in
					if (isset($_SESSION['user']) && $_SESSION['user']['loggedIn'] = true) {
						if ($_SESSION['user']['role'] == 'admin') {			
							echo "<ul class='nav'><li><a href='" . WWW_ROOT . "example.php'>admin controls</a></li></ul>";
						}
						echo "<ul class='nav'><li><a id='logout' href='" . WWW_ROOT . "login/logout.php'>logout</a></li></ul>";						
					} else {
					
					?>
						<input class="span2" name='loginName' type="text" placeholder="User Name">
						<input class="span2" name='password' type="password" placeholder="Password">
						
						<?php 
							// this is used to protect against CSRF attacks. 
							// for more details, check https://www.owasp.org/index.php/Cross-Site_Request_Forgery_%28CSRF%29 
							getToken();
							echo getTokenField(); 
						?>
						
						<button type="submit" class="btn">Sign in</button>
						<a style='color:blue;' id='contacts' href="<?php echo WWW_ROOT; ?>login/register.php">Register</a>
						<?php
					}
				?>
					</form>
					
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
        
		
        
          
		  <?php
			// displays error message, if there is one
			// ie, failed log in or unauthorized access
			if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
				foreach ($_SESSION['errors'] as $errorMessage) {			
					echo '<div class="alert alert-error">  
					<a class="close" data-dismiss="alert">x</a>  
					<strong></strong>' . $errorMessage . '  
					</div>';
				}
			}
			
			if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
				foreach ($_SESSION['success'] as $successMessage) {			
				echo '<div class="alert alert-success">  
					<a class="close" data-dismiss="alert">x</a>  
					<strong>' . $successMessage . '</strong></div>';
				}
			}

	
			if (isset($_SESSION['pageError']) && $_SESSION['pageError'] != '') {
				echo '<div class="alert alert-error">  
					<a class="close" data-dismiss="alert">x</a>  
					<strong>' . $_SESSION['pageError'] . '</strong></div>';
			}

			$_SESSION['errors'] = NULL;
			unset($_SESSION['errors']);
			
			$_SESSION['success'] = NULL;			
			unset($_SESSION['success']);
			
			$_SESSION['pageError'] = NULL;
			unset($_SESSION['pageError']);

		  ?>
		 
		  
			
			
	</div>
	<!-- content -->

	
	<img src="<?php echo WWW_ROOT; ?>images/header_bgd.jpg" />
	
