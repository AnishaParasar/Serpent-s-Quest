<?php
// Database credentials
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "Mysql@2023";  // Replace with your MySQL password
$dbname = "snake_game";  // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the last high score
$lastHighScore = 0;
$sql = "SELECT MAX(score) AS high_score FROM snake_score";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastHighScore = $row['high_score'];
}

// Handle score saving if POST request is detected
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = isset($_POST['score']) ? (int)$_POST['score'] : 0;

    // Insert score into database
    $sql = "INSERT INTO snake_score (score) VALUES ($score)";
    if ($conn->query($sql) === TRUE) {
        echo "New score saved successfully!! ";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Check if the current score is a new high score
    if ($score > $lastHighScore) {
        echo "Congratulations, you made a new high score!! The new high score is $score";
    } else {
        echo "Your score was $score. The current high score is $lastHighScore.";
    }

    $conn->close();
    exit;  // Terminate script after processing POST request
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snake Game</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #333;
            color: white;
            font-family: Arial, sans-serif;
        }

        #game-board {
            width: 400px;
            height: 400px;
            background-color: black;
            display: grid;
            grid-template-rows: repeat(20, 1fr);
            grid-template-columns: repeat(20, 1fr);
            border: 2px solid #fff;
        }

        .snake, .food {
            width: 100%;
            height: 100%;
        }

        .snake {
            background-color: green;
        }

        .food {
            background-color: red;
        }

        #score-container {
            margin-top: 20px;
        }

        #high-score-container {
            margin-top: 10px;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <h1>Snake Game</h1>
    <div id="high-score-container">
        Last High Score: <span id="high-score"><?php echo $lastHighScore; ?></span>
    </div>
    <div id="game-board"></div>
    <div id="score-container">
        <p>Score: <span id="score">0</span></p>
    </div>
    <script>
        const gameBoard = document.getElementById('game-board');
        const scoreElement = document.getElementById('score');
        const highScoreElement = document.getElementById('high-score');

        const boardSize = 20;
        let snake = [{ x: 10, y: 10 }];
        let food = generateFood();
        let direction = { x: 0, y: 0 };
        let score = 0;
        let gameInterval;

        function startGame() {
            gameInterval = setInterval(updateGame, 100);
            document.addEventListener('keydown', changeDirection);
        }

        function updateGame() {
            const head = { x: snake[0].x + direction.x, y: snake[0].y + direction.y };

            if (checkCollision(head)) {
                saveScore(score); // Save score when the game is over
                clearInterval(gameInterval);
                return;
            }

            snake.unshift(head);

            if (head.x === food.x && head.y === food.y) {
                score++;
                scoreElement.textContent = score;
                food = generateFood();
            } else {
                snake.pop();
            }

            render();
        }

        function changeDirection(event) {
            const key = event.key;

            if (key === 'ArrowUp' && direction.y === 0) {
                direction = { x: 0, y: -1 };
            } else if (key === 'ArrowDown' && direction.y === 0) {
                direction = { x: 0, y: 1 };
            } else if (key === 'ArrowLeft' && direction.x === 0) {
                direction = { x: -1, y: 0 };
            } else if (key === 'ArrowRight' && direction.x === 0) {
                direction = { x: 1, y: 0 };
            }
        }

        function checkCollision(head) {
            if (head.x < 0 || head.x >= boardSize || head.y < 0 || head.y >= boardSize) {
                return true;
            }

            for (let i = 1; i < snake.length; i++) {
                if (head.x === snake[i].x && head.y === snake[i].y) {
                    return true;
                }
            }

            return false;
        }

        function generateFood() {
            let foodPosition;

            do {
                foodPosition = {
                    x: Math.floor(Math.random() * boardSize),
                    y: Math.floor(Math.random() * boardSize),
                };
            } while (snake.some(segment => segment.x === foodPosition.x && segment.y === foodPosition.y));

            return foodPosition;
        }

        function render() {
            gameBoard.innerHTML = '';

            snake.forEach(segment => {
                const snakeElement = document.createElement('div');
                snakeElement.style.gridRowStart = segment.y + 1;
                snakeElement.style.gridColumnStart = segment.x + 1;
                snakeElement.classList.add('snake');
                gameBoard.appendChild(snakeElement);
            });

            const foodElement = document.createElement('div');
            foodElement.style.gridRowStart = food.y + 1;
            foodElement.style.gridColumnStart = food.x + 1;
            foodElement.classList.add('food');
            gameBoard.appendChild(foodElement);
        }

        function saveScore(score) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'snakegame.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);  // Display the response (high score message)
                }
            };
            xhr.send(`score=${score}`);
        }

        startGame();
    </script>
</body>
</html>
