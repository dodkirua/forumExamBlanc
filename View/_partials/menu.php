<div id="menu">
    <div>
        <a href="/index.php" title="retour index">Accueil</a>
    </div>
    <?php

    if (isset($_SESSION['account']['id'])) {
        echo "<div id='accountLink'>";
        echo "<a href='/index.php?ctrl=account'>Votre compte</a>";
        echo "<a href='/index.php?ctrl=disconnect'>Déconnection</a>";
    }
    else {
        echo "
            <div id='loginMenu'>
                <form action='/index.php?ctrl=form&action=login'>
                    <div>
                        <label for='username'>username</label>
                        <input type='text' id='username' required>
                    </div>
                    <div>
                        <label for='pass'>Password</label>
                        <input type='password' id='pass' required>
                    </div>
                    <div>
                        <input type='submit' value='Valider'>
                    </div>
                </form>
                <div>
                <a href='/index.php?ctrl=account&opt=passForgot' title='Password oublié'>Password oublié?</a>
                <a href='/index.php?ctrl=registration' title='Création de compte'>Création de compte</a>        
                </div>
                ";
    }
    echo "</div>";
    ?>
</div>

