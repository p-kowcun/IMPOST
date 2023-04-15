<fieldset class="module">
	<legend>Twoje trasy</legend>
	<?php
	
		$query = $connect -> prepare('select id,stops from routes where employee="'.$_SESSION['username'].'";');
		
		$query -> execute();
		
		$record = $query -> fetchAll(PDO::FETCH_ASSOC);
		
		foreach($record as $row)
		{
			echo"<div><table>";
			
			echo"<tr><th>Twoje przystanki na trasie nr:</th><td>".$row['id']."</td>";
			
			$query = $connect -> prepare('select count(id) from parcels where route = '.$row['id'].' ;');
		
			$query -> execute();
		
			$record3 = $query -> fetch(PDO::FETCH_ASSOC);
			
			if(!empty($record3))
			{
				echo"<tr><th>Paczek na trasie:<td>".$record3['count(id)'];
			}
			for($i=1;$i<=$row['stops'];$i++)
			{
				$query2 = $connect -> prepare('select stop_'.$i.' from route_stops where id='.$row['id'].';');
				
				$query2 -> execute();
				
				$record2 = $query2 -> fetch(PDO::FETCH_ASSOC);
				
				echo"<tr><th>Przystanek nr $i:</th><td>".$record2['stop_'.$i]."</td></tr>";
				
			}
			
			echo"</table></div>";
		}
	?>
</fieldset>
