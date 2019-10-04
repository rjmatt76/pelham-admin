<ul>
	<li><a href="?home" title="" class="round active">Home</a></li>
	<li><a href="?seedlist">Seed List</a></li>
<?php
        if (!array_key_exists('loggedin',$_SESSION) || $_SESSION['loggedin'] == null) 
        {
            echo '<li><a href="?login">Login</a></li>';
        }
        else
        {
            echo '<li>Logged In</li>';
        }
  ?>
	<li><a href="javascript:showPermissionDeniedDialog();">Test</a></li>
</ul>	
