	<fieldset class="module">
			<legend>Zarządzanie paczkami</legend>
			<?php
			
				if($_SESSION['privileges_level']>1)
				{
					echo'<form method="POST">';
						echo'<label for="code">Filtruj po kodzie:</label>';
						echo'<input type="number" name="code" />';
						echo'<input type="submit" value="Wyświetl" name="parcels"/>';
						echo'</form>';
					
					if(!empty($_POST['parcels']) && empty($_POST['code']))
					{
						$query = $connect -> prepare('select id,`code`, sent_at, delivered_at, current_stop, route, ordered_by from parcels where delivered_at is NULL order by sent_at desc;');
						
						$query -> execute();
						
						$record = $query -> fetchAll(PDO::FETCH_ASSOC);
						
						foreach($record as $row)
						{
							echo"<div><table><tr><th>Kod przesyłki:</th><td>".$row['code']."</td></tr><tr><th>Wysłana:</th><td>".$row['sent_at'];
							
								$query2 = $connect -> prepare('select stop_'.$row['current_stop'].' from route_stops where id ='.$row['route'].';');
							
								$query2 -> execute();
							
								$record2 = $query2 -> fetch(PDO::FETCH_ASSOC);
							
								echo"<tr><th>Aktualnie w:</th><td>".$record2["stop_".$row['current_stop']]."</table></div>";
						}
						
						
						$query = $connect -> prepare('select id,`code`, sent_at, delivered_at, current_stop, route, ordered_by from parcels where delivered_at is NOT NULL order by sent_at desc;');
						
						$query -> execute();
						
						$record = $query -> fetchAll(PDO::FETCH_ASSOC);
						
						foreach($record as $row)
						{
							echo"<div><table><tr><th>Kod przesyłki:</th><td>".$row['code']."</td></tr><tr><th>Wysłana:</th><td>".$row['sent_at'];
							
							echo"<tr><th>Dostarczona:</th><td>".$row['delivered_at']."</table></div>";
						}
					}
					if(!empty($_POST['parcels']) && !empty($_POST['code']))
					{
						$query3 = $connect -> prepare('select id,`code`, sent_at, delivered_at, current_stop, route, ordered_by from parcels where code = '.$_POST['code'].' order by sent_at desc;');
						
						$query3 -> execute();
						
						$record3 = $query3 -> fetchAll(PDO::FETCH_ASSOC);
						
						foreach($record3 as $row)
						{
							echo"<div><table><tr><th>Kod przesyłki:</th><td>".$row['code']."</td></tr><tr><th>Wysłana:</th><td>".$row['sent_at'];
							
							if(!empty($row['delivered_at']))
							{
								echo"<tr><th>Dostarczona:</th><td>".$row['delivered_at']."</table></div>";
							}
							else
							{
								$query2 = $connect -> prepare('select stop_'.$row['current_stop'].' from route_stops where id ='.$row['route'].';');
							
								$query2 -> execute();
							
								$record2 = $query2 -> fetch(PDO::FETCH_ASSOC);
							
								echo"<tr><th>Aktualnie w:</th><td>".$record2["stop_".$row['current_stop']]."</table></div>";
							}
						}
					}
				}
				else
				{
						$query = $connect -> prepare('select count(id) from parcels where delivered_at is NULL AND ordered_by="'.$_SESSION['username'].'";');
						
						$query -> execute();
						
						$record2 = $query -> fetch(PDO::FETCH_ASSOC);
							
						echo"<div><table><tr><th>W drodze:<td>".$record2['count(id)']."</table></div>";
						
						$query = $connect -> prepare('select id,`code`, sent_at, delivered_at, current_stop, route, ordered_by from parcels where delivered_at is NULL AND ordered_by="'.$_SESSION['username'].'" order by sent_at desc;');
						
						$query -> execute();
						
						$record = $query -> fetchAll(PDO::FETCH_ASSOC);
						
						foreach($record as $row)
						{
							echo"<div><table><tr><th>Kod przesyłki:</th><td>".$row['code']."</td></tr><tr><th>Wysłana:</th><td>".$row['sent_at'];
							
								$query2 = $connect -> prepare('select stop_'.$row['current_stop'].' from route_stops where id ='.$row['route'].';');
							
								$query2 -> execute();
							
								$record2 = $query2 -> fetch(PDO::FETCH_ASSOC);
							
								echo"<tr><th>Aktualnie w:</th><td>".$record2["stop_".$row['current_stop']]."</table></div>";
							
						}
						
						$query = $connect -> prepare('select count(id) from parcels where delivered_at is NOT NULL AND ordered_by="'.$_SESSION['username'].'";');
						
						$query -> execute();
						
						$record2 = $query -> fetch(PDO::FETCH_ASSOC);
							
						echo"<div><table><tr><th>Dostarczonych:<td>".$record2['count(id)']."</table></div>";
						
						$query = $connect -> prepare('select id,`code`, sent_at, delivered_at, current_stop, route, ordered_by from parcels where delivered_at is NOT NULL AND ordered_by="'.$_SESSION['username'].'" order by sent_at desc;');
						
						$query -> execute();
						
						$record = $query -> fetchAll(PDO::FETCH_ASSOC);
						
						foreach($record as $row)
						{
							echo"<div><table><tr><th>Kod przesyłki:</th><td>".$row['code']."</td></tr><tr><th>Wysłana:</th><td>".$row['sent_at'];
							if(!empty($row['delivered_at']))
							{
								echo"<tr><th>Dostarczona:</th><td>".$row['delivered_at']."</table></div>";
							}
						
						}
						
				}
			?>
</fieldset>