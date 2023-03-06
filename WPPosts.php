<?php
class WPPosts {
    const API_URL = 'https://teste-frontend.seox.com.br/wp-json/wp/v2';
    public $args;
    public $action;
    public $response;
    public $data;
    public $httpcode;
    public $timestamp;
    public $lastIntegration;
    public $freshnessInterval = 86400; //86400 =  24 * 60 * 60; // 24h em segundos

    public function __construct($args = '') {
        $this->args = $args;
        $this->timestamp = time();
    }

    // Requisição
    public function get(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->getActionUrl());
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $this->response = curl_exec($curl);
        $this->httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close ($curl);
    }

    // Verifica qual ação se a busca vai ser pelos posts ou comentarios
    public function comments(){
        $this->action = 'comments';
        return $this;
    }
    public function posts(){
        $this->action = 'posts';
        return $this;
    }

    // Verifica se os dados já foram buscados nas ultimas 24h (definidos na variavel - freshnessInterval),
    // se houve requisição nas ultimas 24hr busca pelos dados
    // gravados no arquivo dados.json e, se  necessário, realiza uma nova requisição método integrar()
    public function getData(){
        if($this->lastIntegration){
            if($this->lastIntegration + $this->freshnessInterval < $this->timestamp){
                $this->integrar();
            }

        } else{
            $this->integrar();

        }
        $this->openJsonFile();
        return $this->data;
    }

    //chama o método get() e, se a resposta for bem-sucedida (código de resposta HTTP = 200), salva os dados em um arquivo JSON,
    // salva a data e hora da solicitação em um arquivo JSON separado, registra um log em um arquivo quando a action = posts
    public function integrar(){
        $this->get();
        if($this->httpcode == 200){
            $this->saveAsJsonFile();
            $this->saveLastAccess();
            if($this->action == 'posts'){
                $this->log();
            }
            
        } else{
            //@todo tratar erros
            print_r($this);
        }
    }

    //retorna a URL completa da ação e argumentos definidos.
    public function getActionUrl(){
        return WPPosts::API_URL.'/'.$this->action.'/'.$this->args;
    }

    // abre e lê o conteúdo do arquivo JSON e armazena na propriedade data.
    public function openJsonFile(){
        $handle = fopen(__DIR__.'/json/dados.json', 'r');
        $this->data = fread($handle, filesize(__DIR__.'/json/dados.json'));
        fclose($handle);
    }

    //salva a resposta da API em um arquivo JSON, com base na ação definida.
    public function saveAsJsonFile(){
        if($this->action == 'posts'){
            $handle = fopen(__DIR__.'/json/dados.json', 'w');
            fwrite($handle, $this->response);
            fclose($handle);
        }else{
            $handle = fopen(__DIR__.'/json/comments.json', 'w');
            fwrite($handle, $this->response);
            fclose($handle);
        } 
    }

    // lê a data e hora da última solicitação de um arquivo JSON, verifica se a solicitação atual foi feita após o intervalo definido e,
    // se sim, atualiza a data e hora no arquivo JSON.
    public function saveLastAccess(){
        $json = file_get_contents(__DIR__.'/json/data-requisicao.json');
        $data = json_decode($json);
        if(!empty($data)){
            if($data->date + $this->freshnessInterval < $this->timestamp){
                $handle = fopen(__DIR__.'/json/data-requisicao.json', 'w');
                fwrite($handle, '{"date":'.$this->timestamp.'}');
                fclose($handle);
                $this->lastIntegration = $this->timestamp;

            }else{
                $this->lastIntegration = $data->date;
            }
        }
        else{
            $handle = fopen(__DIR__.'/json/data-requisicao.json', 'w');
            fwrite($handle, '{"date":'.$this->timestamp.'}');
            fclose($handle);
            $this->lastIntegration = $this->timestamp;
            $this->lastIntegration = $this->timestamp;
        }
    }

    // registra acesso a página 
    public function log(){
        $handle = fopen(__DIR__.'/json/log.txt', 'a');
        fwrite($handle, '[Requisição | '.$this->action.' '.date('d/m/Y H:i:s').'] - Status: '.$this->httpcode.''."\r\n");
        fclose($handle);
    }

    // recebe um ID de postagem e retorna o número de comentários para essa postagem, lendo o arquivo comments.json correspondente.
    public  function commentsCount($id){
        $json = file_get_contents(__DIR__.'/json/comments.json');
        $data = json_decode($json);
        if(!empty($data)){
            $total = 0;
            foreach($data as $comment){
                if($comment->post == $id){
                    $total++;
                }
            }
        }
        return $total;
    }

    //recebe um objeto de postagem e uma classe adicional opcional e gera o HTML para exibir uma miniatura de postagem com a imagem,
    // título e link da postagem, além do número de comentários e data de publicação.
    public  function creatCard($content, $classAdicional = ''){
       
        $imgSmall = $content->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->medium->source_url;
        $imgFull = $content->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->full->source_url;
        if(!empty($classAdicional)){
            $imgLarge = $content->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->large->source_url;
        }else{
            $imgLarge = $content->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->medium->source_url;
        }
        
        

        //print_r($content);



        $comments = $this->commentsCount($content->id);

                
        $card = '';
        ob_start();
        ?>
        <div class="card-video <?php echo $classAdicional ;?> ">
            <a class="thumb" target="_blank" href="<?php echo $content->link ;?>" rel="noopener noreferrer" title="<?php echo $content->title->rendered;?>">
                <picture>
                    <source srcset="<?php echo $imgLarge;?>" media="(min-width: 1200px)"/>
                    <source srcset="<?php echo $imgSmall;?>" media="(min-width: 768px)"/>
                    <img alt="<?php echo $content->title->rendered ;?>" src="<?php echo  $imgFull;?>"/>
                </picture>
                <i class="ico play"></i>
                <div class="box-comments"><i class="ico comments"></i><?php echo $comments; ?></div>
            </a>

            <div class="infos">
                <?php if(!empty($content->_embedded->{'wp:term'})):
                    $cat = $content->_embedded->{'wp:term'}[0][0]->name;
                    $link = $content->_embedded->{'wp:term'}[0][0]->link; ?>
                    <a href="<?php echo $link  ;?>" target="_blank"  rel="noopener noreferrer" title="<?php echo $cat ;?>" class="size-hat cat"><?php echo $cat ;?></a>
                <?php endif; ?>
                <a rel="noopener noreferrer" target="_blank" href="<?php echo $content->link ;?>" title="<?php echo $content->title->rendered;?>">
                    <h2><?php echo $content->title->rendered;?></h2>
                </a>
            </div>
        </div>
        <script>window.addEventListener('load', renderCarrossel);</script>
        
        <?php 
        $card .= ob_get_contents();
        ob_end_clean();
        return $card;
    }
}
