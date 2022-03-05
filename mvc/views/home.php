<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$data["title"]?></title>

<!-- link css -->
    <?php
    require_once './mvc/views/assets/main_css.php';
    ?>

</head>
<body>
    
    <div class="block-admin">
        
        <?php require_once './mvc/views/blocks/'.$data["header"].'.php' ?>
        
        <?php require_once './mvc/views/pages/'.$data["page"].'.php' ?>
    
        <?php
        if(isset($data["toast"])) {
			$toast = $data["toast"];
			require_once './mvc/views/components/toast.php';
        }
        ?>

        <div class="margin-bot-50px"></div>
        <?php
        require_once './mvc/views/blocks/'.$data["footer"].'.php';
        ?>
    </div>


<!-- link js -->
    <?php
    require_once './mvc/views/assets/main_js.php';
    ?>

</body>
</html>