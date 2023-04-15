<fieldset class="module">
			<legend>
			Zarządzanie użytkownikami serwisu
			</legend>
				<form method="POST">
	<select name="m_u_panel" id="m_u_panel">
		<option value="" disabled selected hidden>Wybierz</option>
		<?php
			if($_SESSION['privileges_level']>2)
			{?>
				<option value="2">Moderatorzy</option>
			<?php }
			?>
		<option value="1">Pracownicy</option>
		<option value="0">Użytkownicy</option>
    </select>

    <button type="button" onclick="showData();">Wyświetl</button>

</form>

<div id='m_u_panel_result'></div>


<script>

function showData(){
    var select = document.getElementById("m_u_panel").value;

    var xhr = new XMLHttpRequest();

    xhr.onload = function() {
            document.getElementById("m_u_panel_result").innerHTML = this.responseText;

    };

    xhr.open("POST", "panel_ajax.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("m_u_panel_select="+select);

}

</script>

</fieldset>

<fieldset class="module">
			<legend>
			
			Dodawanie użytkowników do serwisu
			
			</legend>
			
			<form method="POST">
			
					<select name="add_user_privilege">
					
						<option disabled selected hidden>Wybierz</option>
						
						<?php
						
						if($_SESSION['privileges_level']>2)
							
						{
							
						?>
						
						<option value="2">Moderator</option>
						
						<?php 
						
						}
						
						?>
						
						<option value="1">Pracownik</option>
						
						<option value="0">Użytkownik</option>
						
					</select><br>
					
					<label for="add_login">Login </label>
					
					<input type="text" name="add_login"/><br>
					
					<label for="password">Haslo </label>
					
					<input type="password" name="password"/><br>
					
					<input type="submit" name="add" value="Dodaj"/>
					
				</form>
				
				<?php
				
					if(!empty($_POST['add']))
					{
						$query4 = $connect -> prepare("INSERT INTO login(login,password,registered_at,privileges_level) values('".$_POST['add_login']."','".password_hash($_POST['password'],PASSWORD_DEFAULT)."',CURRENT_TIMESTAMP(),'".$_POST['add_user_privilege']."');");
						
						$query4 -> execute();
					}
				?>
</fieldset>

<fieldset class="module">
	<legend>
	Zarządzanie pracownikami i trasami
	</legend>
		
		
		<?php
		
			$querylogin = $connect -> prepare('select login from login where privileges_level=1');
			
			$querylogin -> execute();
			
			$record4 = $querylogin -> fetchAll(PDO::FETCH_ASSOC);
		
			$query = $connect -> prepare('select id, stops, city_start, city_end, employee from routes where employee is NULL');
		
			$query -> execute();
			
			$record = $query -> fetchAll(PDO::FETCH_ASSOC);
		
		
			foreach($record as $row)
			{
				echo"<div class='brak_trasy'><table><tr><th>ID trasy:</th><td>".$row['id']."</td></tr><tr><th>Ilość stopów:</th><td>".$row['stops']."</td></tr>";
				
				$query = $connect -> prepare("select count(*) as zlicz from parcels where route=".$row['id']." group by route;");
		
				$query -> execute();
			
				$record2 = $query -> fetch(PDO::FETCH_ASSOC);
				
				if(!empty($record2))
				{
					
					echo"<tr><th>Paczek na trasie:<td>".$record2['zlicz'];
				}
				
				echo"<tr><th>Zaczyna się w:<td>".$row['city_start']."</tr><th>Kończy się w:<td>".$row['city_end']."</tr>";
				
				echo"<tr><th>Przypisz pracownika!<td>";
				
				?>
				
				<form method="POST">
					
				<?php
					
				echo'<select name="login'.$row['id'].'">'
					
				?>
					
				<option disabled selected hidden>Wybierz</option>
					
				<?php
					
				foreach($record4 as $row4)
				{
					echo"<option value='".$row4['login']."'>".$row4['login']."</option>";
				}
				
				?>
				
				</select>
				
				<input type="submit" value="Przypisz" name="przypisz"/>
				
				</form>
				
				<?php
				
				echo"</tr></table></div>";
					
					if(!empty($_POST['przypisz']) && !empty($_POST['login'.$row['id']]))
					{
						$query7 = $connect -> prepare("update routes set employee = '".$_POST['login'.$row['id']]."' where id = ".$row['id'].";");
						$query7 -> execute();
					}
			}
		?>
		
		<form method="POST">
		
			<label for="login">Login pracownika:</label>
			
			<select name="login">
			
			<option disabled selected hidden>Wybierz</option>
			
			<?php
			
				foreach($record4 as $row)
				{
					echo"<option value='".$row['login']."'>".$row['login']."</option>";
				}
			?>
			
			</select><br>
			
			<label for="route">Numer trasy:</label>
			
			<select name="route"/>
			
			<option disabled selected hidden>Wybierz</option>
			
			<?php
			
				$query = $connect -> prepare('select id from routes order by id asc;');
				
				$query -> execute();
				
				$record5 = $query -> fetchAll(PDO::FETCH_ASSOC);
				
				foreach($record5 as $row)
				{
					echo"<option value='".$row['id']."'>".$row['id']."</option>";
				}
			?>
			
			</select><br>
			
			<input type="submit" value="Wyświetl"/>
			
		</form>
		
		<?php
		
			if(!empty($_POST['login']) && empty($_POST['route']))
			{
				$query = $connect -> prepare('select id, stops, city_start, city_end, employee from routes where employee like :login');
				
				$query -> bindValue(':login',$_POST['login']);
				
				$query -> execute();
				
				$record = $query -> fetchAll(PDO::FETCH_ASSOC);
				
				echo"<div><table><tr><th>Wyświetlanie tras dla pracownika:<td>".$_POST['login']."</table></div>";
				
				foreach($record as $row)
				{
					echo"<div><table><tr><th>ID trasy:</th><td>".$row['id']."</td></tr><tr><th>Ilość stopów:</th><td>".$row['stops']."</td></tr>";
					
					$query = $connect->prepare("SELECT COUNT(*) AS zlicz FROM parcels WHERE route = " . $row['id'] . " GROUP BY route");
					
					$query -> execute();
					
					$record2 = $query -> fetch(PDO::FETCH_ASSOC);
					
					echo"<tr><th>Paczek na trasie:<td>".$record2['zlicz']."<tr><th>Zaczyna się w:<td>".$row['city_start']."</tr><th>Kończy się w:<td>".$row['city_end']."</tr></table></div>";
				}
			}
			
			if(empty($_POST['login']) && !empty($_POST['route']))
			{
				$query = $connect -> prepare('select id, stops, city_start, city_end, employee from routes where id ='.$_POST['route']);
				
				$query -> execute();
				
				$record = $query -> fetchAll(PDO::FETCH_ASSOC);
				
				foreach($record as $row)
				{
					echo"<div><table><tr><th>ID trasy:</th><td>".$row['id']."</td></tr><tr><th>Ilość stopów:</th><td>".$row['stops']."</td></tr>";
					
					$query = $connect->prepare("SELECT COUNT(*) AS zlicz FROM parcels WHERE route = " . $row['id'] . " GROUP BY route");
					
					$query -> execute();
					
					$record2 = $query -> fetch(PDO::FETCH_ASSOC);
					
					echo"<tr><th>Paczek na trasie:<td>".$record2['zlicz']."<tr><th>Zaczyna się w:<td>".$row['city_start']."</tr><th>Kończy się w:<td>".$row['city_end']."</tr><tr><th>Pracownik:<td>".$row['employee']."</table></div>";
				}
			}
			
			if(!empty($_POST['login']) && !empty($_POST['route']))
			{
				$query = $connect -> prepare("UPDATE routes set employee = '".$_POST['login']."' where id = ".$_POST['route']);
				
				$query -> execute();
				
				echo"poprawnie wykonano podmiankę";
			}
		?>
</fieldset>
