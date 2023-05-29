

function k(a) {
    a.stopPropagation();
    a.preventDefault();
    a.target.className = "dragover" == a.type ? "hover" : ""
}

function l(a) {
    k(a);
    a = a.target.files || a.dataTransfer.files;
    for (var f = 0, e; e = a[f]; ++f) m(e)
}

function p() {
    document.getElementById("the-file-input").click()
}

function m(a) {
    cc(a);
}

$('.music-file').change(function(){

    window.currentMusicForTempo = $(this);
    m($(this)[0].files[0]);
});
if (window.File && window.FileList && window.FileReader) {
    
}

function r(a) {
    for (var f = a[0].length / 22050, e = [], g = 0; g < f; g++) {
        for (var h = 0, d = 22050 * g; d < 22050 * (g + 1); d++) {
            var n = Math.max(Math.abs(a[0][d]), Math.abs(a[1][d]));
            if (!h || n > h.volume) h = {
                position: d,
                volume: n
            }
        }
        e.push(h)
    }
    e.sort(function(a, g) {
        return g.volume - a.volume
    });
    e = e.splice(0, .5 * e.length);
    e.sort(function(a, g) {
        return a.position - g.position
    });
    return e
}

function t(a) {
    var f = [];
    a.forEach(function(e, g) {
        for (var h = 1; g + h < a.length && 10 > h; h++) {
            for (var d = {
                    a: 2646E3 / (a[g + h].position - e.position),
                    count: 1,
                    position: e.position,
                    volume: e.volume
                }; 90 > d.a;) d.a *= 2;
            for (; 180 < d.a;) d.a /= 2;
            d.a = Math.round(d.a);
            f.some(function(a) {
                return a.a === d.a ? a.count++ : 0
            }) || f.push(d)
        }
    });
    return f
}

function cc(a){

    var f = new FileReader;
    f.onload = function(a) {
        u(a.target.result)
    };
    f.readAsArrayBuffer(a)
}

function u(a) {
    window.b || (window.b = new AudioContext);
    var f = new OfflineAudioContext(2, 288E4, 44100);
    f.oncomplete = function(a) {
        a = a.renderedBuffer;
        a = r([a.getChannelData(0), a.getChannelData(1)]);
        a = t(a).sort(function(a, d) {
            return d.count - a.count
        });
        if(typeof window.currentMusicForTempo !== typeof undefined && window.currentMusicForTempo !== false){

            var music = window.currentMusicForTempo;
            $(music).parent().find('input[name="bpm"]').prop("readonly", true).val(a[0].a);
        }
    };
    var e = a.byteLength;
    288E4 < e && (e = 288E4);
    window.b.decodeAudioData(a.slice(0, e), function(a) {
        var e = f.createBufferSource();
        e.buffer = a;
        a = f.createBiquadFilter();
        a.type = "lowpass";
        a.frequency.value = 150;
        a.Q.value = 1;
        e.connect(a);
        var d = f.createBiquadFilter();
        d.type = "highpass";
        d.frequency.value = 100;
        d.Q.value = 1;
        a.connect(d);
        a.connect(f.destination);
        e.start(0);
        f.startRendering()
    }, function(a) {
        console.log(a)
    })
};