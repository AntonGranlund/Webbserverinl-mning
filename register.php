

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "guessing_game";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    guesses INT(6) DEFAULT 0,
    high_score INT(6) DEFAULT 9999
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$sql = "INSERT INTO users (username) VALUES"; // Add a semicolon at the end of this line

$conn->close();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $guess = $_POST['guess'];
    $correct_number =  1; // Det hemliga numret att gissa

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
}
    if ('guess' == $coreect_number) {
        'high_score' +=1 ;
    } else {
        $message = "Fel gissning. Försök igen.";


    }

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $guesses = $user['guesses'] + 1;
        $high_score = $user['high_score'];
    }
        if ($guess == $correct_number) {
            if ($guesses < $high_score) {
                $high_score = $guesses;
            }

            $sql = "UPDATE users SET guesses=0, high_score=$high_score WHERE username='$username'";
            $message = "Grattis! Du gissade rätt.";
        } else {
            $sql = "UPDATE users SET guesses=$guesses WHERE username='$username'";
            $message = "Fel gissning. Försök igen.";
        }

        $host = 'localhost';
        $port = 3000;

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            die("Failed to create socket: " . socket_strerror(socket_last_error()));
        }

        $result = socket_bind($socket, $host, $port);
        if ($result === false) {
            die("Failed to bind socket: " . socket_strerror(socket_last_error($socket)));
        }

        $result = socket_listen($socket, 1);
        if ($result === false) {
            die("Failed to listen on socket: " . socket_strerror(socket_last_error($socket)));
        }

        echo "Server started. Listening on port $port\n";

        while (true) {
            $clientSocket = socket_accept($socket);
            if ($clientSocket === false) {
                die("Failed to accept client connection: " . socket_strerror(socket_last_error($socket)));
            }

            $message = "Welcome to the multiplayer game!\n";
            socket_write($clientSocket, $message, strlen($message));

            $input = socket_read($clientSocket, 1024);
            $input = trim($input);

            $response = "You entered: $input\n";
            socket_write($clientSocket, $response, strlen($response));

            socket_close($clientSocket);
        }

        socket_close($socket);

        function multiplayerGame($port) {
            $host = 'localhost';

            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if ($socket === false) {
                die("Failed to create socket: " . socket_strerror(socket_last_error()));
            }

            $result = socket_bind($socket, $host, $port);
            if ($result === false) {
                die("Failed to bind socket: " . socket_strerror(socket_last_error($socket)));
            }

            $result = socket_listen($socket, 1);
            if ($result === false) {
                die("Failed to listen on socket: " . socket_strerror(socket_last_error($socket)));
            }

            echo "Server started. Listening on port $port\n";

            while (true) {
                $clientSocket = socket_accept($socket);
                if ($clientSocket === false) {
                    die("Failed to accept client connection: " . socket_strerror(socket_last_error($socket)));
                }

                $message = "Welcome to the multiplayer game!\n";
                socket_write($clientSocket, $message, strlen($message));

                $input = socket_read($clientSocket, 1024);
                $input = trim($input);

                $response = "You entered: $input\n";
                socket_write($clientSocket, $response, strlen($response));

                socket_close($clientSocket);
            }

            socket_close($socket);
        }

        $port = 3000;
        multiplayerGame($port);