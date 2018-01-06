<?php
function Source() {
    $id = $_GET['q'];
    $source = GetSource($id);
    if($source === false) {
        header("Location: /");
    }
    unset($source['id']);
    $source = addslashes(json_encode($source));
    ?>

    <div class="cssload-loader">
        <div class="cssload-top">
            <div class="cssload-square">
                <div class="cssload-square">
                    <div class="cssload-square">
                        <div class="cssload-square">
                            <div class="cssload-square"><div class="cssload-square">
                                </div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cssload-bottom">
            <div class="cssload-square">
                <div class="cssload-square">
                    <div class="cssload-square">
                        <div class="cssload-square">
                            <div class="cssload-square"><div class="cssload-square">
                                </div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cssload-left">
            <div class="cssload-square">
                <div class="cssload-square">
                    <div class="cssload-square">
                        <div class="cssload-square">
                            <div class="cssload-square"><div class="cssload-square">
                                </div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cssload-right">
            <div class="cssload-square">
                <div class="cssload-square">
                    <div class="cssload-square">
                        <div class="cssload-square">
                            <div class="cssload-square"><div class="cssload-square">
                                </div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>var source = JSON.parse("<?=$source ?>")</script>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><img src="/favicon.png"></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="/">Главная</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid content">
        <h2 class="text-center header-text"></h2>
        <div class="code-area">
            <pre><code class="code hljs"></code></pre>
        </div>
        <h3 class="text-center header-text">
            <a class="raw-link" href="#">
                <span class="link glyphicon glyphicon-link" aria-hidden="true"></span>
            </a>
            Raw code
        </h3>
        <div class="form-group">
            <textarea class="form-control raw code-area" rows="20" readonly title="Raw code"></textarea>
        </div>
    </div>

    <script>
        $(function() {
            $('.raw').val(source.source);
            $('.header-text').first().text(source.name);
            $('.raw-link').attr('href', 'http://raw.codepaste.me/' + source.alias);

            if(source.flag === 'bot') {
                $('.header-text').first().append($('<sup>')
                    .addClass('through-bot')
                    .append($('<a>', {
                            'href': 'https://telegram.me/codepaste_bot',
                            'target': '_blank'
                        })
                        .append($('<img>', {
                            'src': '/css/telegram-icon.png'
                        }))
                        .append('bot')
                    ));
            }

            highlight(source);
        });

        function highlight(source) {
            var worker = new Worker('/js/highlightjs-worker.js');

            worker.onmessage = function (ev) {
                $('.code').html(ev.data).each(function(i, block) {
                    hljsNumbers.lineNumbersBlock(block);
                });

                var rowCount = $('.hljs-ln-numbers').length;
                if(rowCount === 0) rowCount = 1;
                $('.raw').attr('rows', Math.min(rowCount, 20));

                setTimeout(function() {
                    $('.cssload-loader').addClass("disabled");
                    $('.cssload-square').addClass("disabled");
                    setTimeout(function() {
                        $('.cssload-loader').hide();
                    }, 250);
                }, 50);
            };
            worker.postMessage(JSON.stringify(source));
        }
    </script>

    <script src="/js/to-top.js"></script>
    <button class="to-top"><span class="checkmark"></span></button>

<?php }

function GetSource($id) {
    $pdo = DBConnect();
    $getSource = $pdo->prepare("SELECT * FROM source WHERE alias = :id");
    $getSource->execute(array(
        ":id" => $id
    ));
    return $getSource->fetch();
}