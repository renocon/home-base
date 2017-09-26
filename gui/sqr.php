<!DOCTYPE html>

<html>
    <head>
        <meta charset = "utf-8">

        <script>
            Element.prototype.leftTopScreen = function () {
                var x = this.offsetLeft;
                var y = this.offsetTop;

                var element = this.offsetParent;

                while (element !== null) {
                    x = parseInt (x) + parseInt (element.offsetLeft);
                    y = parseInt (y) + parseInt (element.offsetTop);

                    element = element.offsetParent;
                }

                return new Array (x, y);
            }

            document.addEventListener ("DOMContentLoaded", function () {
                var flip = document.getElementById ("flip");

                var xy = flip.leftTopScreen ();

                var context = flip.getContext ("2d");

                context.fillStyle = "rgb(255,255,255)";   
                context.fillRect (0, 0, 500, 500);

                flip.addEventListener ("mousemove", function (event) {
                    var x = event.clientX;
                    var y = event.clientY;

                    context.fillStyle = "rgb(255, 0, 0)";  
                    context.fillRect (x - xy[0], y - xy[1], 5, 5);
                });
            });    
        </script>

        <style>
            #flip {
                border: 1px solid black;
                display: inline-block;

            }

            body {
                text-align: center;
            }
        </style>
    </head>

    <body>
        <canvas id = "flip" width = "500" height = "500">This text is displayed if your browser does not support HTML5 Canvas.</canvas>
    </body>
</html>