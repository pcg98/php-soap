<?php
/*
 * Servicio Web en PHP por Jose Hernández
 * https://josehernandez.es/2011/01/18/servicio-web-php.html
 * https://web.archive.org/web/20201026070426/https://josehernandez.es/2011/01/18/servicio-web-php.html
 */

class GestionAutomoviles {


    public function TestBD() {
        $con = $this->ConectarMarcas();
    }

    public function ConectarMarcas() {
        try {
            $user = "coches";  // usuario con el que se va conectar con MySQL
            $pass = "coches";  // contraseña del usuario
            $dbname = "coches";  // nombre de la base de datos
            $host = "localhost";  // nombre o IP del host

            $db = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);  //conectar con MySQL y SELECCIONAR LA Base de Datos
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //Manejo de errores con PDOException
            echo "<p>Se ha conectado a la BD $dbname.</p>\n";
            return $db;
        } catch (PDOException $e) {  // Si hubieran errores de conexión, se captura un objeto de tipo PDOException
            print "<p>Error: No se pudo conectar con la BD $dbname.</p>\n";
            print "<p>Error: " . $e->getMessage() . "</p>\n";  // mensaje de excepción

            exit();  // terminar si no hay conexión $db
        }
    }
    public function authenticate($header_params) {
        if ($header_params->username == 'ies' && $header_params->password == 'daw') {
            return true;
        } else {
            throw new SoapFault('Wrong user/pass combination', 401);
        }
    }

    public function ObtenerMarcas() {
        $con = $this->ConectarMarcas();

        $marcas = array();
        if ($con) {
            $result = $con->query('select id, marca from marcas');

            while ($row = $result->fetch(PDO::FETCH_ASSOC))
                $marcas[$row['id']] = $row['marca'];
        }
        return $marcas;
    }

    public function ObtenerModelos($marca) {
        $marca = intVal($marca);
        $modelos = array();

        if ($marca !== 0) {
            $con = $this->ConectarMarcas();
            $con->query("SET CHARACTER SET utf8");

            if ($con) {
                $result = $con->query('select id, modelo from modelos ' .
                    'where marca = ' . $marca);

                while ($row = $result->fetch(PDO::FETCH_ASSOC))
                    $modelos[$row['id']] = $row['modelo'];
            }
        }

        return $modelos;
    }

    public function ObtenerMarcasUrl() {
        $urls = array();
        $con = $this->ConectarMarcas();
        $con->query("SET CHARACTER SET utf8");

        if ($con) {
            $result = $con->query('select id, marca, url from marcas');
            while ($row = $result->fetch(PDO::FETCH_ASSOC))
                    $urls[$row['marca']] = $row['url'];
        }
        return $urls;
    }
    public function ObtenerModelosPorMarca($marca) {
        $modelos = array();
        var_dump($marca);
        if ($marca !== "") {
            $con = $this->ConectarMarcas();
            $con->query("SET CHARACTER SET utf8");
            if ($con) {
                $result = $con->prepare("select modelo from modelos, marcas where marcas.marca = ? and modelos.marca = marcas.id");
                print("Hello");
                $result->bindParam(1, $marca, PDO::PARAM_STR);
                print("Hello");
                $result->execute();
                print("Hello");
                $rows = $result->fetchAll();
                return $rows;
            }
        }

        return false;
    }
}

