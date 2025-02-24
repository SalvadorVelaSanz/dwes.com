<?php

namespace Ejercicio1\vista;

class V_Main extends Vista {

    public function genera_salida($datos) {
        $this->inicio_html("Vista main", ["/estilos/general.css", "/estilos/formulario.css"]);

        echo "<h1>Inicia sesión</h1>";
        ?>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <fieldset>
                <legend>Datos de inicio de sesión</legend>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave" required>
            </fieldset>
            <button type="submit" name="idp" id="idp" value="Autenticar">Inicia sesión</button>
        </form>
        <?php

        $this->fin_html();
    }
}

?>