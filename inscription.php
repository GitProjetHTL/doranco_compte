<?php

// ETAPE 1 -Inclusion PHP
require_once 'inc/init.php';

// ETAPE 2 - Traitement des données de formulaire
//Je verifie si le formulaire a été validé. S'il a été validé je peux traiter les données
//WARNING je ne peux pas traiter les données si le formulaire n'a pas été envoyé.
if (!empty($_POST)) {
    
    debug($_POST);
    //ETAPE de verification des données
        if (empty($_POST['username'])) {
            $errorMessage .="Merci d'indiquer un Pseudo <br>";
        }
        //strlen() permet de récupérer la longeur d'une chaine de caractètre.Attention les caractères speciaux compte pour 2. ex: éé = 4 caractère.
        //iconv_strlen() permet de résoudre ce problème.
        if (iconv_strlen(trim($_POST['username']))<3 || (iconv_strlen(trim($_POST['username']))>50 )){
            $errorMessage .=" Le Pseudo doit contenir entre 3 et 50 caractère <br>";
        }




        if (empty($_POST['password']) || iconv_strlen(trim($_POST['password']))<8 ) {
            $errorMessage .="Merci d'indiquer un mot de passe de minimum 8 caractètres <br>";
        }

        if (empty($_POST['lastname']) || iconv_strlen(trim($_POST['lastname']))>70) {
            $errorMessage.="Merci d'indiquer un nom <br> (maxmimum 70 caractère) <br>";
        }

        if (empty($_POST['firstname']) || iconv_strlen(trim($_POST['firstname']))>70) {
            $errorMessage.="Merci d'indiquer un prenom <br> (maxmimum 70 caractère) <br>)";
        }

        if (empty($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) ) {
            $errorMessage.="L'Email n'est pas valide <br>";
        }
    //FIN de verification des données

    //ETAPE securisation des données
        //htmlspecialchars permet de transformet les chevrons et les guillemet (simple ou double) en leur entités html.


        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars($value,ENT_QUOTES);
            
        }
    //FIN securisation des données

    //ETAPE Envoie des données
        //je verifie si je n'ai pas de message d'erreur
        //Si $errorMessage est vide alors les données envoyées par l'utilisateur sont corrects. Je peux donc les envoyer
        if (empty($errorMessage)) {
            
        
            $requete = $bdd->prepare("INSERT INTO membre VALUES(NULL,:username, :password, :lastname, :firstname, :email, :status ) ");
            $success = $requete -> execute([
                ":username" => $_POST['username'],
                ":password" => password_hash($_POST['password'], PASSWORD_DEFAULT),//la fonction password_hash() permet de hasher un mdp on doit lui indiquer en paramètre le type d'algo que l'on souhaite appliquer?Ici on prend l'algo par default
                ":lastname" => $_POST['lastname'],
                ":firstname" => $_POST['firstname'],
                ":email" => $_POST['email'],
                ":status" => "user"
                
            ]);
        


                if ($success) {
                    $successMessage="Inscription réussie";
                    $_SESSION["successMessage"]="Inscription réussie";

                    /**
                     * Introduction à la session:
                     * La Session est un fichier temporaire appelé sess_id qui est stoké sur le serveur.Ce fichier à un identifiant unique.Chaque fichier de session sera lié a un seul internaute.
                     * Ondéclare la session avec session_start()
                     * session_start() crée la session OU Recupere la session en fonction de l'id passé dans le cookie (PHPSESSID)
                     * 
                     * le fichier de session peut  contenir tout type d'information, y compris des informations sensibles (mdp, cartes bancaire , donnée de santé ... ) En effet ce fichier n'est pas accessible par l'utilisateur.
                     * 
                     * Une fois que  SESSION_START est lu on a accès à la superglobale $_SESSION C'est dans une superglobale que l'on va récupérer les informations de la session.
                     * 
                     * Pour ajouter une information, on appel $_SESSION suivi d'un indice (ici'succesMessage') et de sa VALEUR.
                     * 
                     * Si l'indice appelé existe déja sa valeur sera remplacé , s'il n'exite pas l'indice sera crée
                     * 
                     * Les informations présentent dans la session ne sont pas supprimée automatiquement.Pour supprimer une information on doit utiliserla fonction 'unset'
                     * 
                     */
                    //si m'a requete a fonctionner je suis redirigé vers la page de connexion
                    header("location:connexion.php");
                    exit;
                    /**
                     * le temps que le header soit executée et que la reedirection soit faite, il peut se passer un peu de temps.Pendant ce temps la le code est lu et executé.
                     * Pour eviter que ce code soit executé j'ai besoin de l'execution 'exit' 
                     * c'est très important car pendant de lapse de temps très court du code peut etre injecté parun individu malvaillant
                     */
                } else {
                    $errorMessage="Inscription non réussie";
                };
            };
        
    //FIN Envoie des données
        }

require_once 'inc/header.php';





//Pour remplir la page inscription on écrit entre les 2 require

?>


    <h1 class="text-center">Inscription</h1>

    <?php  if (!empty($successMessage)) {?>
        <div class="alert alert-success col-md-6 text-center mx-auto">
        <?php echo $successMessage ?>
        </div>
    <?php } ?>
    
    <?php  if (!empty($errorMessage)) {?>
        <div class="alert alert-danger col-md-6 text-center mx-auto">
        <?php echo $errorMessage ?>
        </div>
    <?php } ?>



    <form action="" method="post" class="col-md-6 mx-auto">

<label for="username" class="form-label">Pseudo</label>
<input 
    type="text" 
    name="username" 
    id="username" 
    class="form-control" 
    value="<?php echo $_POST['username'] ?? "" ?>"
    
>   
<!-- si $_POST['username'] existe alors j'affiche sa valeur sinon j'affiche une caractère vide. On utilise ici l'opérateur NULL COALESCENT-->
<div class="invalid-feedback"></div>

<label for="password" class="form-label">Mot de Passe</label>
<input 
    type="password" 
    name="password" 
    id="password" 
    class="form-control"
    value="<?php echo $_POST['password'] ?? "" ?>" 
>
<div class="invalid-feedback"></div>

<label for="lastname" class="form-label">Nom</label>
<input 
    type="text" 
    name="lastname" 
    id="lastname" 
    class="form-control"
    value="<?php echo $_POST['lastname'] ?? "" ?>"
>
<div class="invalid-feedback"></div>

<label for="firstname" class="form-label">Prénom</label>
<input 
    type="text" 
    name="firstname" 
    id="firstname" 
    class="form-control"
    value="<?php echo $_POST['firstname'] ?? "" ?>"
>
<div class="invalid-feedback"></div>

<label for="email" class="form-label">Email</label>
<input 
    type="email" 
    name="email" 
    id="email" 
    class="form-control"
    value="<?php echo $_POST['email'] ?? "" ?>"
>
<div class="invalid-feedback"></div>

<button class="btn btn-success d-block mx-auto mt-3">S'inscrire</button>

</form>

<?php
require_once 'inc/footer.php';
?>