<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
</head>
<style>
    body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
    }

    h1 {
        color: #b0a94b;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    i {
        color: #d4c70e;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }

    .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 8% auto;
    }

    .try-again{
        color: #30772a;

    }
</style>

<body>
    <div class="card">
        <div style="border-radius:200px; height:200px; width:200px; background: #fafaf5; margin:0 auto;">
            <i class="checkmark">❕</i>
        </div>
        <h1>Failed</h1>
        <p>Payment Failed!<br />Please check your balance and <a href="{{ route('calendar.list') }}" class="try-again">try again.</a></p>
    </div>
</body>

</html>
