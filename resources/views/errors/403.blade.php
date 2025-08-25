<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>403 – Access Denied</title>
    <style>
        /* ===== RESET ===== */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* ===== FONT ===== */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Raleway:wght@700&display=swap');

        /* ===== ROOT VARIABLES ===== */
        :root {
            --bg1: #0f0c29;
            --bg2: #302b63;
            --bg3: #24243e;
            --accent: #ff2e63;
            --text: #eaeaea;
            --font-title: 'Raleway', sans-serif;
            --font-body: 'Poppins', sans-serif;
        }

        /* ===== GLOBAL ===== */
        html,
        body {
            height: 100%;
        }

        body {
            font-family: var(--font-body);
            background: linear-gradient(-45deg, var(--bg1), var(--bg2), var(--bg3));
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        /* ===== PARTICLES ===== */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) translateX(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) translateX(100px);
                opacity: 0;
            }
        }

        /* ===== CONTENT ===== */
        .wrapper {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 2rem;
            max-width: 600px;
        }

        .title {
            font-family: var(--font-title);
            font-size: clamp(3rem, 10vw, 6rem);
            font-weight: 700;
            color: var(--accent);
            animation: pulse 2s infinite;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            font-size: clamp(1.2rem, 4vw, 1.75rem);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .description {
            font-size: clamp(0.9rem, 2.5vw, 1.1rem);
            margin-bottom: 2rem;
            line-height: 1.6;
            color: #c7c7c7;
        }

        /* ===== BUTTON ===== */
        .btn {
            display: inline-block;
            padding: 0.9rem 2.2rem;
            border: 2px solid var(--accent);
            border-radius: 50px;
            background: transparent;
            color: var(--accent);
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn:hover {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 0 15px var(--accent);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 500px) {
            .description {
                margin: 0 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="particles" id="particles"></div>

    <div class="wrapper">
        <h1 class="title">403</h1>
        <h2 class="subtitle">Access Denied</h2>
        <p class="description">
            You don't have permission to access this page.<br>
            If you believe this is an error, please contact the administrator.
        </p>
        <form action="{{ route('keluar') }}" method="post">
            @csrf
            <button type="submit" class="btn">Logout</button>
        </form>
    </div>

    <!-- PARTICLES SCRIPT -->
    <script>
        const particlesContainer = document.getElementById('particles');
        const count = 50;

        for (let i = 0; i < count; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.left = Math.random() * 100 + 'vw';
            p.style.animationDuration = 15 + Math.random() * 10 + 's';
            p.style.animationDelay = Math.random() * 10 + 's';
            particlesContainer.appendChild(p);
        }
    </script>
</body>

</html>
