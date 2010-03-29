addInitEvent(function() {
    var pages = getElementsByClass('page', document, 'div');
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
        if (this.overlay) {
            this.overlay.style.display='';
            return;
        }
        this.overlay = insitu_popup(this, 'usercontact__overlay_' + (id++));
        this.overlay.className += ' usercontact_overlay';
        this.overlay.appendChild(new ajax_loader.Loader('usercontact', {name: this.title.match(regex)[1]}));
        ajax_loader.start();
    }

    function event_handler (delay) {
        return function (e) {
            delay.start.call(delay, this, e);
        };
    }

    var links = pages[0].getElementsByTagName('a');
    for (var link = 0 ; link < links.length ; ++link) {
        var match = links[link].title.match(regex);
        if (!match) continue;
        if (!links[link].className.match(/wikilink/)) continue;
        var timer = new Delay(show_overlay);
        addEvent(links[link], 'mouseover', event_handler(timer, 300));
        addEvent(links[link], 'mouseout', bind(function (timer) { timer.delTimer(); }, timer));
    }
});
