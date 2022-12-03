<h1 class="nombre-pagina">Olvide password</h1>
<p class="descripcion-pagina"> Restablece tu password escribiendo tu email a continuación </p>

<!-- Alertas -->
<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="nombre">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Tu e-mail">
    </div>
    <input type="submit" class="boton" value="Enviar instrucciones">
</form>

<!-- Acciones -->
<div class="acciones">
    <a href="/"> ¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
</div>

