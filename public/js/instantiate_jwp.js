
window.jwp = function(container, fileID, autoPlay, mute, title, description, repeat, playback, controls) {
    window.jwplayer(container).setup({
        "file":"https:\/\/www.googleapis.com\/drive\/v3\/files\/"+fileID+"?alt=media&key=AIzaSyBsnu1IPOmoTvjxiF2Z_A4dyJG1enUYCU8",
        "image":"https:\/\/drive.google.com\/thumbnail?id="+fileID+"&authuser=0&sz=w640-h360-n-k-rw",
        "title":title,
        "description":description,
        "mediaid":fileID,
        "type":"mp4",
        "mute":mute,
        "autostart":autoPlay,
        "nextupoffset":-10,
        "repeat":repeat,
        "abouttext":"1Platform TV",
        "aboutlink":"https:\/\/www.1platform.com\/",
        "playbackRateControls":playback,
        "playbackRates":[0.25,0.5,0.75,1,1.25,1.5,1.75,2],
        "defaultBandwidthEstimate":false,
        "controls":controls,
        "aspectratio":"1:0.565",
        "localization":false,
        "height":false,
        "width":"100%",
        "displaytitle":true,
        "displaydescription":true,
        "stretching":"uniform",
        "nextUpDisplay":false,
        "qualityLabels":false,
        "base":"https:\/\/ssl.p.jwpcdn.com\/player\/v\/8.3.3\/",
        "preload":"metadata",
        "flashplayer":"https:\/\/ssl.p.jwpcdn.com\/player\/v\/8.3.3\/",
        "hlsjsdefault":true,
        "skin":{
            "controlbar":{
                "text":"#FFFFFF",
                "icons":"rgba( 255, 255, 255, 0.8 )",
                "iconsActive":"#FFFFFF",
                "background":"rgba( 0, 0, 0, 0 )"
            },
            "timeslider":{
                "progress":"#F2F2F2",
                "rail":"rgba( 255, 255, 255, 0.3 )"
            },
            "menus":{
                "text":"rgba( 255, 255, 255, 0.8 )",
                "textActive":"#FFFFFF",
                "background":"#333333"
            },
            "tooltips":{
                "text":"#000000",
                "background":"#FFFFFF"
            },
            "url":false,
            "name":false
        },
        "renderCaptionsNatively":false,
        "captions":{
            "color":"#FFFFFF",
            "fontSize":15,
            "fontFamily":"sans",
            "fontOpacity":100,
            "backgroundColor":"#000000",
            "backgroundOpacity":75,
            "edgeStyle":"none",
            "windowColor":"#000000",
            "windowOpacity":0
        },
    });
};