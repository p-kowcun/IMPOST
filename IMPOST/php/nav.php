<nav>
        <a href="main.php"><img src="../img/logo.png" alt="logo" class="logo"></a>
        <div>
        <a href="order.php">Zamów paczkę</a>
        <a href="map.php">Punkty doręczeń paczek</a>
        <a href="find.php?order_id=">Śledź paczkę</a>
        </div>
        <a href="login.php" class="login">
            <?php

            if( isset($_SESSION['token'] ))
                echo $_SESSION['username'];
            else
                echo "Zaloguj się";

            ?></a><?php

            if(isset($_POST['logout']))
            {
                session_destroy();
                header("location: main.php")   ;
            }

            if( isset($_SESSION['token'] )){ ?>
            <form method="post">
        <button name="logout" class="logout" title="Wyloguj">
		<span class="lock">🔐</span>
    <span class="unlock">🔓</span>
	</button>
       </form>
<?php }

            ?>
    </nav>
