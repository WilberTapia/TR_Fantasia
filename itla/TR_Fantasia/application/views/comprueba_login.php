<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprueba Login</title>
</head>
<body>

    <?php

    try{
        $base=new PDO("mysql:host=localhost; dbname=Tr","root","");
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql="SELECT * FROM USUARIOS WHERE USUARIOS=:login AND PASSWORD=:password";

        $CI =& get_instance();
        $CI ->db->where('usuarios',$_POST["login"]);
        $CI ->db->where('password',$_POST["password"]);
        $rs = $CI->db->get('USUARIOS')->result_array();

        $resultado=$base->prepare($sql);
        $login=htmlentities(addslashes($_POST["login"]));
        $password=htmlentities(addslashes($_POST["password"]));

        $resultado->bindValue(":login", $login);
        $resultado->bindValue(":password",$password);
        $resultado->execute();

        $numero_registro=$resultado->rowCount();
        if($numero_registro!=0){
            session_start();
            $_SESSION['user'] = $rs[0]['usuarios'];
            $_SESSION['nombre'] = $rs[0]['nombre'];
            redirect ('main/home');
        }else{
            redirect('main');
            $errorlogin = 'Usuario o Contraseña son invalidos';
            
        }

    }catch(Exception $e){
        die("Error: ".$e->getMessage());
    }
    ?>


</body>
</html>
