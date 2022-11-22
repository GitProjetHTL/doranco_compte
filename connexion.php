<?php 

require_once "inc/init.php";

//j'attend la validation de formulaire
//if (!empty($_POST)){

debug($_SESSION);

if (isset($_POST['connexion'])) {
    
    



//ETAPE DE SECURISATUON

    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars($value,ENT_QUOTES);
        
    }

//FIN DE SECURISATION

//ETAPE de Verification des données

    if (empty($_POST['username'] ) || empty($_POST['password'] )) {
        $errorMessage="Les identifiants sont obligatoire";
    
    
        }else {//Si les données sont rempli je peux essayer de récupérer un internaute
            //ETAPE de connexion
                //Récupération d'un membre via son pseudo

                $requete = $bdd -> prepare("SELECT * FROM membre WHERE username = :username");
                $requete -> execute([':username' => $_POST['username']]);

               // debug($requete->rowCount()); rowCount permet de compter le nombre de résultat récupére depuis ma BDD

               //Si j'ai un résultat alors c'est que le pseudo est correct
                if ($requete -> rowCount() == 1 ){
                    //je vais donc ici aller chercher mon utilisateur à l'intérieur de l'objet et je le stock dans la variable $user
                    $user = $requete-> fetch();
                    debug($user);
                    
                        //maintenantque j'ai un utilisateur je peux essayer de verifier sont mdp
                        //le mdp en BDD est haché donc pour vérifier et comparer le mdp reçu dans le formulaire je doit utiliser la fonction passeword_verify()
                        //cette foncyion attend en premier paramètre le mdp 'normal' et en deuxieme paramètr le mdp haché.La fonction renverra TRUE ou FALSE en foncrion du résultat
                        if (password_verify($_POST['password'], $user['password'])) {

                            //Une fois le mdp verifier je peux stoker dnas la session les information de cet utilisateur.
                            //il sera à partir de ce moment, 'conneté à mon site
                            
                            $_SESSION['membre'] =$user;

                            $_SESSION['successMessage']="Bonjour $user[username] ,bienvenue sur votre compte";


                            header("location:profil.php");
                            exit;

                            /**
                             * Exercice faire une redirection vers la page profil.php quand on est connecté
                             * Dans la page profil j'affiche des information de l'utilisateur
                             */
                        

                        } else {
                            $errorMessage="Mot de passe ou Identifiant incorrects";
                        }
                    } else {
                        $errorMessage="Mot de passe ou Identifiant incorrects";
                    }
                    

            //FIN de connexion
        }
    
}

    
debug($_SESSION);






//FIN de Verification des données

//ETAPE de connexion



//FIN de connexion




require_once "inc/header.php";





?>

<h1 class="text-center">Connexion</h1>

<?php  if (!empty($_SESSION['successMessage'])) {?>
    <div class="alert alert-success col-md-6 text-center mx-auto">
    <?php echo $_SESSION['successMessage'] ?>
    </div>

    <?php unset($_SESSION['successMessage']) ?>
<?php } ?>



    <?php  if (!empty($errorMessage)) {?>
        <div class="alert alert-danger col-md-6 text-center mx-auto">
        <?php echo $errorMessage ?>
        </div>
    <?php } ?>


<form action="" method="post" class="col-md-6 mx-auto">

<label for="username" class="form-label" >Pseudo</label>
<input type="text" placeholder="Votre Pseudo" name="username" id="username" class="form-control">

<label for="password" class="form-label">Mot de Passe</label>
<input type="password" placeholder="Votre Mot de Passe" name="password" id="password" class="form-control">

<button class="d-block mx-auto btn btn-primary mt-3" name="connexion">Connexion</button>

</form>



<?php

require_once "inc/footer.php";


?>