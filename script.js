addInitEvent(function() {
    var regex = new RegExp(JSINFO.plugin.usercontact.users_namespace + ':([^:/]+)');

    function mouveout(e) {
        var p = e.explicitOriginalTarget;
        while (p && p !== this) {
            p = p.parentNode;
        }
        if (p === this) {
            return;
        }
        this.style.display = 'none';
    }

    function show_overlay() {
        if (this.overlay) {
            this.overlay.style.display='';
            return;
        }
        this.overlay = document.createElement('div');
        this.overlay.className = 'usercontact_overlay JSpopup insitu-footnote';
        this.overlay.appendChild(new ajax_loader.Loader('usercontact', {name: this.title.match(regex)[1]}));
        addEvent(this.overlay, 'mouseout', mouveout);
        this.parentNode.insertBefore(this.overlay, this.nextSibling);
        ajax_loader.start();
    }

    var links = getElementsByClass('page', document, 'div')[0].getElementsByTagName('a');
    for (var link = 0 ; link < links.length ; ++link) {
        var match = links[link].title.match(regex);
        if (!match) continue;
        if (!links[link].className.match(/wikilink/)) continue;
        addEvent(links[link], 'mouseover', show_overlay);
    }
});