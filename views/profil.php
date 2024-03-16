<!-- Formulaire modidification profil -->
<div class="formProfil">
    <div class="left">
<h2 class="titreProfil">Modifier mes informations</h2>
<form action="profil" method="POST" class="formInscription">
    <label for="firstname">Prénom</label>
    <input type="text" name="firstname" id="firstname">
    <!-- Si l'erreur firstname existe alor j'affiche l'erreur firstname ( sa sert à afficher les erreurs)-->
    <?php if(isset($formErrors['firstname'])){ ?>
        <p class="error"><?= $formErrors['firstname'] ?></p>
    <?php } ?>

    <label for="lastname">Nom</label>
    <input type="text" name="lastname" id="lastname">
    <?php if(isset($formErrors['lastname'])){ ?>
        <p class="error"> <?= $formErrors['lastname'] ?></p>
    <?php } ?>

    <label for="birthdate">Date de naissance</label>
    <input type="date" name="birthdate" id="birthdate">
    <?php  if(isset($formErrors['birthdate'])){ ?>
        <p class="error"> <?= $formErrors['birthdate'] ?> </p>
    <?php } ?>

    <label for="email">Adresse mail</label>
    <input type="email" name="email" id="email">
    <?php  if(isset($formErrors['email'])){ ?>
        <p class="error"> <?= $formErrors['email'] ?></p>
    <?php } ?>

    <input type="submit" value="Modifier" class="submitInscription" name="updateInfos">
</form>
</div>

<!-- Formulaire modification mot de passe -->
<div class="right">
<h2 class="titreProfil">Modifier le mot de passe </h2>
<form action="profil" method="POST" class="formInscription">
            <label for="currentPassword">Mot de passe actuel</label>
            <input type="password" name="currentPassword" id="currentPassword">
            <?php  if(isset($formErrors['currentPassword'])){ ?>
        <p class="error"> <?= $formErrors['currentPassword'] ?></p>
    <?php } ?>
            <label for="newPassword">Nouveau mot de passe</label>
            <input type="password" name="newPassword" id="newPassword">
            <?php  if(isset($formErrors['newPassword'])){ ?>
        <p class="error"> <?= $formErrors['newPassword'] ?></p>
    <?php } ?>
            <label for="passwordConfirm">Confirmation mot de passe</label>
            <input type="password" name="passwordConfirm" id="passwordConfirm">
            <?php  if(isset($formErrors['passwordConfirm'])){ ?>
        <p class="error"> <?= $formErrors['passwordConfirm'] ?></p>
    <?php } ?>
         <input type="submit" value="Modifier" class="submitInscription" name="updatePassword">
        </form>
        <button id="open-delete-modal">Supprimer mon compte</button>
        
<!-- Suppression compte -->
     <div id="modal-container">
        <div id="modal">
                <span id="close-btn">&times;</span>
                <div class="alert" role="alert">Voulez-vous vraiment supprimer votre compte ?</div>  
                <form action="" method="POST">
                    <input type="submit" value="Supprimer" name="delete" class="inputDelete">
                    
         
                </form>
        </div>
    </div>
        </div>
   
            
    </div>