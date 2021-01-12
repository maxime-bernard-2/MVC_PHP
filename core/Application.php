<?php

class Application
{
    public function loadEnv() {
        $handle = @fopen(".env", 'rb');

        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                if($buffer[0] !== '#' && !ctype_space($buffer)) {
                    $contant = explode('=', $buffer);
                    $_ENV[$contant[0]] = $contant[1];
                }
            }
            if (!feof($handle)) {
                echo "Erreur: veuillez verifier votre .env\n";
            }
            fclose($handle);
        }
    }
}