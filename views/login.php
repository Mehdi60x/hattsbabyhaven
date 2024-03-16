<!-- Formulaire de connexion compte -->
<div class="connectionbg">
<h1 class="h1connection"> Connectez-vous</h1>

<form action="connexion" method="POST" class="pageconnection">
    <label for="email">EMAIL</label>
    <input type="text" name="email" id="email">
    <?php if(isset($formErrors['email'])) { ?>
        <p class="error"> <?= $formErrors['email'] ?></p>
    <?php } ?>
        
    <label for="password">MOT DE PASSE</label>
    <input type="password" name="password" id="password">
    <?php if(isset($formErrors['password'])) { ?>
        <p class="error"> <?= $formErrors['password'] ?></p>
    <?php } ?>

    <input type="submit" value="SE CONNECTER" class="submitconnection">
    <p>Nouveaux client ?  <span><a href="inscription" class="creeruncompte"> Créer un compte </a></span></p>

</form>
</div>