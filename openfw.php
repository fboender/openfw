<?php

error_reporting(E_ALL);

# Sha265 hashed password. 
$password = "081v096d09r97q272zo1d7w3x64wo68g73h51a857pd7432c3019hz8";

if (array_key_exists('r_code', $_POST)) {
    if (hash("sha256", $_POST['r_code']) == $password) {
        // Correct password
        $retval = -1;
        $remote_ip = $_SERVER['REMOTE_ADDR'];

        # FIXME: Use exec() and capture output
        system("/usr/bin/sudo /usr/local/sbin/openfw.sh add ".$remote_ip, $retval);
        if ($retval === 0) {
            $result = "Access has been enabled from your location (".$remote_ip.")";
        } else {
            $result = "There was an error while enabling access from your location.";
        }
    } else {
        // Wrong password
        $result = "Invalid code. <a href='openfw.php'>Try again</a>.";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title></title>
<meta name="description" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    body {
        background-color: #202020;
        font-family: sans-serif;
    }
    .contents {
        /* color: #900000; */
        color: #D0D0D0;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%)
    }
    .fire {
        color: #FFB900;
        margin-right: 32px;
    }
    td {
        text-align: center;
        line-height: 64px;
    }
    input {
        border: 0px;
        padding: 8px;
        background: #E9E9E9;
    }
    input.password {
        margin-right: 32px;
    }
    td.label {
        border-bottom: 1px solid #505050;
    }
    p.result {
        font-weight: bold;
    }
    a {
        color: #0087FF;
    }
</style>
</head>
<body>
    <div class="contents">
        <?php
        if (isset($result)) {
            ?><p class="result"><?php echo($result);?></p><?php
        } else {
            ?>
            <form name="code" method="POST">
                <table>
                    <tr>
                        <td class="label">
                            <b>Enter access code</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="fire">🔥</span>
                            <input class="password" type="password" name="r_code" />
                            <input type="submit" value="Go" />
                        </td>
                    </tr>
                </table>
            </form>
            <script lang="javascript">
                document.code.r_code.focus();
            </script>
            <?php
        }
        ?>
    </div>
</body>
</html>
