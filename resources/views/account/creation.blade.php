<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account creation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        main {
            width:100%;
            max-width: 650px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 30px;
        }

        #password {
            font-size: 18px;
            padding: 12px 24px;
            color: dimgray;
            background:white;
            border:1px solid dimgray;
            border-radius: 2px;
        }

        h3 {
            font-size: 28px;
        }

    </style>
</head>
<body>
    <main>
         <h3>Confirm your account creation</h3>
         <p>You was created by <strong>{{$admin->firstname}} {{$admin->lastname}}</strong></p>

         <a id="password">Setup password</a>
    </main>

</body>
</html>