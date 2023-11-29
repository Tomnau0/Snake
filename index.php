<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snake Game</title>
    <style>
        body{
            background: gray;
        }
        canvas {
            background: #000;
            border: 5px solid #795548;
            margin: 20px auto;
            display: block;
        }
    </style>
</head>
<body id="body">
<h1 id="score" style="text-align: start">0</h1>
    <canvas id="snakeCanvas" width="400" height="400"></canvas>
    <script>
        const otryzhka = new Audio('/click.mp3');
        const gameOver = new Audio('gameOver.mp3');
        const countScore=document.querySelector('#score');
        
        
        // Инициализация canvas
        const canvas = document.getElementById("snakeCanvas");
        const ctx = canvas.getContext("2d");

        // Константы
        const GRID_SIZE = 20;
        const WIDTH = canvas.width;//400
        const HEIGHT = canvas.height;//400
        
        
        // Инициализация змеи
        let snake = [{ x: 100, y: 100 }, { x: 90, y: 100 }, { x: 80, y: 100 }];

        let snakeDirection = { x: GRID_SIZE, y: 0 };

        console.log(Math.floor(Math.random() * (WIDTH / GRID_SIZE)) * GRID_SIZE);
        // Инициализация фрукта
        let fruit = { x: Math.floor(Math.random() * (WIDTH / GRID_SIZE)) * GRID_SIZE, y: Math.floor(Math.random() * (HEIGHT / GRID_SIZE)) * GRID_SIZE };

        // Инициализация счета
        let score = 0;

        // Функция отрисовки змеи
        function drawSnake() {
            ctx.fillStyle = "#54bb2e";
            snake.forEach(segment => ctx.fillRect(segment.x, segment.y, GRID_SIZE, GRID_SIZE));
        }

        // Функция отрисовки фрукта
        function drawFruit() {
            ctx.fillStyle = "#FF0000";
            ctx.fillRect(fruit.x, fruit.y, GRID_SIZE, GRID_SIZE);
        }

        // Функция обновления экрана
        function updateScreen() {
            ctx.clearRect(0, 0, WIDTH, HEIGHT);
            drawSnake();
            drawFruit();
        }

        // Главная функция обновления игры
        function updateGame() {
            // Обновление позиции змеи


            const newHead = { x: snake[0].x + snakeDirection.x, y: snake[0].y + snakeDirection.y };
            snake.unshift(newHead);

            // Проверка на столкновение с фруктом
            if (newHead.x === fruit.x && newHead.y === fruit.y) {
                otryzhka.play();
                score++;
                countScore.textContent=score;
                fruit = { x: Math.floor(Math.random() * (WIDTH / GRID_SIZE)) * GRID_SIZE, y: Math.floor(Math.random() * (HEIGHT / GRID_SIZE)) * GRID_SIZE };
            } else {

                snake.pop();
            }

            // Проверка на столкновение с границами
            if (newHead.x < 0 || newHead.x >= WIDTH || newHead.y < 0 || newHead.y >= HEIGHT) {
                gameOver.play();
                alert("Game Over! Набрано " + score);
                resetGame();
            }

            // Проверка на столкновение с самой собой
            if (checkCollision(newHead, snake.slice(1))) {
                gameOver.play();
                alert("Game Over! Набрано " + score);
                resetGame();
            }

            // Обновление экрана
            updateScreen();
        }

        // Функция проверки столкновения
        function checkCollision(head, array) {
            return array.some(segment => segment.x === head.x && segment.y === head.y);
        }

        // Функция сброса игры
        function resetGame() {
            snake = [{ x: 100, y: 100 }, { x: 90, y: 100 }, { x: 80, y: 100 }];
            snakeDirection = { x: GRID_SIZE, y: 0 };
            fruit = { x: Math.floor(Math.random() * (WIDTH / GRID_SIZE)) * GRID_SIZE, y: Math.floor(Math.random() * (HEIGHT / GRID_SIZE)) * GRID_SIZE };
            score = 0;
        }

        // Обработка нажатий клавиш
        window.addEventListener("keydown", (event) => {
            switch (event.key) {
                case "ArrowUp":
                    if (snakeDirection.y !== GRID_SIZE) {
                        snakeDirection = { x: 0, y: -GRID_SIZE };
                    }
                    break;
                case "ArrowDown":
                    if (snakeDirection.y !== -GRID_SIZE) {
                        snakeDirection = { x: 0, y: GRID_SIZE };
                    }
                    break;
                case "ArrowLeft":
                    if (snakeDirection.x !== GRID_SIZE) {
                        snakeDirection = { x: -GRID_SIZE, y: 0 };
                    }
                    break;
                case "ArrowRight":
                    if (snakeDirection.x !== -GRID_SIZE) {
                        snakeDirection = { x: GRID_SIZE, y: 0 };
                    }
                    break;
            }
        });

        // Главный цикл игры
        function gameLoop() {
            updateGame();
            setTimeout(gameLoop, 200);
        }

        // Запуск игры
        gameLoop();
    </script>
</body>
</html>
