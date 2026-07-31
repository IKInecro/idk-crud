<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #07122e;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            font-family: sans-serif;
        }
        #rock {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: opacity 0.4s ease-in-out;
            z-index: 50;
            max-width: 50vw;
            max-height: 50vh;
            width: 50vw;
            height: 50vh;
            object-fit: cover;
            box-shadow: 0 0 80px rgba(0,0,0,0.8);
            border-radius: 16px;
        }
        #rock.visible { opacity: 1; }
        #overlay {
            position: fixed;
            inset: 0;
            background: rgba(7, 18, 46, 0.97);
            z-index: 40;
        }
        #press {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 70;
            background: linear-gradient(to right, #D97706, #B45309);
            color: #fff;
            border: none;
            border-radius: 999px;
            padding: 18px 48px;
            font-size: 20px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 12px 30px -8px rgba(217,119,6,0.6);
            animation: pulse 1s ease-in-out infinite;
            letter-spacing: 0.1em;
        }
        #press:hover { filter: brightness(1.1); }
        @keyframes pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.05); }
        }
    </style>
</head>
<body>
    <div id="overlay"></div>
    <img id="rock" src="{{ asset('images/rock.jpg') }}" alt="403">
    <audio id="sound" src="{{ asset('images/sound.mp3') }}" preload="auto"></audio>
    <button id="press">TEKAN</button>

    <script>
        const rock = document.getElementById('rock');
        const sound = document.getElementById('sound');
        const press = document.getElementById('press');

        const fallback = @auth '/dashboard' @else '/login' @endauth;
        const ref = document.referrer || '';
        const sameOrigin = ref.startsWith(window.location.origin);
        const target = (ref && sameOrigin && ref !== window.location.href) ? ref : fallback;

        press.addEventListener('click', () => {
            press.style.display = 'none';
            rock.classList.add('visible');
            sound.currentTime = 0;
            sound.play().catch(() => {});
            setTimeout(() => {
                rock.classList.remove('visible');
                setTimeout(() => { window.location.href = target; }, 400);
            }, 1500);
        });
    </script>
</body>
</html>
