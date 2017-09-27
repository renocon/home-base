<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Speller</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <script
      src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous"></script>
</head>
<body>
    <div class='col-md-6'><input type="textarea" id='text_input'/>
    <button id = 'submit' class='btn-default'>Submit</button>
    </div><div class='col-md-6' id='answer'></div>
    <script type="text/javascript">
    
        function map(item){
            $('#answer').append('<div>'+ item['word'] +': ' + item['count'] + '</div>');
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