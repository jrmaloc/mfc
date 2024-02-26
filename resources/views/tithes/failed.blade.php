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
        color: #4b83b0;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    p {
        color: #40455e;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    i {
        color: #0e53d4;
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

    .checkmark {
        color: #a3aef0;
        font-size: 180px;
        line-height: 200px;
        margin-left: -15px;
    }
</style>

<body>
    <div class="card">
        <div style="border-radius:200px; height:200px; width:200px; background: #f5f7fa; margin:0 auto;">
            <i class="checkmark">!</i>
        </div>
        <h1>Failed</h1>
        <p>Payment Failed!<br />Please check your balance and <a href="{{ route('tithes.create') }}" class="try-again">try again.</a></p>
    </div>
</body>

</html>
