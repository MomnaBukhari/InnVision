<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innvision - Unauthorized Action</title>
    <style>
        * {
            font-family: 'Times New Roman', Times, serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            line-height: 1.5;
            overflow-x: hidden;
        }

        body {
            height: 100vh;
            width: 100vw;
            background-color: #f8f6f4;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        ::selection {
            background: #0b245b;
            color: #fff;
        }

        .main-div-unauthorized {
            width: 80%;
            height: 80%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(180deg, #ffffff, #ffffff);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid black;

        }

        .div-unauthorized-1,
        .div-unauthorized-2 {
            width: 50%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .div-unauthorized-1 h1 {
            font-size: 3rem;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .div-unauthorized-1 p {
            font-size: 1.25rem;
            margin-bottom: 20px;
            color: #0b245b;
        }

        .div-unauthorized-1 a {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #626262;
            text-decoration: none;
            border-radius: 3px;
        }

        .div-unauthorized-1 a:hover {
            background-color: #8c8c8c;
            transition-delay: 0.1s;
            transition-duration: 0.5s;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);

        }

        .div-unauthorized-2 img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <div class="main-div-unauthorized">
        <div class="div-unauthorized-1">
            <h1>403 - Unauthorized</h1>
            <p>Sorry, you are not authorized to perform this action.</p>
            <a href="{{ url('/') }}">Go to Home</a>
        </div>
        <div class="div-unauthorized-2">
            <img src="{{ asset('Illustrations/UnauthorizedAction.png') }}" alt="Unauthorized Action">
        </div>
    </div>
</body>

</html>