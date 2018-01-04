onmessage = function(event) {
    importScripts('highlight.pack.js');
    self.hljs.configure({
        tabReplace: '    ',
        useBR: true
    });

    var result = {};
    var source = event.data;
    if(source.lang === 'auto') {
        result = self.hljs.highlightAuto(source.source);
    } else {
        result = self.hljs.highlight(source.lang, source.source, true);
    }

    postMessage(result);
};