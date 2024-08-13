# Serpent-s-Quest

Game Description:
"Serpent's Quest" is a modern take on the classic Snake game, where players navigate a growing snake through a 20x20 grid, consuming food to increase their score while avoiding collisions with walls or their own tail. The game combines the simplicity of the traditional Snake with a sleek design and engaging mechanics, making it both nostalgic and fresh.

Features:
Dynamic Gameplay: The snake moves continuously on the grid, with the player controlling its direction using arrow keys.
Score Tracking: Each time the snake eats food, the score increases. The game displays both the current score and the last high score, giving players a target to beat.
High Score System: After every game, the player's score is saved to a database. If a player sets a new high score, it is prominently displayed, adding a competitive edge.
Responsive Design: The game features a responsive design, ensuring it looks great and functions well on various devices and screen sizes.

Technical Details:
Frontend: The game interface is built using HTML, CSS, and JavaScript. The game board is designed as a grid, and the snake and food are represented by colored div elements.
Backend: The game uses PHP and MySQL to handle score storage. When a game ends, the score is sent to the server, where it is compared with the previous high score and stored if it surpasses it.
Database: The game stores all scores in a MySQL database, allowing for persistent high score tracking across sessions.

How to Play:
Start the Game: The game begins as soon as you load the page. Use the arrow keys to control the snake's movement.
Objective: Navigate the snake to consume food items that appear randomly on the board. Each food item increases your score by 1.
Avoid Collisions: The game ends if the snake runs into the walls or itself. At the end of the game, your score is saved, and you'll be informed if you've set a new high score.
Compete: Try to beat your previous high score and challenge friends to see who can achieve the highest score in "Serpent's Quest."

Future Enhancements:
Levels and Challenges: Adding different levels with increasing difficulty and special challenges to keep the game engaging.
Power-ups: Introducing power-ups that can temporarily boost the snake's speed or allow it to pass through walls.
Multiplayer Mode: Implementing a multiplayer mode where players can compete against each other in real-time.
