<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Speller</title>
    <script
      src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous"></script>
</head>
<body>
    <div><input type="textarea" id='text_input'/>
    <button id = 'submit'>Submit</button>
    </div><div id='answer'></div>
    <script type="text/javascript">
    
        function map(item){
            $('#answer').append('<div>'+ item['word'] +' - ' + item['count'] + '</div>');
        }
        /* global $ */
        $('#submit').click(function(e){
            $.post('runner/processor.php',$('#textarea').val(),function(data,status,jq){
                $('#answer').empty();
                for(var x = 0; x < 0; x++){
                    map(data[x]);
                }
            },'json');
        });
        
    </script>
    
</body>
</html>