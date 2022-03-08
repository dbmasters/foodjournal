<!doctype html>
<html lang="en">
    <head>
        <title>Food Journal</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="includes/jqueryui/jquery-ui.min.css">
        <link rel="stylesheet" href="includes/jquery/jquery.dataTables.css">
        <link rel="stylesheet" href="includes/bootstrap/css/bootstrap.min.css">
        <script src="includes/jquery/jquery-3.6.0.min.js"></script>
        <script src="includes/jqueryui/jquery-ui.min.js"></script>
        <script src="includes/jquery/jquery.dataTables.js"></script>
        <script src="includes/bootstrap/js/bootstrap.min.js"></script>
        <style>
            body { font-family: Arial; background-color: #e9e9e9; }
            #site{ width: 960px; margin: 10px auto;border: solid 1px #000; background-color: #fff; }
            #dataTable thead th,
            #dataTable tbody td {
                padding: 4px 2px;
            }
        </style>
        <script>
            $(document).ready( function () {
                $('#dataTable').DataTable({
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "searching": false
                });
            } );
        </script>
    </head>
    <body>
        <div id="site">
