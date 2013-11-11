<p>ADMIN CONTROL PANEL</p>
<table id="posts-table">
    	<thead>
        	<tr>
        	   	<th class="posts-table" scope="col">Posts</th>
        	</tr>
     	</thead>
     	<?php /*posts are generated here */ $H = new Html(); $H->outputContent($H->generate('posts'));?> 
</table>