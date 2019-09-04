<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Charts</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{{ asset('css/custom.css') }}}" rel="stylesheet" type="text/css">

    <!-- Scrips -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="{{{ asset('js/custom.js') }}}"></script>

</head>
<body>
<div class="flex-center position-ref full-height">
    <h3>Weekly Retention Cohort Chart</h3>
    <div class="content">
        <div id="weekly_cohort" style="width:500px; height:400px;"></div>
    </div>
</div>
</body>
</html>