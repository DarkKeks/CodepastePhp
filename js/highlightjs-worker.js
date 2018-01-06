onmessage = function (event) {
    importScripts('/js/highlight.pack.js');
    self.hljs.configure({
        tabReplace: '    ',
        useBR: true
    });

    var result = {};
    var source = JSON.parse(event.data);
    if(source.lang === 'auto') {
        result = self.hljs.highlightAuto(source.source);
    } else {
        result = self.hljs.highlight(source.lang, source.source, true);
    }
    result = self.hljs.fixMarkup(result.value);

    postMessage(result);
};