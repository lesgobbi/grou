<?php
ob_start();
require('./_app/Config.inc.php');
$Link = new Link;

$readGeneral = new Read;
$readGeneral->ExeRead('general', "WHERE id = :id", "id=1");
$general = $readGeneral->getResult()[0];
extract($general);

$area = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
$name = filter_input(INPUT_GET, 'name', FILTER_DEFAULT);
$param = filter_input(INPUT_GET, 'param', FILTER_DEFAULT);

?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta property="og:locale" content="pt_BR">
        <?php
//         if(!empty($area) && !empty($name) && $area != 'noticias' && $area != 'escolha-seu-produto' && $area != 'nossas-marcas'):
//         if(!empty($area)):
//             $readTags = new Read;
//             $readTags->ExeRead('posts', "WHERE post_name = :name", "name={$name}");
//
//             echo '<title>'.$title.' - '.$readTags->getResult()[0]['post_title'].'</title>';
//             echo '<meta name="description" content="'.Check::Words($readTags->getResult()[0]['post_content'], 20).'" />';
//
//             echo '<meta property="og:url" content="'.HOME.'/'.$area.'/'.$readTags->getResult()[0]['post_name'].'">';
//             echo '<meta property="og:title" content="'.$title.' - '.$readTags->getResult()[0]['post_title'].'">';
//             echo '<meta property="og:description" content="'.Check::Words($readTags->getResult()[0]['post_content'], 20).'">';
//             if($readTags->getResult()[0]['post_cover']):
//                 echo '<meta property="og:image" content="'.HOME.'/tim.php?src='.HOME.'/uploads/'.$readTags->getResult()[0]['post_cover'].'&w=470&h=235">';
//                 echo '<meta property="og:image:width" content="470">';
//                 echo '<meta property="og:image:height" content="235">';
//             else:
//                 echo '<meta property="og:image" content="'.HOME.'/images/facebook-cover.png">';
//                 echo '<meta property="og:image:width" content="470">';
//                 echo '<meta property="og:image:height" content="274">';
//
//             endif;
//         else:
             echo '<title>'.$title.'</title>';
             echo '<meta name="description" content="'.$description.'" />';
            
             echo '<meta property="og:url" content="'.HOME.'">';
             echo '<meta property="og:title" content="'.$title.'">';
             echo '<meta property="og:description" content="'.$description.'">';
             echo '<meta property="og:image" content="'.HOME.'/images/facebook-cover.png">';
             echo '<meta property="og:image:width" content="470">';
             echo '<meta property="og:image:height" content="274">';
//         endif;
        ?>
        <meta property="og:image:type" content="image/png">
        <meta property="og:type" content="website">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=320, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,user-scalable=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= CDN; ?>/css/fotorama.css">
        <link rel="stylesheet" href="<?= CDN; ?>/aos/aos.css">
        <link rel="stylesheet" href="<?= INCLUDE_PATH; ?>/assets/css/style.css">

        <link rel="apple-touch-icon" href="favicon.png">
        <link rel="icon" href="favicon.png">

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', '<?= $analytics; ?>', 'auto');
            ga('send', 'pageview');
        </script>

        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://lesgobbi.github.io/cdn/js/fotorama.js"></script>
        <script src="https://lesgobbi.github.io/cdn/aos/aos.js"></script>
        <script src="<?= CDN; ?>/js/jquery.validate.min.js"></script>
        <script src="<?= CDN; ?>/js/messages_pt_BR.js"></script>
        <script src="<?= CDN; ?>/js/jquery.mask.min.js"></script>
        <script src="<?= INCLUDE_PATH; ?>/assets/js/scripts.js"></script>
    </head>

    <body>
        <input id="file-contact" type="hidden" value="<?= HOME ?>"/>
        <?php
        $read = new Read;

        $readLogos = $read;
        $readLogos->ExeRead('posts_gallery', "WHERE post_id = 20 ORDER BY gallery_order ASC");
        $logos = $readLogos->getResult();

        if ($area):
            include(REQUIRE_PATH . DIRECTORY_SEPARATOR . 'internas.php');
        else:
            include(REQUIRE_PATH . DIRECTORY_SEPARATOR . 'home.php');
        endif;
        
        ?>

        <footer class="container-fluid">
            <div class="container">
                <form id="form-contato">
                    <div class="half-input" style="position: relative;">
                        <input type="text" name="nome" placeholder="Nome" autocomplete="nome" required/>
                        <input type="text" name="telefone" class="telefone" placeholder="Telefone" autocomplete="telefone" required/>
                    </div>

                    <div style="position: relative;">
                        <input type="email" name="email" placeholder="E-mail" autocomplete="email" required/>
                    </div>

                    <input type="submit" name="sendContato" value="Solicitar contato" />
                </form>

                <div class="buttons-bottom" data-aos="fade-left" data-aos-anchor-placement="top" data-aos-duration="450">
                    <a class="wa" href="https://api.whatsapp.com/send?phone=5511989539654&text=Ol%C3%A1!%20acessei%20o%20site%20da%20Grou%20e%20gostaria%20de%20mais%20informa%C3%A7%C3%B5es" target="_blank">
                        <img src="<?= HOME; ?>/assets/img/wa.png" /> 11 98953 9654
                    </a>
                    <a target="_blank" href="<?= $social_fb; ?>"><img src="<?= HOME; ?>/assets/img/fb.png" /></a>
                    <a target="_blank" href="<?= $social_li; ?>"><img src="<?= HOME; ?>/assets/img/it.png" /></a>
                </div>
            </div>
        </footer>

        <div class="loader loader--style2" title="1">
            <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="40px" height="40px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                  <path fill="#000" d="M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z">
                      <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"/>
                  </path>
            </svg>
        </div>

    </body>
</html>
<?php
ob_end_flush();