<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Speller</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">

    <script
      src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous"></script>
</head>
<body>
    <div class='col-md-6'>
        <div><button id = 'submit' class='btn btn-default'>Submit</button></div>
        <div><input type="textarea" id='text_input' class='col-xs-12'/></div>
    
    </div><div class='col-md-6'>
        <table class='table table-striped table-repsonsive'>
            <thead>
                <th>Word</th>
                <th>Count</th>
            </thead>
            <tbody id='answer'>
                
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
    
        function map(item){
            $('#answer').append('<tr><td>'+ item['word'] +'</td><td>' + item['count'] + '</td>');
        }
        /* global $ */
        $('#submit').click(function(e){
            console.log('request sent');
            console.log($('#text_input').val());
            $.post('runner/processor.php',{'text_input':$('#text_input').val()},function(data){
                console.log(data);
                $('#answer').empty();
                for(var x = 0; x < data.length; x++){
                    map(data[x]);
                }
            },'json');
        });
        
    </script>
    
</body>
</html>