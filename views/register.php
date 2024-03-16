<!-- Formulaire d'inscription -->
<div class="Inscriptionbg">
    <h1 class="h1inscription"> Créer un compte</h1>
    <form action="inscription" method="POST" class="formInscription">
        
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname">
        <!-- Si l'erreur firstname existe alor j'affiche l'erreur firstname ( sa sert à afficher les erreurs)-->
        <?php if (isset($formErrors['firstname'])) { ?>
            <p class="error"><?= $formErrors['firstname'] ?></p>
        <?php } ?>

        <label for="lastname">Nom</label>
        <input type="text" name="lastname" id="lastname">
        <?php if (isset($formErrors['lastname'])) { ?>
            <p class="error"> <?= $formErrors['lastname'] ?></p>
        <?php } ?>

        <label for="birthdate">Date de naissance</label>
        <input type="date" name="birthdate" id="birthdate">
        <?php if (isset($formErrors['birthdate'])) { ?>
            <p class="error"> <?= $formErrors['birthdate'] ?> </p>
        <?php } ?>

        <label for="email">Adresse mail</label>
        <input type="email" name="email" id="email">
        <?php if (isset($formErrors['email'])) { ?>
            <p class="error"> <?= $formErrors['email'] ?></p>
        <?php } ?>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        <?php if (isset($formErrors['password'])) { ?>
            <p class="error"> <?= $formErrors['password'] ?></p>
        <?php } ?>

        <label for="passwordConfirm">Confirmation du mot de passe</label>
        <input type="password" name="passwordConfirm" id="passwordConfirm">
        <?php if (isset($formErrors['passwordConfirm'])) { ?>
            <p class="error"> <?= $formErrors['passwordConfirm'] ?></p>
        <?php } ?>

        <input type="submit" value="CRÉER UN COMPTE" class="submitInscription">

        <?php if (isset($success)) { ?>
            <p> <?= $success ?> <a href="/connexion" class="creeruncompte">Veuillez-vous connecter ici</a></p>
        <?php } ?>

    </form>
</div>