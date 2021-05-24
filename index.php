<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div style="border:2px solid;width:800px">
        <svg id="mycanvas" width="800px" height="500px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <rect id="myrect" fill="black" x="100" y="70" width="100" height="100"></rect>
            <!-- <circle id="resize" fill="red" cx="190" cy="160" r="8"></circle> -->
        </svg>
    </div>
</body>
<script>
    var svg = document.getElementById("mycanvas");
    document.addEventListener('mousedown', mousedown, false);
    var mousedown_points;

    function mousedown(e) {
        var target = e.target;
        if (target.id === 'myrect') {
            mousedown_points = {
                x: e.clientX,
                y: e.clientY
            }
            document.addEventListener("mousemove", moveEle, false);
            document.addEventListener("mouseup", moveEleout, false);
        }

        if (target.id === 'resize') {
            mousedown_points = {
                x: e.clientX,
                y: e.clientY
            }
            // console.log(mousedown_points.x);
            document.addEventListener('mouseup', mouseup, false);
            document.addEventListener('mousemove', mousemove, false);
        }
    }

    // movements
    function moveEle(e) {
        var current_points = {
            x: e.clientX,
            y: e.clientY
        }
        // var dx=current_points.x-mousedown_points.x;
        // var dy=current_points.y-mousedown_points.y;

        var rect = document.getElementById('myrect')

        offset = getMousePosition(e);
        offset.x -= parseFloat(rect.getAttribute("x"));
        offset.y -= parseFloat(rect.getAttribute("y"));





        var coord = getMousePosition(e);
        rect.setAttributeNS(null, "x", coord.x - offset.x);
        rect.setAttributeNS(null, "y", coord.y - offset.y);

        // rect.setAttribute('x', current_points.x);
        // rect.setAttribute('y', current_points.y);

        var width = rect.getAttribute('width');
        var height = rect.getAttribute('height');
        // updateResize(current_points.x, current_points.y, width, height);
    }

    function updateResize(x, y, width, height) {
        var resize = document.getElementById('resize');
        // var x=parseFloat(resize.getAttribute('cx'));
        // var y=parseFloat(resize.getAttribute('cy'));
        x += Number(width);
        y += Number(height);

        console.log(x, y)
        resize.setAttribute('cx', x);
        resize.setAttribute('cy', y);
    }

    function moveEleout(e) {
        document.removeEventListener('mousemove', moveEle, false);
        document.removeEventListener('mouseup', moveEleout, false);
    }




    function getMousePosition(evt) {
        var CTM = svg.getScreenCTM();
        return {
            x: (evt.clientX - CTM.e) / CTM.a,
            y: (evt.clientY - CTM.f) / CTM.d
        };
    }








    // resize
    function mousemove(e) {
        var current_points = {
            x: e.clientX,
            y: e.clientY
        }
        var rect = document.getElementById('myrect')
        var w = parseFloat(rect.getAttribute('width'));
        var h = parseFloat(rect.getAttribute('height'));

        var dx = current_points.x - mousedown_points.x;
        var dy = current_points.y - mousedown_points.y;
        // console.log(dx)
        w += dx;
        h += dy;
        rect.setAttribute('width', w);
        rect.setAttribute('height', h);
        // console.log(dx,dy);
        mousedown_points = current_points;
        updateResizeIcon(dx, dy);
    }

    function updateResizeIcon(dx, dy) {
        var resize = document.getElementById('resize');
        var x = parseFloat(resize.getAttribute('cx'));
        var y = parseFloat(resize.getAttribute('cy'));

        y += dy;
        x += dx;

        resize.setAttribute('cx', x);
        resize.setAttribute('cy', y);
    }

    function mouseup(e) {
        document.removeEventListener('mousemove', mousemove, false);
        document.removeEventListener('mouseup', mouseup, false);
    }
</script>

</html>