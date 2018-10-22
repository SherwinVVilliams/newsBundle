$(function () {
    timer_all_small();
})

function timer_all_small() {
    $('.timer__blog').each(function(){
        var IdTimer = $(this).find('.DateTimer_small').attr('id');
        var Id = IdTimer.slice(5);
        var Date = $(this).find('.DateTimer_small').attr('datetime');
        timer_small(Id,Date);
    })
}


function timer_small(id,date) {
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
                                "width": "5",
                                "radius": "25",
                                "line": "solid",
                                "line-color": "#ff9230",
                                "background": "solid",
                                "background-color": "#dadada",
                                "direction": "direct",
                                "number-font-size": "20",
                                "number-font-family": "Montserrat-SemiBold",
                                "number-font-color": "#434343",
                                "separator-margin": "7",
                                "separator-on": false,
                                "separator-text": ":",
                                "text-on": true,
                                "text-font-size": "9",
                                "text-font-color": "#434343"
                            }
                        }
                        , "designId": 8, "theme": "white", "width": 240, "height": 56
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
                                "width": "6",
                                "radius": "25",
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
                                "text-font-size": "9",
                                "text-font-color": "#434343"
                            }
                        }
                        , "designId": 8, "theme": "white", "width": 240, "height": 56
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






