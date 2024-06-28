<?php
if ($_SERVER["REQUEST_METHOD"] !="POST") { /* verifica richiesta post */
    header("Location: /contatti.html");
}
else {
   /*  connessione */
$dbconn = pg_connect("host=localhost port=5432 dbname=Sito
        user=postgres password=123456")
        or die('Could not connect: ' . pg_last_error());
}
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <?php
            if($dbconn) {
                $email= $_POST['email'];
                $q1 = "select * from iscrizione where email= $1";
                $result= pg_query_params ($dbconn , $q1 , array($email));
                if ($tuple=pg_fetch_array($result, null, PGSQL_ASSOC)) {

                    /* pagina a cui rimanda in caso di errore (email già usata) */
                    header("Location: iscrizionepag.html") ;
                   
                       
            }
            else {
                $email = $_POST['email'];
                $nome = $_POST['nome'];
                $cognome= $_POST['cognome'];
                $DataDiNascita= $_POST['DataDiNascita'];
                $telefono = $_POST['telefono'];
                $classe= $_POST['classe'];
                $messaggio= $_POST['messaggio'];
                $q2 = "insert into iscrizione values ($1, $2, $3, $4, $5, $6, $7)";
                $data=pg_query_params($dbconn, $q2,
                        array($email, $nome, $cognome, $DataDiNascita, $telefono, $classe, $messaggio));
                if ($data) {
                    
                  /* pagina a cui rimanda in caso di richiesta inviata */
                     header("Location: inviatopag.html") ;
                }
        
        }
    }
?>
</body>
</html>