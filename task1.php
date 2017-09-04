re_once(dirname(__FILE__) . '/No2SMS_Client.class.php');

$user        = 'devjob';
$password    = "cG9vcmx5Y29kZWRwYXNzd29yZA==";

$decoded_pass= base64_decode($password);

$destination = "0765363776";
$message     = "Nevena Radovanovic https://github.com/NevenaR/Testing/blob/master/task1.php";

/* affichage des informations avancées du message, nombre de SMS utilsés etc. */
var_dump(No2SMS_Client::message_infos($message, TRUE));
var_dump(No2SMS_Client::test_message_conversion($message));

/* on crée un nouveau client pour l'API */
$client = new No2SMS_Client($user, $decoded_pass);

try {
    /* test de l'authentification */
    if (!$client->auth())
        die('mauvais utilisateur ou mot de passe');

    /* envoi du SMS */
    print "===> ENVOI\n";
    $res = $client->send_message($destination, $message);
    var_dump($res);
    $id = $res[0][2];
    printf("SMS-ID: %s\n", $id);

    print "===> STATUT\n";
    $res = $client->get_status($id);
    var_dump($res);

    /* on affiche le nombre de crédits restant */
    $credits = $client->get_credits();
    printf("===> Il vous reste %d crédits\n", $credits);

} catch (No2SMS_Exception $e) {
    printf("!!! Problème de connexion: %s", $e->getMessage());
    exit(1);
}

