<?php
require_once "inc/init.php";

debug($_SESSION);

//Restriction d'acces si la personne n'est pas conneté alors je la redirige vers la page de connexion.

require_once "inc/header.php";

if (!isConnected())) 
{
    header("location:connexion.php");
    exit;
}




?>

    <?php  if (!empty($_SESSION['successMessage'])) {?>
        <div class="alert alert-success col-md-6 text-center mx-auto">
        <?php echo $_SESSION['successMessage'] ?>
        </div>

        <?php unset($_SESSION['successMessage']) ?>
    <?php } ?>
    

    <div class="container mt-4 mb-4 p-3 d-flex justify-content-center"> 
        <div class="card p-4"> 
            <div class=" image d-flex flex-column justify-content-center align-items-center"> 
                <button class="btn btn-secondary"> 
                    <img src="img/Malphite_0.jpg" height="300" width="300" />
                </button> 
                
                <span class="name mt-3"> 

                

                    <?= $_SESSION['membre']['lastname']." ".$_SESSION['membre']['firstname']  ?>
                </span> 
                
                <span class="idd">@<?= $_SESSION['membre']['username']?></span> 
                
                <div class="text mt-3 text-center"> 
                    <span>
                    <?= $_SESSION['membre']['email']."<br>" ?>
                    
                    <?= $_SESSION['membre']['status']?>
                    </span>
                </div>
                
                <div class=" d-flex mt-2"> 
                    <button class="btn1 btn-dark">Modifier Profil</button> 
                </div> 
            </div> 
        </div>
    </div>

<?php 
  
require_once "inc/footer.php";
?>