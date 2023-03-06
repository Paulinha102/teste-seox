<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="description" content="Videos">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#222222">
    <meta name="msapplication-navbutton-color" content="#222222">
    <meta name="apple-mobile-web-app-status-bar-style" content="#222222">
    <meta name="format-detection" content="telephone=no">
    <meta>

    <title>Teste Seox</title>

    <link rel="stylesheet" href="./styles/bootstrap/bootstrap-grid.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    <script src="./scripts/carrossel.js"></script>
</head>

<body>
    
    <div class="wrapper-videos" style="color:#000">
    <?php require __DIR__ . '/WPPosts.php';
    $wposts = new WPPosts('?_embed&per_page=6');
    $videos = json_decode($wposts->posts()->getData());

    $wcomments = new WPPosts();
    $comments = json_decode($wcomments->comments()->getData());
    ?>
        <div class="container px-4 p-xl-0">
            <header>
                <h1 class="">VÍDEOS</h1>
                <div class="btns-right">
                    <a class="bt" rel="noopener noreferrer" href="https://teste-frontend.seox.com.br/" target="_blank" title="VEJA MAIS">VEJA MAIS <i class="ico arrow-right"></i></a>
                    <div class="nav-carrossel">
                        <button class="slider-button-up" disabled title="Anterior"><i class="ico arrow-up"></i></button>
                        <button class="slider-button-down" title="Próximo"><i class="ico arrow-down"></i></button>
                    </div>
                </div>

            </header>
        </div>


        <main>
            <div class="container px-4 p-xl-0">
                <div class="row">
                    <div class="col-md-7 col-lg-8 col-xl-9">
                        <?php
                        foreach($videos as $video){
                            echo $wposts->creatCard($video, 'card-video--large');
                            break 1;
                        }
                        ?>
                    </div>
                    <div class="col-md-5 col-lg-4 col-xl-3">
                        <div class="carrossel-videos">
                            <div class="wrapper-itens">
                                <?php 
                                $count = 0;
                                foreach($videos as $video){
                                    if($count != 0){
                                        echo '<div class="item-carrossel">';
                                            echo $wposts->creatCard($video);
                                            
                                        echo '</div>';
                                    }
                                    $count++;
                                }
                                ?>
                                
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </main>


        
</body>

</html>