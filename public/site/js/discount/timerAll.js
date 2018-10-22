$(function () {
    timer_all();
})

function timer_all() {
    $('.slider-akcii__content__timer').each(function(){
        var IdTimer = $(this).find('.DateTimer').attr('id');
        var Id = IdTimer.slice(5);
        var Date = $(this).find('.DateTimer').attr('datetime');
        timer(Id,Date);
    })
}


function timer(id,date) {
    (function () {
            var _id = id;
            var _t = document.createElement("script");
            _t.src = "/js/discount/timer.js";
        if ($(window).width() > 374) {
            var f = function (k) {
                var dateTime = Date.parse(date);
                var l = new MegaTimer(_id, {
                        "view": [1, 1, 1, 1], "type": {
                            "currentType": "1", "params": {
                                "usertime": true, "tz": "3", "utc": dateTime
                            }
                        }
                        , "design": {
                            "type": "circle", "params": {
                                "width": 6,
                                "radius": "31",
                                "line": "solid",
                                "line-color": "#ff9230",
                                "background": "solid",
                                "background-color": "#dadada",
                                "direction": "direct",

                                "number-font-size": "22",
                                "number-font-family": "Montserrat-SemiBold",
                                "number-font-color": "#434343",
                                "separator-margin": "7",
                                "separator-on": false,
                                "separator-text": ":",
                                "text-on": true,
                                "text-font-size": "11",
                                "text-font-color": "#434343"
                            }
                        }
                        , "designId": 8, "theme": "white", "width": 386, "height": 86
                    }
                );
                if (k != null) l.run();
            }
        }
        else{
            var f = function (k) {
                var dateTime = Date.parse(date);
                var l = new MegaTimer(_id, {
                        "view": [1, 1, 1, 1], "type": {
                            "currentType": "1", "params": {
                                "usertime": true, "tz": "3", "utc": dateTime
                            }
                        }
                        , "design": {
                            "type": "circle", "params": {
                                "width": "7",
                                "radius": "35",
                                "line": "solid",
                                "line-color": "#ff9230",
                                "background": "solid",
                                "background-color": "#dadada",
                                "direction": "direct",

                                "number-font-size": "18",
                                "number-font-family": "Montserrat-SemiBold",
                                "number-font-color": "#434343",
                                "separator-margin": "7",
                                "separator-on": false,
                                "separator-text": ":",
                                "text-on": true,
                                "text-font-size": 9,
                                "text-font-color": "#434343"
                            }
                        }
                        , "designId": 8, "theme": "white", "width": 386, "height": 86
                    }
                );
                if (k != null) l.run();
            }
        }
            ;
            _t.onload = f;
            _t.onreadystatechange = function () {
                if (t.readyState == "loaded") f(1);
            }
            ;
            var _h = document.head || document.getElementsByTagName("head")[0];
            _h.appendChild(_t);
        }
    ).call(this);
}


















//
//
//
//
//
//
//
//
// (function() {
//     var _id = "96db886752a810b6e35a4956f65c99";
//     // while (document.getElementById("timer" + _id)) _id = _id + "0";
//     // document.write("<div id='timer" + _id + "' style='min-width:216px;height:48px;'></div>");
//     var idTimer =  $('.timer1').attr('id');
//     var _t = document.createElement("script");
//     var timerDate =  $('.timer1').attr('datetime');
//     console.log(timerDate);
//     _t.src = "plugin/timer/timer.min.js";
//     var _f = function(_k) {
//
//         // while (document.getElementById("timer" + _id)) _id = _id + "0";
//         // document.write("<div id='timer" + _id + "' style='min-width:216px;height:48px;'></div>");
//         // var _t = document.createElement("script");
//         // _t.src = "http://megatimer.ru/timer/timer.min.js";
//         // var _f = function(_k) {
//
//
//
//
//
//
//
//
//         var l = new MegaTimer(idTimer, {
//             "view": [1, 1, 1, 1],
//             "type": {
//                 "currentType": "2",
//                 "params": {
//                     "startByFirst": false,
//                     "days": "20",
//                     "hours": "10",
//                     "minutes": "5",
//                     "utc": Date.parse(timerDate)
//                 }
//             },
//             "design": {
//                 "type": "circle",
//                 "params": {
//                     "width": "4",
//                     "radius": "19",
//                     "line": "solid",
//                     "line-color": "#ffa24d",
//                     "background": "solid",
//                     "background-color": "#d9d9d9",
//                     "direction": "direct",
//                     "number-font-family": {
//                         "family": "Open Sans",
//                         "link": "<link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"
//                     },
//                     "number-font-size": "15",
//                     "number-font-color": "#000000",
//                     "separator-margin": "4",
//                     "separator-on": false,
//                     "separator-text": ":",
//                     "text-on": true,
//                     "text-font-family": {
//                         "family": "Open Sans",
//                         "link": "<link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"
//                     },
//                     "text-font-size": "8",
//                     "text-font-color": "#666666"
//                 }
//             },
//             "designId": 8,
//             "theme": "black",
//             "width": 216,
//             "height": 48
//         });
//         l.run();
//     };
//     _t.onload = _f;
//     _t.onreadystatechange = function() {
//         if (_t.readyState == "loaded") _f(1);
//     };
//     var _h = document.head || document.getElementsByTagName("head")[0];
//     _h.appendChild(_t);
// }).call(this);