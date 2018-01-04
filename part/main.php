<?php
function Main() { ?>
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
                    <li class="active"><a href="/">Главная</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid content">
        <h2 class="text-center header-text">New Paste</h2>
        <div class="form-group">
            <textarea class="form-control code-area" rows="20" title="New Paste"></textarea>
        </div>
        <div class="controls">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="name">Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" placeholder="Untitled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="lang">Language:</label>
                            <div class="col-sm-8">
                                <select id="lang" class="language_select"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-6 col-md-2">
                    <button type="button" class="submit pull-right btn btn-success btn-block" onclick="submit()">
                        <span>Submit</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submit() {
            var source = $('.code-area').val(),
                name = $('#name').val(),
                lang = $('#lang').val();
            if(name === "") name = "Untitled";

            $.ajax('/script/createPaste.php', {
                data: {
                    source: source,
                    name: name,
                    lang: lang,
                    flag: 'bot'
                },
                type: "post",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if(data.success) {
                        location.href = "/" + data.id;
                    } else {
                        alert("НАПОМНИТЕ ЭТОМУ ДАУНУ ДОПИСАТЬ ЭТОТ МУСОР");
                    }
                }
            })
        }

        var langSelectData = {
            data: [{
                id: 'auto',
                text: 'Auto'
            }, {
                id: 'text',
                text: "Plain Text"
            }, {
                id: 'nul',
                text: "Loading..",
                disabled: true
            }]
        };

        var languageSelect = $('.language_select').select2(langSelectData);

        $.ajax('/script/getLang.php', {
            dataType: "json",
            success: function(data) {
                data.data.unshift({
                    id: 'auto',
                    text: 'Auto'
                });

                languageSelect.select2('destroy').empty().select2(data);
                languageSelect.val("auto");
                languageSelect.trigger('change');
            }
        });


        $(function enableTabIndentation() {
            $('.code-area').on('keydown', function(e) {
                var keyCode = e.keyCode || e.which;

                if (keyCode === 9) {
                    e.preventDefault();

                    var start = $(this).get(0).selectionStart;
                    var end = $(this).get(0).selectionEnd;

                    $(this).val($(this).val().substring(0, start)
                        + "\t"
                        + $(this).val().substring(end));

                    $(this).get(0).selectionStart =
                        $(this).get(0).selectionEnd = start + 1;
                }
            });
        });
    </script>
<?php }