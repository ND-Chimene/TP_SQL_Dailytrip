<?php
// Header loading
include_once './src/views/components/header.html.php';
?>
<div class="flex flex-col items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="lg:text-7xl font-bold uppercase">
            Oups, vous vous êtes <br> perdue en chemin !
        </h1>
        <br>
        <p>Cette page est introuvable. 🌍</p>
        <br>
        <!-- Zoom in on hover -->
        <a href="/home" class="btn hover:text-white hover:bg-[#0c274e] hover:shadow-lg">
            Retourner à sur la page d'accueil
        </a>
    </div>
</div><!-- Section CTA -->

<?php
// Footer loading
include_once './src/views/components/footer.html.php';
