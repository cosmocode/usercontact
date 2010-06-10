addInitEvent(function() {
    var pages = getElementsByClass('content', document, 'div');
    if (pages.length === 0) {
        return;
    }
    var regex = new RegExp(JSINFO.plugin.usercontact.users_namespace);

    var id = 0;

    function show_overlay() {
        var overlays = getElementsByClass('usercontact_overlay', document, 'div');
        for (var i = 0; i < overlays.length ; ++i) {
            overlays[i].style.display = 'none';
        }
        if (this.usercontact__overlay) {
            this.usercontact__overlay.style.display='';
            return;
        }
        this.usercontact__overlay = insitu_popup(this, 'usercontact__overlay_' + (id++));
        this.usercontact__overlay.className += ' usercontact_overlay';
        this.usercontact__overlay.appendChild(new ajax_loader.Loader('usercontact', {name: this.usercontact__name}));
        ajax_loader.start();
    }

    function event_handler (delay) {
        return function (e) {
            delay.start.call(delay, this, e);
        };
    }

    var links = pages[0].getElementsByTagName('a');
    for (var link = 0 ; link < links.length ; ++link) {
        var match = links[link].href.replace(/\//g, ':').match(regex);
        if (!match) continue;
        links[link].usercontact__name = match[1];
        var timer = new Delay(show_overlay);
        addEvent(links[link], 'mouseover', event_handler(timer, 300));
        addEvent(links[link], 'mouseout', bind(function (timer) { timer.delTimer(); }, timer));
    }
});
